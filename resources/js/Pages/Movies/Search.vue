<script setup>

import TextInput from "@/Components/TextInput.vue";
import {useForm, router} from "@inertiajs/vue3";
import MovieCard from "@/Components/MovieCard.vue";

import { ref } from 'vue';
const errors = ref({});
const form = useForm({
    title: '',
});

const submit = () => {
    router.get(route('movies.search'), {
        title: form.title
    },{
        preserveState: true,
        preserveScroll: true,
        replace: true,
        only: ['movies'],
        onStart: () => {
            form.processing = true;
        },
        onFinish: () => {
            form.processing = false;
        },
        onSuccess: () => {
            errors.value = {};
        },
        onError: (err) => {
            errors.value = err;
            form.reset('title');
        }
    });
}
const props = defineProps({
    movies: {
        type: Object,
        required: true,
        default: () => ({ titles: [] })
    },

})



</script>
<template>
    <div>
        <h1 class="title" v-if="$page.props.auth.user.username">Search</h1>
    </div>

    <div>
        <form @submit.prevent="submit" class="movieForm">

            <TextInput name="Search movies" v-model="form.title" placeholder="Title" class="movieSearchInput" :message="errors.title"/>
            <div class="movieSearchBtn">
                <button class="primary-btn" :disabled="form.processing" >Search</button>
            </div>
        </form>
    </div>

    <div v-if="form.processing" class="loading">
        Loading movies...
    </div>
    <div class="movieCardContainer" v-if="props.movies">
        <MovieCard v-for="movie in movies.titles"
                   :id="movie.id"
                   :titleOriginal="movie.originalTitle  || ''"
                   :titlePrimary="movie.primaryTitle  || ''"
                   :date="movie.startYear  || ''"
                   :img="movie.primaryImage?.url || ''"

        />
    </div>



</template>

<style scoped>

</style>
