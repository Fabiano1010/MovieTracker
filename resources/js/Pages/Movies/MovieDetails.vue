<script setup>
import TextInput from "@/Components/TextInput.vue";

import { onMounted, onBeforeUnmount  } from 'vue';
import { router, useForm } from '@inertiajs/vue3';

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


})
const form = useForm({
    movieId: props.id,
    status: {
        type: String,
        required: true
    },
    rating: {
        type: String,
        required: true
    },
    comment: {
        type: String,
        default: ''
    }
});

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
                <div class="movieCardText ">Original title: <p class="movieTitle">{{ movie.originalTitle }}</p> </div>
                <div class="movieCardText ">Primary title: <p class="movieTitle">{{ movie.primaryTitle }}</p> </div>
                <div class="movieCardText ">Release date:  <p class="movieDate">{{ movie.startYear }}</p></div>
            </div>
        </div>

        <div class="movieDetails">
            <div class="movieDetailsProps">
                <div class="movieDetailPlot">
                    Plot:
                    <p>{{ movie.plot }}</p>
                </div>
                <div class="movieDetailGenres">
                    Directors:
                    <div class="movieDetailGenry" v-for="dir in movie.directors">
                        &#x2022; {{ dir.displayName }}
                    </div>
                </div>
                <div class="movieDetailGenres">
                    Writers:
                    <div class="movieDetailGenry" v-for="wr in movie.writers">
                        &#x2022; {{ wr.displayName }}
                    </div>
                </div>
                <div class="movieDetailGenres">
                    Stars:
                    <div class="movieDetailGenry" v-for="st in movie.stars">
                        &#x2022; {{ st.displayName }}
                    </div>
                </div>

                <div class="movieDetailGenres">
                    Genres:
                    <div class="movieDetailGenry" v-for="gen in movie.genres">
                        &#x2022; {{ gen }}
                    </div>
                </div>
                <div class="movieDetailGenres">
                    Time: {{ formatSecondsToTime(movie.runtimeSeconds) }}

                </div>
                <div class="movieDetailGenres">
                   <p>Rating: {{ movie.rating.aggregateRating }}/10</p>
                    <p>Votes: {{ movie.rating.voteCount }}</p>
                </div>
                <div class="movieDetailGenres">
                    <p>Metactic: {{ movie.metacritic.score }}</p>
                    <p>Rewiews: {{ movie.metacritic.reviewCount }}</p>
                </div>
            </div>
            <div class="movieDetailsForm">
                <form >

                    <select class="" v-model="form.status">
                        <option>Want to wach</option>
                        <option>In progress</option>
                        <option>Finished</option>
                    </select>
                    <input type="range" min="1" max="10" v-model="form.rating">


                    <textarea class="detailsTextArea" v-model="form.comment" value=""></textarea>
                <div class="btnSection">
                    <button class="primary-btn">Save</button>
                    <button class="primary-btn" type="reset">Reset</button>
                </div>

                </form>
            </div>
        </div>
    </div>

</template>

<style scoped>

</style>
