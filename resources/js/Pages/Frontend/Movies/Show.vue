<template lang="">
    <Head :title="`${movie.title}`" />
    <FrontLayout>
        <main v-if="movie" class="mt-[-8px]">
            <section class="bg-gradient-to-r from-[#131244] to-transparent">
                <div class="max-w-6xl mx-auto m-4 p-2">
                    <div class="flex phone_xl">
                        <div class="w-3/12 tablet phone_xl-4">
                            <div class="w-full tablet-1">
                                <img
                                    class="w-full h-full rounded"
                                    :src="`https://www.themoviedb.org/t/p/w600_and_h900_face/${movie.poster_path}`"
                                />
                            </div>
                        </div>
                        <div class="w-8/12 phone_xl-1">
                            <div class="m-4 pt-6 pl-6 pr-6 pb-2">
                                <h1 class="flex text-white font-bold text-4xl">
                                    {{ movie.title }}
                                </h1>
                                <div
                                    class="flex p-3 text-white space-x-4 phone_p19"
                                >
                                    <span>{{ movie.release_date }}</span>
                                    <span>
                                        <Link
                                            v-for="(
                                                genre, index
                                            ) in movieGenres"
                                            :key="genre.id"
                                            class="font-thin subpixel-antialiased hover:text-blue-500"
                                            :href="`/genres/${genre.slug}`"
                                        >
                                            {{ genre.title }}
                                            <template
                                                v-if="
                                                    index !==
                                                    movieGenres.length - 1
                                                "
                                                >,</template
                                            >
                                            <template
                                                v-if="
                                                    index === 3 &&
                                                    index !==
                                                        movieGenres.length - 1
                                                "
                                                ><br
                                            /></template>
                                        </Link>
                                    </span>
                                    <span class="flex space-x-2">
                                        {{ movie.formattedRuntime }}
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-6 w-6"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                            />
                                        </svg>
                                    </span>
                                </div>
                                <div class="flex space-x-4 phone_xl-2">
                                    <div
                                        class="flex pr-4 text-white font-bold z-10"
                                    >
                                        <div
                                            class="flex relative container-progressbar"
                                        >
                                            <circle-progress
                                                class="circle_progressbar"
                                                :percent="movie.rating * 10"
                                                :is-gradient="true"
                                                :size="50"
                                                :border-width="5"
                                                :border-bg-width="5"
                                            />
                                            <span class="percent"
                                                >{{ movie.rating * 10 }}%</span
                                            >
                                        </div>
                                        <span class="pl-[10px] text-white"
                                            >User
                                            <br />
                                            Score
                                        </span>
                                    </div>

                                    <button
                                        class="rounded-md bg-black/20 px-4 py-2 text-sm font-medium text-white hover:bg-black/30 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/75"
                                        v-for="trailer in trailers"
                                        :key="trailer.id"
                                        @click="openModal(trailer)"
                                    >
                                        {{ trailer.name }}
                                    </button>
                                </div>
                            </div>

                            <div class="pl-12 text-white mb-4 phone_xl-3">
                                <p class="font-bold text-lg">Overview</p>
                                <p>{{ movie.overview }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section
                class="max-w-6xl mx-auto bg-gray-200 dark:bg-gray-900 p-2 rounded"
            >
                <div class="flex justify-between">
                    <div class="w-7/12">
                        <h1
                            class="flex text-slate-600 dark:text-white font-bold text-xl"
                        >
                            Movie Casts
                        </h1>
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mt-4">
                            <MovieCard v-for="cast in casts" :key="cast.id">
                                <template #image>
                                    <Link :href="`/casts/${cast.slug}`">
                                        <img
                                            class=""
                                            :src="`https://www.themoviedb.org/t/p/w600_and_h900_face/${cast.poster_path}`"
                                        />
                                    </Link>
                                </template>
                                <Link :href="`/casts/${cast.slug}`">
                                    <span
                                        class="text-slate-600 dark:text-white"
                                        >{{ cast.name }}</span
                                    >
                                </Link>
                            </MovieCard>
                        </div>
                    </div>
                    <div class="w-4/12">
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

            <section
                v-if="movie.tags"
                class="max-w-6xl mx-auto bg-gradient-to-r from-indigo-700 to-transparent mt-6 p-2"
            >
                <span
                    v-for="tag in movie.tags"
                    :key="tag.id"
                    class="font-bold text-white hover:text-indigo-200 cursor-pointer"
                    ><Link :href="`/tags/${tag.slug}`" class="ml-2"
                        >#{{ tag.tag_name }}</Link
                    ></span
                >
            </section>
        </main>
    </FrontLayout>

    <TransitionRoot appear :show="isOpen" as="template">
        <Dialog as="div" @close="closeModal">
            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="min-h-screen px-4 text-center">
                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0"
                        enter-to="opacity-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100"
                        leave-to="opacity-0"
                    >
                        <DialogOverlay class="fixed inset-0" />
                    </TransitionChild>

                    <span
                        class="inline-block h-screen align-middle"
                        aria-hidden="true"
                    >
                        &#8203;
                    </span>

                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95"
                    >
                        <div
                            class="inline-block w-full max-w-6xl p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl"
                        >
                            <DialogTitle
                                as="h3"
                                class="text-lg font-medium leading-6 text-gray-900"
                            >
                                {{ movie.title }}
                            </DialogTitle>
                            <div class="mt-2" v-if="modalTrailer">
                                <div
                                    class="aspect-w-16 aspect-h-9"
                                    v-html="modalTrailer.embed_html"
                                ></div>
                            </div>

                            <div class="mt-4">
                                <button
                                    type="button"
                                    class="inline-flex justify-center px-4 py-2 text-sm font-medium text-blue-900 bg-blue-100 border border-transparent rounded-md hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-blue-500"
                                    @click="closeModal"
                                >
                                    Close
                                </button>
                            </div>
                        </div>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
<script setup>
import { ref } from "vue";
import FrontLayout from "@/Layouts/FrontLayout.vue";
import MovieCard from "@/Components/MovieCard.vue";
import { Link, Head } from "@inertiajs/vue3";
import "vue3-circle-progress/dist/circle-progress.css";
import CircleProgress from "vue3-circle-progress";
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogOverlay,
    DialogTitle,
} from "@headlessui/vue";

defineProps({
    movie: Object,
    latests: Array,
    casts: Array,
    tags: Array,
    movieGenres: Array,
    trailers: Array,
});

const components = {
    CircleProgress,
};

const isOpen = ref(false);
const modalTrailer = ref({});

function closeModal() {
    isOpen.value = false;
}

function openModal(trailer) {
    modalTrailer.value = trailer;
    isOpen.value = true;
}
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
@media screen and (min-width: 767px) and (max-width: 860px) {
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
}
</style>
