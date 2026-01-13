<script setup>

import Dashboard from "@/Pages/Dashboard.vue";
</script>

<template>

    <div class="h-full">
        <header class="bg-stone-950 text-white max-w-4xl m-auto rounded-xl" >
            <nav class="flex items-center justify-between h-15 w-full mx-auto ">



                    <div class="space-x-6">
                        <Link :href="route('home')" class="nav-link" :class="{'bg-orange-400' : $page.component === 'Home' }">Home</Link>
                    </div>
                    <div v-if="$page.props.auth.user" class="space-x-6">
                        <Link :href="route('dashboard')" class="nav-link" :class="{'bg-orange-400' : $page.component === 'Dashboard' }">Dashboard</Link>
                        <Link :href="route('logout')" method="post" as="button" type="button" class="nav-link">Logout</Link>
                    </div>
                    <div class="space-x-6" v-else>
                        <Link :href="route('register')" class="nav-link" :class="{'bg-orange-400' : $page.component === 'Auth/Register' }">Register</Link>
                        <Link :href="route('login')" class="nav-link" :class="{'bg-orange-400' : $page.component === 'Auth/Login' }">Login</Link>
                    </div>


            </nav>
        </header>
        <main class="p-4 h-full">
            <slot />
        </main>
    </div>
</template>

<style scoped>

</style>
