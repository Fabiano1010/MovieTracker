<script setup>

    import {router} from "@inertiajs/vue3";
    import {computed, onMounted} from "vue";

    const props = defineProps({
        stats: Object,
    })
    const fetchStats = () => {
        // loading.value = true

        router.get(route('movies.stats'), {

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
    const formattedRating = computed(() => {
        if (!props.stats.average_rating) return '0.0'
        let format = props.stats.average_rating;
        return Math.round(props.stats.average_rating*10)/10;

    })
    onMounted(() => {
        if(!props.stats || props.stats.length===0){
            fetchStats();
        }
    })

</script>

<template>
    <div>
        <h1 class="title" v-if="$page.props.auth.user.username">Statistics</h1>
    </div>
    <div class="statsContainer"  >
        <div class="stats movieCard" v-if="props.stats">
            <div class="statsName">
                Total movies added:
            </div>
            <div class="statsValue">
                {{ props.stats.total_movies }}
            </div>
        </div>
        <div class="stats movieCard" v-if="props.stats">
            <div class="statsName">
                Watched:
            </div>
            <div class="statsValue">
                {{ props.stats.watched_count }}<span>/{{ props.stats.total_movies }}</span>
            </div>
        </div>
        <div class="stats movieCard" v-if="props.stats">
            <div class="statsName">
                Not finished:
            </div>
            <div class="statsValue">
                {{ props.stats.in_progress_count }}<span>/{{ props.stats.total_movies }}</span>
            </div>
        </div>
        <div class="stats movieCard" v-if="props.stats">
            <div class="statsName">
                To watch:
            </div>
            <div class="statsValue">
                {{ props.stats.to_watch_count }}<span>/{{ props.stats.total_movies }}</span>
            </div>
        </div>
        <div class="stats movieCard" v-if="props.stats">
            <div class="statsName">
                Favourite movies count:
            </div>
            <div class="statsValue">
                {{ props.stats.fav_count }}<span>/{{ props.stats.total_movies }}</span>
            </div>
        </div>
        <div class="stats movieCard" v-if="props.stats">
            <div class="statsName">
                Comments count:
            </div>
            <div class="statsValue">
                {{ props.stats.comment_count }}<span>/{{ props.stats.total_movies }}</span>
            </div>
        </div>
        <div class="stats movieCard" v-if="props.stats">
            <div class="statsName">
                Average rating:
            </div>
            <div class="statsValue">
                {{ formattedRating }}<span>/10</span>
            </div>
        </div>

        <div class="stats movieCard" v-else>
            <div class="statsValue">
                No statistics at the moment
            </div>
        </div>


    </div>


</template>

<style scoped>

</style>
