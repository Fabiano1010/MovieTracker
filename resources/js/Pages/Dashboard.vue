<script setup>

</script>

<template>
    <div>
        <h1 class="title" v-if="$page.props.auth.user.username">Welcome back {{ $page.props.auth.user.username }}!</h1>
    </div>
</template>

<style scoped>

</style>
