<script setup>
import { onMounted, ref } from "vue";
import { router } from "@inertiajs/vue3";
import PopularMovieSlider from "@/Components/PopularMovieSlider.vue";
const props = defineProps({
    movies:{
        type: Object,
        default: () => ({ titles:[] })
    },
    error: {
        type: String,
        default: null
    }
})

const loading = ref(false)
const selectedCountry = ref('')


onMounted(() => {
    if(!props.movies.titles || props.movies.titles.length===0){
        fetchPopular()
    }
})
const fetchPopular = (country = '') => {
    loading.value = true

    router.get(route('movies.popular'), {
        country: country
    }, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            loading.value = false
        },
        onError: () => {
            loading.value = false
        },
        onFinish: () => {
            loading.value = false
        }
    })
}

</script>

<template>
    <Head :title="`| ${$page.component}`" />

    <div class="titleDiv">
        <h1 class="title">
            MovieTracker
        </h1>
        <img class="logo" src="../../img/movie_tracker.svg" alt="movie_logo">
    </div>
    <h1 class="subtitle">Popular now</h1>
    <div v-if="error" class="error">
        {{ error }}
    </div>


    <div v-if="loading" class="loading">
        Loading popular now...
    </div>
    <PopularMovieSlider if="movies.titles && movies.titles.length > 0" :movies="movies" :error="error" />



</template>

