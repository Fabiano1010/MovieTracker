<script setup>

import {onMounted, onBeforeUnmount, ref} from 'vue';
import { router } from '@inertiajs/vue3';
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
    processing:  true
})
const loading = ref(false)
const fetchData = () => {
    loading.value = true
    router.get(route('movies.index'), {
        // status: ''
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
        <form @submit.prevent="submit" class="movieForm">

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
