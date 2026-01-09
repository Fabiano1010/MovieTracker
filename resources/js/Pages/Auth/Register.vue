<script setup>

import { useForm } from '@inertiajs/vue3';
import TextInput from "@/Components/TextInput.vue";

const form = useForm({
    username: null,
    email: null,
    password: null,
    password_confirmation: null,
})

const submit = () => {
    form.post(route('register'),{
        onError: () => form.reset('password', 'password_confirmation')
    });
}

</script>

<template>
    <Head title="| Register"/>

    <h1 class="title"> Register</h1>
    <div class="w-2/4 mx-auto">

        <form @submit.prevent="submit">

            <TextInput name="username" v-model="form.username" :message="form.errors.username"/>
            <TextInput name="email" type="email" v-model="form.email" :message="form.errors.email"/>
            <TextInput name="password" type="password" v-model="form.password" :message="form.errors.password"/>
            <TextInput name="confirm password" type="password" v-model="form.password_confirmation"/>

            <div>
                <p class="text-slate-200 mb-2">Already a user? <a :href="route('login')">Login</a></p>
                <button class="primary-btn" :disabled="form.processing">Register</button>
            </div>

        </form>

    </div>

</template>

<style scoped>

</style>
