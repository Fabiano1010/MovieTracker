<script setup>
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
</script>

<template>

    <div class="movieCardPopular">
            <div class="movieCardImgDivPopular">
                <img class="movieCardImgPopular" :src="img" alt="" >
            </div>
            <div class="movieCardTitle titlePopular">
                <div class="movieCardText textPopular">Original title: <span class="movieTitle">{{ titleOriginal }}</span> </div>
                <div class="movieCardText textPopular">Primary title: <span class="movieTitle">{{ titlePrimary }}</span> </div>
                <div class="movieCardText textPopular">Release date:  <span class="movieDate">{{ date }}</span></div>
            </div>
    </div>


</template>
