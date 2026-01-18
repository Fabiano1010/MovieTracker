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
    message: String,

    movieStatus: String,
    userRating: Number,
    comment: String,
    fav: Number
})

const form = useForm({
    movieId: props.id,

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
    <div class="movieCard userMovieCard">
        <div class="movieCardBody userMovieCardBody">
            <div class="movieCardImgDiv userMovieCardImgDiv">
                <img class="movieCardImg userMovieCardImgDiv" :src="img" :alt="titleOriginal" >
            </div>
            <div class="movieCardUserInfo">
                <div class="movieCardText">Original title: <p class="movieTitle">{{ titleOriginal }}</p> </div>
                <div class="movieCardText">Primary title: <p class="movieTitle">{{ titlePrimary }}</p> </div>
                <div class="movieCardText">Release date:  <p class="movieDate">{{ date }}</p></div>
            </div>
            <div class="movieCardUserInfo">
                <div class="movieCardText">Status: <p class="movieTitle">{{ props.status }}</p> </div>
                <div class="movieCardText">User rating: <p class="movieTitle">{{ props.userRating }}</p> </div>
                <div class="movieCardText" v-if="props.fav===1"> <p class="movieDate">Favourite movie</p></div>
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


