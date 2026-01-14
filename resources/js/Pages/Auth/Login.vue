<script setup>

import { useForm } from '@inertiajs/vue3';
import TextInput from "@/Components/TextInput.vue";

const form = useForm({
    email: null,
    password: null,
    remember: null,
})

const submit = () => {
    form.post(route('login'),{
        onError: () => form.reset('password')
    });
}

</script>

<template>
    <Head title="| Login"/>

    <h1 class="title"> Login</h1>
    <div class="LogRegForm">

        <form @submit.prevent="submit">


            <TextInput name="email" type="email" v-model="form.email" :message="form.errors.email"/>
            <TextInput name="password" type="password" v-model="form.password" :message="form.errors.password"/>
            <div class="LogRegText">
                <div class="checkboxDiv">
                    <input type="checkbox" v-model="form.remember" id="remember">
                    <label for="remember">Remember Me </label>
                </div>
                <p >Not a user? <a :href="route('register')">Register</a></p>
            </div>
            <div>
                <button class="primary-btn" :disabled="form.processing">Login</button>
            </div>

        </form>

    </div>

</template>

<style scoped>

</style>
