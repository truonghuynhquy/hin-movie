<template lang="">
    <Head :title="`${season.name} Season`" />
    <FrontLayout>
        <main v-if="season" class="mt-[-8px]">
            <section class="bg-gradient-to-r from-[#131244] to-transparent">
                <div class="max-w-6xl mx-auto m-4 p-2">
                    <div class="flex phone_xl phone_xl">
                        <div class="w-3/12 flex items-center tablet phone_xl-4">
                            <div class="w-full tablet-1">
                                <img
                                    class="w-full h-full rounded"
                                    :src="`https://www.themoviedb.org/t/p/w600_and_h900_face/${season.poster_path}`"
                                />
                            </div>
                        </div>
                        <div class="w-8/12 phone_xl-1">
                            <div class="m-4 p-6">
                                <h1
                                    class="flex text-white font-bold text-4xl unset_flex"
                                >
                                    {{ season.name }}
                                </h1>
                                <div
                                    class="flex pt-4 pr-3 pb-3 pl-0 text-white space-x-4 phone_justify-text"
                                >
                                    <span
                                        >Season Nr:
                                        {{ season.season_number }}</span
                                    >
                                    <span>Tv Show: {{ tvShow.name }} </span>
                                    <span>{{ tvShow.created_year }}</span>
                                </div>
                            </div>
                            <div
                                class="pl-10 text-white mb-4 clear_pl-10 lg:text-justify"
                            >
                                <p class="font-bold text-xl">Overview</p>
                                <p>{{ season.overView }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section
                class="max-w-6xl mx-auto bg-gray-200 dark:bg-gray-900 p-2 rounded"
            >
                <div class="flex justify-between phone_x2">
                    <div class="lg: w-7/12 phone_x2-1">
                        <h1
                            class="flex text-slate-600 dark:text-white font-bold text-xl"
                        >
                            Episodes
                        </h1>
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mt-4">
                            <MovieCard
                                v-for="episode in episodes"
                                :key="episode.id"
                            >
                                <template #image>
                                    <Link :href="`/episodes/${episode.slug}`">
                                        <img
                                            class=""
                                            :src="`https://www.themoviedb.org/t/p/w600_and_h900_face/${season.poster_path}`"
                                        />
                                    </Link>
                                </template>
                                <Link :href="`/episodes/${episode.slug}`">
                                    <span
                                        class="text-slate-600 dark:text-white"
                                        >{{ episode.name }}</span
                                    >
                                </Link>
                            </MovieCard>
                        </div>
                    </div>
                    <div class="w-4/12 phone_x2-2">
                        <h1
                            class="flex text-slate-600 dark:text-white font-bold text-xl mb-4"
                        >
                            Latest movies
                        </h1>
                        <div
                            class="grid grid-cols-3 gap-2"
                            v-if="latests.length"
                        >
                            <Link
                                v-for="lm in latests"
                                :key="lm.id"
                                :href="`/movies/${lm.slug}`"
                            >
                                <img
                                    class="w-full h-full rounded-lg"
                                    :src="`https://www.themoviedb.org/t/p/w600_and_h900_face/${lm.poster_path}`"
                                />
                            </Link>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </FrontLayout>
</template>
<script setup>
import { ref } from "vue";
import { Head, Link } from "@inertiajs/vue3";
import FrontLayout from "@/Layouts/FrontLayout.vue";
import MovieCard from "@/Components/MovieCard.vue";

defineProps({
    tvShow: Object,
    latests: Array,
    episodes: Array,
    season: Object,
});
</script>
<style>
.italic {
    font-style: italic;
}
.font-light {
    font-weight: 300;
}
@media screen and (min-width: 767px) and (max-width: 900px) {
    .tablet {
        position: relative;
    }
    .tablet-1 {
        width: 100%;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
    }
    .min-h-screen {
        min-height: 100%;
    }
}
@media screen and (min-width: 300px) and (max-width: 767px) {
    .unset_flex {
        display: unset;
    }
    .phone_justify-text {
        justify-content: center;
    }
    .clear_pl-10 {
        padding-left: unset;
    }
    .phone_xl {
        display: unset;
        position: relative;
    }
    .phone_xl-1 {
        width: unset;
        text-align: center;
    }
    .phone_xl-2 {
        padding-top: 1rem;
        justify-content: center;
    }
    .phone_xl-3 {
        padding-left: unset;
    }
    .phone_xl-4 {
        width: 100%;
    }
    .phone_x2 {
        display: unset;
    }
    .phone_x2 .phone_x2-1,
    .phone_x2-2 {
        width: unset;
    }
    .phone_x2-2 {
        padding-top: 1rem;
    }
}
</style>
