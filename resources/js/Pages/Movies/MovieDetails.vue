<script setup>


import {onMounted, onBeforeUnmount, computed, watch} from 'vue';
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
    userMovie:{
        type: Object,
        default: null
    }
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
    fav: false,
    primary_img: props.movie.primaryImage?.url || '',
    primary_title: props.movie.originalTitle,
    original_title: props.movie.primaryTitle,
    start_year: props.movie.startYear || null,
});

const submit = () => {
    if (movieExists.value) {

        updateMovie();
    } else {

        createMovie();
    }
}

const movieExists = computed(() => {
    return props.userMovie !== null;
});

const submitButtonText = computed(() => {
    return movieExists.value ? 'Update' : 'Save';
});
const createMovie  = () => {
    router.post(route('movies.store'), {
        user_id : form.userId,
        movie_id : form.movieId,
        primary_img: form.primary_img,
        primary_title: form.primary_title,
        original_title: form.original_title,
        start_year: form.start_year,
        status: form.status,
        user_rating: form.rating,
        comment: form.comment,
        is_favourite: form.fav
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
            form.status = 'to_watch';
            form.user_rating = 1;
            form.comment = '';
            props.errors = {};

        },
        onError: (err) => {
            props.errors.value = err;
            form.reset('title');
        }
    });
}

const updateMovie = () => {
    router.put(route('movies.update', form.movieId), {
        status: form.status,
        user_rating: form.rating,
        comment: form.comment,
        is_favourite: form.fav
    }, {
        preserveState: true,
        preserveScroll: true,
        onStart: () => {
            form.processing = true;
        },
        onFinish: () => {
            form.processing = false;
        },
        onSuccess: () => {
            page.props.flash = {
                success: 'Movie updated successfully!'
            };


            setTimeout(() => {
                router.reload({
                    only: ['userMovie', 'flash'],
                    preserveScroll: true
                });
            }, 1500);
        },
        onError: (err) => {
            console.error('Error updating movie:', err);
        }
    });
}

watch(() => props.userMovie, (newUserMovie) => {
    if (newUserMovie) {
        form.status = newUserMovie.status || 'to_watch';
        form.rating = newUserMovie.rating || 1;
        form.comment = newUserMovie.comment || '';
        form.fav = newUserMovie.is_favourite || false;
    }
}, { immediate: true });

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
    if(!props.movie){

    }
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

            <div v-if="movieExists" class="movieStatusInfo">
                <p class="movieTitle"> This movie is in your collection</p>
                <p v-if="userMovie.status === 'to_watch'">Status: Want to watch</p>
                <p v-if="userMovie.status === 'in_progress'">Status: Currently watching</p>
                <p v-if="userMovie.status === 'watched'">Status: Watched</p>
                <p v-if="userMovie.rating">Your rating: {{ userMovie.rating }}/10</p>
                <p v-if="userMovie.is_favourite" class="fav">Favourite movie</p>
                <p v-if="userMovie.comment">{{ userMovie.comment }}</p>
            </div>

            <div class="movieDetailsForm">
                <div v-if="page.flash.success" class="detailsMessage">
                    {{ page.flash.success }}
                </div>
                <div v-if="page.flash.error" class="detailsMessage error ">
                    {{ page.flash.error }}
                </div>
                <div v-if="$page.props.errors" class="detailsMessage error ">
                    {{ $page.props.errors.status }}
                </div>
                <form @submit.prevent="submit">

                    <select class="" v-model="form.status">
                        <option value="to_watch">Want to watch</option>
                        <option value="in_progress">In progress</option>
                        <option value="watched">Finished</option>
                    </select>

                    <input type="range" min="1" max="10" v-model="form.rating" >

                    <div class="rangeIndicator" >
                       Your rating: {{ form.rating }} / 10
                    </div>
                    <div class="checkboxDiv">
                        <input type="checkbox" v-model="form.fav" id="remember" :checked="form.fav === 1 || form.fav === true">
                        <label for="remember">Favourite movie </label>
                    </div>
                    <textarea class="detailsTextArea" v-model="form.comment" placeholder="Comment"></textarea>
                <div class="btnSection">
                    <button class="primary-btn">{{ submitButtonText  }}</button>
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
