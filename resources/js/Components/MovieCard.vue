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
        type: Array
    }

})

</script>

<template>
    <div class="movieCard">
        <div class="movieCardBody">
            <img class="movieCardImg" :src="img.url" alt="" >
            <div class="movieCardTitle">
                <h1>Original title: {{ titleOriginal }} </h1>
                <h1>Primary title: {{ titlePrimary }} </h1>
                {{ date }}
            </div>
        </div>
        <button class="primary-btn movieCardShowBtn">
            Show
        </button>

    </div>
</template>


