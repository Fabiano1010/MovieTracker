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



const startAutoSlide = () => {
    if (moviesWithImg.value.length <= visibleCount) return
    intervalId = setInterval(nextGroup, 8000)
}

const resetAutoSlide = () => {
    clearInterval(intervalId)
    startAutoSlide()
}

// Animation

const isTransition = ref(false)

const onBeforeEnter = (el) => {
    el.style.transition = 'all 0.8s ease-in-out'
    el.style.opacity = '0'
    el.style.trasform = 'translateY(50px)'
}

const onEnter = (el, done) => {
    setTimeout(() => {
        el.style.transition = 'all 0.8s ease-in-out'
        el.style.opacity = '1'
        el.style.transform = 'translateY(0px)'
        done()
    },600)
}
const onLeave = (el, done) => {
    el.style.transition = 'all 0.8s ease-in-out'
    el.style.opacity = '0'
    el.style.transform = 'translateY(-50px)'
    setTimeout(done, 600)
}

const getMovieClass = (index) => {
    return{
        'center': index === 1,
        'left': index === 0,
        'right': index === 2,
        'transitioning': isTransition.value
    }
}


const nextGroup = () => {
    if (moviesWithImg.value.length === 0) return

    isTransition.value = true
    currentIndex.value = (currentIndex.value + visibleCount) % moviesWithImg.value.length

    setTimeout(() => {
        isTransition.value = false
    }, 600)

    resetAutoSlide()
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
        <transition-group
            name="fade-slide"
            tag="div"
            class="movies-transition-group"
            @before-enter="onBeforeEnter"
            @enter="onEnter"
            @leave="onLeave"
        >
            <MoviesPopular
                v-for="(movie, index) in visibleMovies"
                :key="`${movie.id}-${currentIndex}-${index}`"
                :id="movie.id"
                :titleOriginal="movie.originalTitle || ''"
                :titlePrimary="movie.primaryTitle || ''"
                :date="String(movie.startYear) || ''"
                :img="movie.primaryImage?.url || ''"
                :data-index="index"
                :class="getMovieClass(index)"
            />
        </transition-group>
    </div>

</template>

