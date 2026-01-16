<script setup>

import TextInput from "@/Components/TextInput.vue";

import { onMounted, onBeforeUnmount  } from 'vue';
import { router, useForm, usePage} from '@inertiajs/vue3';

const page = usePage();

const props = defineProps({

    movie: {
        type: Object,
        required: true,
        default: () => ({ titles: [] })
    },
    errors: {
        type: String,
        default: null
    },
    auth: {
        type: Object,
        default: () => ({ user: null })
    },
    message: String,


})

const form = useForm({
    userId: props.auth.user.id,
    movieId: props.movie.id,
    status: {
        type: String,
        required: true
    },
    rating: 1,
    comment: '',
});

const submit = () => {
    router.post(route('movies.store'), {
        user_id : form.userId,
        movie_id : form.movieId,
        status: form.status,
        user_rating: form.rating,
        comment: form.comment,

    }, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
        onStart: () => {
            form.processing = true;
        },
        onFinish: () => {
            form.processing = false;
        },
        onFlash: ({ message }) => {
            props.message = message
        },
        onSuccess: () => {
            form.movie_id = '';
            form.status = 'to_watch';
            form.user_rating = null;
            form.comment = '';
            props.errors = {};

        },
        onError: (err) => {
            props.errors.value = err;
            form.reset('title');
        }
    });
}

const handleKeydown = (event) => {
    if (event.key === 'Escape') {

        router.visit('/search')
    }
}
function formatSecondsToTime(seconds) {
    if (!seconds && seconds !== 0) return '00:00:00'

    const hrs = Math.floor(seconds / 3600)
    const mins = Math.floor((seconds % 3600) / 60)
    const secs = Math.floor(seconds % 60)

    const formatNumber = (num) => num.toString().padStart(2, '0')

    return `${formatNumber(hrs)}:${formatNumber(mins)}:${formatNumber(secs)}`
}
const clearFlash = () => {

    router.reload({
        only: [],
        preserveScroll: true,
        preserveState: true,
    })
}

onMounted(() => {

    document.addEventListener('keydown', handleKeydown)

})

onBeforeUnmount(() => {
    document.removeEventListener('keydown', handleKeydown)
})

</script>

<template>
    <div class="movieDetailContainer">
        <div class="movieDetailImgDiv">
            <img :src="movie.primaryImage?.url || ''" :alt="movie.originalTitle" class="movieDetailImg">
            <div class="movieCardTitle titlePopular movieDetailTitle">
                <div class="movieCardText " v-if="movie.originalTitle">Original title: <p class="movieTitle">{{ movie.originalTitle }}</p> </div>
                <div class="movieCardText " v-if="movie.primaryTitle">Primary title: <p class="movieTitle">{{ movie.primaryTitle }}</p> </div>
                <div class="movieCardText " v-if="movie.startYear">Release date:  <p class="movieDate">{{ movie.startYear }}</p></div>
            </div>
        </div>

        <div class="movieDetails">
            <div class="movieDetailsProps">
                <div class="movieDetailPlot" v-if="movie.plot">
                    Plot:
                    <p>{{ movie.plot }}</p>
                </div>
                <div class="movieDetailsPropsMore">
                    <div class="movieDetailGenres" v-if="movie.directors">
                        Directors:
                        <div class="movieDetailGenry" v-for="dir in movie.directors">
                            &#x2022; {{ dir.displayName }}
                        </div>
                    </div>
                    <div class="movieDetailGenres" v-if="movie.writers">
                        Writers:
                        <div class="movieDetailGenry" v-for="wr in movie.writers">
                            &#x2022; {{ wr.displayName }}
                        </div>
                    </div>
                    <div class="movieDetailGenres" v-if="movie.stars">
                        Stars:
                        <div class="movieDetailGenry" v-for="st in movie.stars">
                            &#x2022; {{ st.displayName }}
                        </div>
                    </div>

                    <div class="movieDetailGenres" v-if="movie.genres">
                        Genres:
                        <div class="movieDetailGenry" v-for="gen in movie.genres">
                            &#x2022; {{ gen }}
                        </div>
                    </div>
                    <div class="movieDetailGenres" v-if="movie.runtimeSeconds">
                        Time: {{ formatSecondsToTime(movie.runtimeSeconds) }}

                    </div>
                    <div class="movieDetailGenres" v-if="movie.rating">
                       <p>Rating: {{ movie.rating.aggregateRating }}/10</p>
                        <p>Votes: {{ movie.rating.voteCount }}</p>
                    </div>
                    <div class="movieDetailGenres" v-if="movie.metacritic">
                        <p>Metactic: {{ movie.metacritic?.score }}</p>
                        <p>Rewiews: {{ movie.metacritic.reviewCount }}</p>
                    </div>
                </div>
            </div>
            <div class="movieDetailsForm">
                <div v-if="page.flash.success" class="detailsMessage">
                    {{ page.flash.success }}
                </div>
                <div v-if="page.flash.error" class="detailsMessage error ">
                    {{ page.flash.error }}
                </div>
                <form @submit.prevent="submit">

                    <select class="" v-model="form.status">
                        <option value="to_watch">Want to watch</option>
                        <option value="in_progress">In progress</option>
                        <option value="watched">Finished</option>
                    </select>

                    <input type="range" min="1" max="10" v-model="form.rating">

                    <div class="rangeIndicator" >
                       Your rating: {{ form.rating }} / 10

                    </div>

                    <textarea class="detailsTextArea" v-model="form.comment" placeholder="Comment"></textarea>
                <div class="btnSection">
                    <button class="primary-btn">Save</button>
                    <button class="primary-btn" type="reset" @click="clearFlash">Reset</button>
                </div>

                </form>
                <div>


                </div>

            </div>
        </div>
    </div>

</template>

<style scoped>

</style>
