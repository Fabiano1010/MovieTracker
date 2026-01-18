<script setup>

import { onMounted, onUnmounted, ref , watch } from 'vue';
import {router, useForm, usePage} from '@inertiajs/vue3';
import UserMovieCard from "@/Components/UserMovieCard.vue";
const page = usePage();

const props = defineProps({
    movies:{
        type: Object,
        default: () => ({ titles:[] })
    },
    error: {
        type: String,
        default: null
    },
    processing:  true,
})

const form = useForm({
    selectedStatus: '',
    fav: false,
    sortOption: 'desc'

})


const loading = ref(false)
const currentPage = ref(1)
const containerRef = ref(null)
const allMovies = ref([])
const isProcessing = ref(props.processing)
const fetchData = (page = 1, append = false, reset = false) => {
    loading.value = true
    if(reset) currentPage.value = 1
    router.get(route('movies.index'), {
        status: form.selectedStatus,
        sort_order: form.sortOption,
        is_favourite: form.fav,
        page: page

    }, {
        preserveState: true,
        preserveScroll: false,
        onSuccess: (page) => {
            if (append) {

                allMovies.value = [...allMovies.value, ...page.props.movies.data]
            } else {

                allMovies.value = page.props.movies.data
            }
            isProcessing.value = false
            loading.value = false
        },
        onError: () => {
            isProcessing.value = false
            loading.value = false
        },
        onFinish: () => {
            isProcessing.value = false
            loading.value = false
        }

    })
}

const loadMore = () => {
    if (loading.value || !props.movies.next_page_url) return

    currentPage.value++
    fetchData(currentPage.value, true,false)
}

const handleScroll = (e) => {
    const element = e.target
    const bottomOfContainer = element.scrollHeight - element.scrollTop <= element.clientHeight + 100

    if (bottomOfContainer) {
        loadMore()
    }
}

onMounted(() => {

    containerRef.value = document.getElementById('userContainer')

    if (containerRef.value) {

        containerRef.value.addEventListener('scroll', handleScroll)
    }
    fetchData();
})

onUnmounted(() => {
    if (containerRef.value) {
        containerRef.value.removeEventListener('scroll', handleScroll)

    }
})



</script>
<template>
    <div>
        <div>
            <h1 class="title" v-if="$page.props.auth.user.username">Welcome back {{ $page.props.auth.user.username }}!</h1>
        </div>
        <div>
            <h1 class="subtitle" v-if="$page.props.auth.user.username">Your movies</h1>
        </div>

        <div>
            <form @submit.prevent="fetchData(1,false,true)" class="movieForm">
                <select v-model="form.selectedStatus">
                    <option selected value="">All</option>
                    <option value="to_watch">To watch</option>
                    <option value="in_progress">In progress</option>
                    <option value="watched">Finished</option>
                </select>
                <div class="checkboxDiv">
                    <input type="checkbox" id="remember" v-model="form.fav">
                    <label for="remember">Favourite</label>
                </div>
                <div class="movieFormRadio">
                    <p>
                        <input type="radio" id="sortDesc" v-model="form.sortOption" value="desc"> Descending
                    </p>
                    <p>
                        <input type="radio" id="sortAsc" v-model="form.sortOption" value="asc"> Ascending
                    </p>
                </div>
                <div class="btnSectionUser">
                    <button class="primary-btn">Apply</button>
                </div>
            </form>
        </div>

        <div v-if="props.processing" class="loading">
            Loading movies...
        </div>
        <div v-if="page.flash.success" class="detailsMessage">
            {{ page.flash.success }}
        </div>
        <div v-if="page.flash.error" class="detailsMessage error ">
            {{ page.flash.error }}
        </div>
        <div v-if="$page.props.errors" class="detailsMessage error ">
            {{ $page.props.errors.status }}
        </div>
        <div id="userContainer" class="movieCardContainer userMoviesContainer" v-if="props.movies?.data?.length">
            <UserMovieCard v-for="movie in allMovies"
                           :key="movie.movie_id"
                           :id="movie.movie_id"
                           :titleOriginal="movie.original_title  || ''"
                           :titlePrimary="movie.primary_title  || ''"
                           :date="String(movie.start_year)  || ''"
                           :img="movie.primary_img || ''"
                           :movieStatus="movie.status"
                           :comment="movie.comment"
                           :userRating="movie.user_rating"
                           :fav="movie.is_favourite"
            />
        </div>
        <div v-else>
            <p class="dashboardEmpty"> Add some movies already!</p>
        </div>

        <div v-if="loading" class="loading" style="text-align: center; padding: 20px;">
            Loading more movies...
        </div>
    </div>
</template>

<style scoped>

</style>
