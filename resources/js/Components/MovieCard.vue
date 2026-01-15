<script setup>
import MovieComponent from "@/Components/MovieComponent.vue";
defineProps({
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

    message: String

})
//
// const isPopUpOpen = ref(false)
// const selectedMovie = ref(null)
// const openMovieModalSimple = (movie) => {
//     selectedMovie.value = movie
//     isPopUpOpen.value = true
// }

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
            <button class="primary-btn movieCardShowBtn">
                Show
            </button>
        </div>
    </div>
</template>


