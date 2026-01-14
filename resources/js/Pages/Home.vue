<script setup>
import { ref, onMounted } from 'vue'
import { router } from '@inertiajs/vue3'
import MovieCard from "@/Components/MovieCard.vue";

defineProps({
    movies: {
        type: Array,
        default: () => []
    },
    error: {
        type: String,
        default: null
    },
    initialLoad: {
        type: Boolean,
        default: false
    }
})

const loading = ref(false)
const localMovies = ref([])

onMounted(() => {
    if (!initialLoad) {
        loadMovies()
    }
})
async function loadMovies() {
    loading.value = true
    try {
        // Możesz też użyć Inertia do przeładowania strony
        router.reload({
            only: ['movies'],
            preserveScroll: true
        })
    } finally {
        loading.value = false
    }
}
</script>

<template>
    <Head :title="`| ${$page.component}`" />

    <div>
        <h1 class="title ">
            MovieTracker
        </h1>
    </div>
    <h1>Popular Movies</h1>
    <div v-if="error" class="error">
        {{ error }}
    </div>

    <!-- Loader -->
    <div v-if="loading" class="loading">
        Loading movies...
    </div>

</template>

<style scoped>

</style>
