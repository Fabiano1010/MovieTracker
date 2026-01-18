<script setup>
import {router, useForm} from "@inertiajs/vue3";
import {reactive} from "vue";


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

const mStatus=reactive({
    'to_watch': 'To watch',
    'in_progress': 'In progress',
    'watched': 'Movie watched',
})
const deleteMovie = () => {
    if (confirm('Are you sure you want to delete this movie?')) {

        console.log('Deleting movie ID:', props.id);
        console.log('Route:', route('user-movies.destroy', props.id));

        router.delete(route('movies.destroy', props.id), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: (page) => {
                console.log('Success response:', page);
                router.visit(window.location.pathname, {
                    preserveState: false,
                    preserveScroll: true
                })

            },
            onError: (errors) => {
                console.error('Error deleting movie:', errors);
                alert('Error: ' + (errors.message || 'Could not delete movie'));
            }
        });
    }
};

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
                <div class="movieCardText" v-if="props.fav===1"> <p class="movieDate fav">Favourite movie</p></div>
                <div class="movieCardText">Status: <p class="movieTitle">{{ mStatus[props.movieStatus] }}</p> </div>
                <div class="movieCardText">User rating: <p class="movieTitle">{{ props.userRating }}/10</p> </div>

            </div>
        </div>
        <div class="movieCardBtn">

            <form @submit.prevent="submit">
                <button class="primary-btn movieCardShowBtn" :disabled="form.processing">
                    Show
                </button>
            </form>
            <form @submit.prevent="deleteMovie">
                <button class="primary-btn movieCardShowBtn nav-link-logout" :disabled="form.processing">
                    Delete
                </button>
            </form>
        </div>
    </div>
</template>


