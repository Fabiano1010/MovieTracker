<script setup>
import { onMounted, ref } from "vue";
import { router } from "@inertiajs/vue3";
import MoviesPopular from "@/Components/MoviesPopular.vue";

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

    <div>
        <h1 class="title">
            MovieTracker
        </h1>
    </div>
    <h1 class="subtitle">Popular now</h1>
    <div v-if="error" class="error">
        {{ error }}
    </div>


    <div v-if="loading" class="loading">
        Loading popular now...
    </div>
    <div class="moviePopularContaier" v-if="movies.titles && movies.titles.length > 0">
        <MoviesPopular v-for="movie in movies.titles"
            :key="movie.id"
            :id="movie.id"
            :titleOriginal="movie.originalTitle"
            :titlePrimary="movie.primaryTitle"
            :date="movie.startYear"
            :img="movie.primaryImage?.url || ''"
        />
    </div>



</template>

