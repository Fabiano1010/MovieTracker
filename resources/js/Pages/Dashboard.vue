<script setup>

import TextInput from "@/Components/TextInput.vue";
import {useForm, router} from "@inertiajs/vue3";
import MovieCard from "@/Components/MovieCard.vue";

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
       only: ['movies']
    });
}
defineProps({
    movies: {
        type:Array,
        required: true,
        default: () => []
    }
})

</script>
<template>
    <div>
        <h1 class="title" v-if="$page.props.auth.user.username">Welcome back {{ $page.props.auth.user.username }}!</h1>
    </div>

    <div>
        <form @submit.prevent="submit" class="flex flex-row justify-center space-x-10 items-center">

            <TextInput name="Search movies" v-model="form.title" :message="form.errors.title" placeholder="Title" class="w-80"/>
            <div class="w-20 items-center">
                <button class="primary-btn w-20 h-10">Search</button>
            </div>
        </form>
    </div>


    <div class="overflow-auto flex flex-col  m-5 h-full max-h-150">
        <MovieCard v-for="movie in movies.titles"
                   :id="movie.id"
                   :titleOriginal="movie.originalTitle"
                   :titlePrimary="movie.primaryTitle"
                   :date="movie.startYear"
                   :img="movie.primaryImage"
        />
    </div>

</template>

<style scoped>

</style>
