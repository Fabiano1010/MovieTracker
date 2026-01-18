<script setup>

import {onMounted, onBeforeUnmount, ref , computed} from 'vue';
import {router, useForm} from '@inertiajs/vue3';
import UserMovieCard from "@/Components/UserMovieCard.vue";

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
const fetchData = () => {
    loading.value = true
    router.get(route('movies.index'), {
        status: form.selectedStatus,
        sort_order: form.sortOption,
        is_favourite: form.fav,

        }, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            props.processing = false
        },
        onError: () => {
            props.processing = false
        },
        onFinish: () => {
            props.processing = false
        }

    })
}


onMounted(() => {
    {
        fetchData();
    }
})

</script>
<template>
    <div>
        <h1 class="title" v-if="$page.props.auth.user.username">Welcome back {{ $page.props.auth.user.username }}!</h1>
    </div>
    <div>
        <h1 class="subtitle" v-if="$page.props.auth.user.username">Your movies</h1>
    </div>

    <div>
        <form @submit.prevent="fetchData" class="movieForm">
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
    <div class="movieCardContainer userMoviesContainer" v-if="props.movies">
        <UserMovieCard v-for="movie in props.movies.data"
                   :id="movie.movie_id"
                   :titleOriginal="movie.original_title  || ''"
                   :titlePrimary="movie.primary_title  || ''"
                   :date="movie.start_year  || ''"
                   :img="movie.primary_img || ''"
                   :movieStatus="movie.status"
                   :comment="movie.comment"
                   :userRating="movie.user_rating"
                   :fav="movie.is_favourite"
        />
    </div>

</template>

<style scoped>

</style>
