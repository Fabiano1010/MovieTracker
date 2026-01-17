<script setup>

import {onMounted, onBeforeUnmount, ref} from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    movies:{
        type: Object,
        default: () => ({ titles:[] })
    },
    error: {
        type: String,
        default: null
    }
})
const loading = ref(false)
const fetchData = () => {
    loading.value = true
    router.get(route('movies.index'), {
        status: 'to_watch'
        }, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            loading.value = false
        },
        onError: () => {
            loading.value = false
        },
        onFinish: () => {
            loading.value = false
        }

    })
}


onMounted(() => {
    {
        fetchData();
    }
})

</script>
<template>
    <div>
        <h1 class="title" v-if="$page.props.auth.user.username">Welcome back {{ $page.props.auth.user.username }}!</h1>
    </div>


</template>

<style scoped>

</style>
