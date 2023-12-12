<template lang="">
    <Head title="All Movies" />
    <FrontLayout>
        <main class="max-w-6xl mx-auto mt-6 min-h-screen">
            <section
                class="bg-gray-200 dark:bg-gray-900 dark:text-white mt-4 p-2 rounded"
            >
                <div
                    class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 rounded"
                >
                    <MovieCard v-for="movie in movies.data" :key="movie.id">
                        <template #image>
                            <Link :href="`/movies/${movie.slug}`">
                                <div class="aspect-w-4 aspect-h-5">
                                    <img
                                        class="object-cover"
                                        :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${movie.poster_path}`"
                                    />
                                </div>
                                <div
                                    class="absolute x-10 left-2 top-2 h-6 w-12 bg-gray-800 text-blue-400 text-center rounded"
                                >
                                    New
                                </div>
                                <div
                                    class="absolute inset-0 z-10 bg-gradient-to-t from-black to-transparent"
                                ></div>
                                <div
                                    class="absolute inset-y-0 left-5 z-10 invisible group-hover:visible flex items-center"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-12 w-12 text-blue-700 bg-red-700 rounded-full"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                    <div
                                        class="absolute transition opacity-0 duration-500 ease-in-out transform group-hover:opacity-100 group-hover:translate-x-16 group-hover:pr-2 text-white font-bold"
                                    >
                                        Play
                                    </div>
                                </div>
                            </Link>
                            <div
                                class="absolute text-white font-bold translate-x-[7px] translate-y-[-33px] z-10"
                            >
                                <div class="relative container-progressbar">
                                    <circle-progress
                                        class="circle_progressbar"
                                        :percent="movie.percentMovie"
                                        :size="50"
                                        :border-width="5"
                                        :border-bg-width="5"
                                        :is-gradient="true"
                                    />
                                    <span class="percent"
                                        >{{ movie.percentMovie }}%</span
                                    >
                                </div>
                            </div>
                        </template>
                        <div class="pt-[12px]">
                            <Link :href="`/movies/${movie.slug}`">
                                <div
                                    class="dark:text-white font-bold group-hover:text-blue-400"
                                >
                                    {{ movie.title }}
                                </div>
                            </Link>
                        </div>
                        <div class="text-xs">
                            <span>Genres: </span>
                            <span v-for="genre in movie.genres" :key="genre.id">
                                {{ genre.title }}
                                <template
                                    v-if="index !== movie.genres.length - 1"
                                    >&nbsp;</template
                                >
                            </span>
                        </div>
                    </MovieCard>
                </div>
                <div class="m-2 p-2 bg-gray-500">
                    <Pagination :links="movies.links" />
                </div>
            </section>
        </main>
    </FrontLayout>
</template>
<script setup>
import { Head, Link } from "@inertiajs/vue3";
import FrontLayout from "@/Layouts/FrontLayout.vue";
import MovieCard from "@/Components/MovieCard.vue";
import Pagination from "@/Components/Pagination.vue";
import "vue3-circle-progress/dist/circle-progress.css";
import CircleProgress from "vue3-circle-progress";

defineProps({
    movies: Array,
});

const components = {
    CircleProgress,
};
</script>

<style>
.circle_progressbar.vue3-circular-progressbar svg {
    height: 3rem !important;
    width: 3rem !important;
    position: unset !important;
}

.percent {
    position: absolute;
    top: 0;
    transform: translate(46%, 72%);
    font-size: 0.8rem;
}
</style>
