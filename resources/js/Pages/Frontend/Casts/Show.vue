<template lang="">
    <Head :title="`${cast.name} Actor`" />
    <FrontLayout>
        <main v-if="cast" class="mt-[-8px]">
            <section class="bg-gradient-to-r from-[#131244] to-transparent">
                <div class="max-w-6xl mx-auto m-4 p-2">
                    <div class="flex phone_xl">
                        <div class="w-3/12 mt-4 pt-6 tablet phone_xl-4">
                            <div class="w-full tablet-1">
                                <img
                                    class="w-full h-full rounded"
                                    :src="`https://www.themoviedb.org/t/p/w600_and_h900_face/${cast.poster_path}`"
                                />
                            </div>
                        </div>
                        <div class="w-11/12 phone_xl-1">
                            <div class="m-4 p-6">
                                <h1
                                    class="flex text-blue-300 font-bold text-4xl add_justify-center"
                                >
                                    {{ cast.name }}
                                </h1>
                                <div class="pt-4 text-white">
                                    Movies: {{ movies.length }}
                                </div>

                                <div class="pt-2">
                                    <h1
                                        class="font-bold text-2xl text-blue-300"
                                    >
                                        Biography
                                    </h1>
                                    <div
                                        style="white-space: pre-line"
                                        class="pt-2 text-justify leading-7 text-white"
                                    >
                                        <div v-if="showShortText">
                                            {{ shortenedText }}
                                            <span
                                                v-if="isTextLong"
                                                class="text-[#01b4e4]"
                                                >...
                                                <button @click="showMore">
                                                    Read more
                                                </button></span
                                            >
                                        </div>
                                        <div v-else>
                                            {{ fullText }}
                                            <button
                                                @click="showLess"
                                                class="text-[#01b4e4]"
                                            >
                                                Show less
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-2">
                                    <h1
                                        class="font-bold text-2xl text-blue-300"
                                    >
                                        Person Information
                                    </h1>
                                    <div
                                        class="flex w-2/3 justify-between phone_change-jb"
                                    >
                                        <div
                                            class="pt-2 justify-center leading-8 text-white"
                                        >
                                            <p class="font-bold">Birthday</p>
                                            <p>
                                                {{ cast.birthday }}
                                            </p>
                                        </div>
                                        <div
                                            class="pt-2 justify-center leading-8 text-white"
                                        >
                                            <p class="font-bold">Gender</p>
                                            <p>
                                                {{ cast.gender }}
                                            </p>
                                        </div>
                                        <div
                                            class="pt-2 justify-center leading-8 text-white"
                                        >
                                            <p class="font-bold">
                                                Place Of Birth
                                            </p>
                                            <p>
                                                {{ cast.placeOfBirth }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section
                class="max-w-6xl mx-auto bg-gray-200 dark:bg-gray-900 p-2 rounded"
            >
                <div class="flex justify-between phone_x2">
                    <div class="phone_x2-1">
                        <h1
                            class="flex text-slate-600 dark:text-white font-bold text-xl"
                        >
                            {{ cast.name }} Movies
                        </h1>
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mt-4">
                            <MovieCard v-for="movie in movies" :key="movie.id">
                                <template #image>
                                    <Link :href="`/movies/${movie.slug}`">
                                        <img
                                            class=""
                                            :src="`https://www.themoviedb.org/t/p/w600_and_h900_face/${movie.poster_path}`"
                                        />
                                    </Link>
                                </template>
                                <Link :href="`/movies/${movie.slug}`">
                                    <span
                                        class="text-slate-600 dark:text-white"
                                        >{{ movie.title }}</span
                                    >
                                </Link>
                            </MovieCard>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </FrontLayout>
</template>
<script setup>
import { ref, computed, defineProps } from "vue";
import FrontLayout from "@/Layouts/FrontLayout.vue";
import MovieCard from "@/Components/MovieCard.vue";
import { Link, Head } from "@inertiajs/vue3";

const props = defineProps({
    cast: Object,
    movies: Array,
});

const text = props.cast.biography;
const maxLength = 400;
const showShortText = ref(true);

const shortenedText = computed(() => text.slice(0, maxLength));
const fullText = computed(() => text);
const isTextLong = computed(() => text.length > maxLength);

function showMore() {
    showShortText.value = false;
}

function showLess() {
    showShortText.value = true;
}
</script>
<style>
.italic {
    font-style: italic;
}
.font-light {
    font-weight: 300;
}
@media screen and (min-width: 767px) and (max-width: 900px) {
    .min-h-screen {
        min-height: 100%;
    }
}
@media screen and (min-width: 300px) and (max-width: 767px) {
    .add_justify-center {
        justify-content: center;
    }
    .unset_flex {
        display: unset;
    }
    .phone_justify-text {
        justify-content: center;
    }
    .phone_change-jb {
        width: 100%;
        display: unset;
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
