<script setup>

import MoviesPopular from "@/Components/MoviesPopular.vue";
import { ref, onMounted, onUnmounted, computed } from 'vue'

const props = defineProps({
    movies: {
        type: Object,
        required: true,
        default: () => ({ titles: [] })
    },
    error: {
        type: String,
        default: null
    }
})

const currentIndex = ref(0)
const visibleCount = 3
const isPaused = ref(false)
let intervalId = null


const moviesWithImg = computed(() => {
    if(!props.movies?.titles) return []
    return props.movies.titles.filter(movie => movie.primaryImage?.url)
})


const visibleMovies = computed(() => {
    if (moviesWithImg.value.length === 0) return []
    const result = []
    for (let i = 0; i < visibleCount; i++) {
        const index = (currentIndex.value + i) % moviesWithImg.value.length
        result.push(moviesWithImg.value[index])
    }

    return result
})

const nextGroup = () => {
    if (moviesWithImg.value.length === 0) return
    currentIndex.value = (currentIndex.value + visibleCount) % moviesWithImg.value.length
    resetAutoSlide()
}

const startAutoSlide = () => {
    if (moviesWithImg.value.length <= visibleCount) return
    intervalId = setInterval(nextGroup, 10000)
}

const resetAutoSlide = () => {
    clearInterval(intervalId)
    startAutoSlide()
}

onMounted(() => {
    startAutoSlide()
})

onUnmounted(() => {
    clearInterval(intervalId)
})


</script>

<template>

    <div class="moviePopularContaier" v-if="movies.titles && movies.titles.length > 0">
        <MoviesPopular
            v-for="(movie, index) in visibleMovies"
            :key="`${movie.id}-${currentIndex}-${index}`"
            :id="movie.id"
            :titleOriginal="movie.originalTitle || ''"
            :titlePrimary="movie.primaryTitle || ''"
            :date="movie.startYear || ''"
            :img="movie.primaryImage?.url || ''"
        />

    </div>

</template>

