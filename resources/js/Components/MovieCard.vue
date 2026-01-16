<script setup>
import {router, useForm} from "@inertiajs/vue3";


const props = defineProps({
    titleOriginal: {
        type: String,
        required: true
    },
    titlePrimary: {
        type: String,
        required: true
    },
    date: {
        type: String,
        required: true
    },
    id:{
        type: String,
        required: true
    },
    img:{
        default: "",
        type: String
    },
    errors: {
        type: String,
        default: null
    },
    message: String

})
console.log(props.searching)
const form = useForm({
    movieId: props.id,
    movieSearched: props.searching
});

const submit = () => {
    router.get(route('movies.title'), {
        id: form.movieId
    }, {
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
            props.errors = {};
        },
        onError: (err) => {
            props.errors = err;
            form.reset('title');
        }
    });
}

</script>

<template>
    <div class="movieCard">
        <div class="movieCardBody">
            <div class="movieCardImgDiv">
                <img class="movieCardImg" :src="img" :alt="titleOriginal" >
            </div>
            <div class="movieCardTitle">
                <div class="movieCardText">Original title: <p class="movieTitle">{{ titleOriginal }}</p> </div>
                <div class="movieCardText">Primary title: <p class="movieTitle">{{ titlePrimary }}</p> </div>
                <div class="movieCardText">Release date:  <p class="movieDate">{{ date }}</p></div>
            </div>
        </div>
        <div class="movieCardBtn">
            <form @submit.prevent="submit">
                <button class="primary-btn movieCardShowBtn" :disabled="form.processing">
                    Show
                </button>
            </form>
        </div>
    </div>
</template>


