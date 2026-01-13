<script setup>

import TextInput from "@/Components/TextInput.vue";
import {useForm, router} from "@inertiajs/vue3";
import MovieCard from "@/Components/MovieCard.vue";

const form = useForm({
    country: '',
});

const submit = () => {
    router.get(route('movies.popular'), {
        country: form.country
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
    <Head :title="`| ${$page.component}`" />

    <div class="title flex flex-row justify-center gap-3 items-center">
        <h1 >
            MovieTracker
        </h1>
        <img src="../../img/movietracker_white.svg" class="size-12 " alt="">
    </div>

</template>

<style scoped>

</style>
