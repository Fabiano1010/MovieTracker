<script setup>
    const model = defineModel({
        type: null,
        required: true
    });
    defineProps({
        name:{
            type: String,
            required: true,

        },
        type: {
            type: String,
            default: 'text'
        },
        placeholder: String,
        message: String
    });

</script>

<template>
    <div class="textInput">
        <label :for="name">{{ name }}</label>
        <input :type="type" v-model="model" :placeholder="placeholder" :class="{'errorInput' : message}"  />
        <small class="error" v-if="message">{{ message }}</small>
    </div>
</template>

<style scoped>

</style>
