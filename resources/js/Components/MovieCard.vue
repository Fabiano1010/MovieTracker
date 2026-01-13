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
    <div class="flex flex-row gap-10 rounded-3xl bg-amber-500 hover:bg-amber-100 hover:text-black text-white  m-3 transition ease-in-out duration-250">
        <div class="bg-amber-800 w-15 p-3 rounded-bl-3xl rounded-tl-3xl">
            <img :src="img.url" alt="" class="w-16 h-16 rounded-md">
        </div>
        <div class="flex flex-col">
            <h1>Original title: {{ titleOriginal }} </h1>
            <h1>Primary title: {{ titlePrimary }} </h1>
        </div>

        <div>
            {{ date }}
        </div>
        <button class="">
            Add
        </button>

    </div>
</template>


