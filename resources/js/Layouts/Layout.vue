<script setup>


</script>

<template>

    <div class="layout">
        <header>
            <nav>
                <div v-if="$page.props.auth.user" >
                    <Link :href="route('home')" class="nav-link" :class="{'nav-link-current' : $page.component === 'Home' }">Home</Link>
                    <Link :href="route('dashboard')" class="nav-link" :class="{'nav-link-current' : $page.component === 'Dashboard' }">Dashboard</Link>
                    <Link :href="route('search')" class="nav-link" :class="{'nav-link-current' : $page.component === 'Search' }">Search</Link>
                    <Link :href="route('statistics')" class="nav-link" :class="{'nav-link-current' : $page.component === 'Statistics' }">Statistics</Link>
                </div>
                <div v-else>
                    <Link :href="route('home')" class="nav-link" :class="{'nav-link-current' : $page.component === 'Home' }">Home</Link>
                    <Link :href="route('register')" class="nav-link" :class="{'nav-link-current' : $page.component === 'Auth/Register' }">Register</Link>
                    <Link :href="route('login')" class="nav-link" :class="{'nav-link-current' : $page.component === 'Auth/Login' }">Login</Link>
                </div>
                <div v-if="$page.props.auth.user" class="logout">
                    <Link :href="route('logout')" method="post" as="button" type="button" class="nav-link nav-link-logout">Logout</Link>
                </div>
            </nav>
        </header>
        <main class="">
            <slot />
        </main>
    </div>
</template>

<style scoped>

</style>
