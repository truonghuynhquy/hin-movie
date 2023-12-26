<template lang="">
    <Head :title="`${movie.title}`" />
    <FrontLayout>
        <main v-if="movie" class="mt-[-8px]">
            <section class="bg-gradient-to-r from-indigo-800 to-transparent">
                <div class="max-w-6xl mx-auto m-4 p-2">
                    <div class="flex">
                        <div class="w-3/12">
                            <div class="w-full">
                                <img
                                    class="w-full h-full rounded"
                                    :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${movie.poster_path}`"
                                />
                            </div>
                        </div>
                        <div class="w-8/12">
                            <div class="m-4 p-6">
                                <h1 class="flex text-white font-bold text-4xl">
                                    {{ movie.title }}
                                </h1>
                                <div class="flex p-3 text-white space-x-4">
                                    <span>{{ movie.release_date }}</span>
                                    <span>
                                        <Link
                                            v-for="genre in movieGenres"
                                            :key="genre.id"
                                            class="font-thin subpixel-antialiased hover:text-blue-500"
                                            :href="`/genres/${genre.slug}`"
                                        >
                                            {{ genre.title }} ,
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
                                <div class="flex space-x-4">
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

                            <div class="pl-12 text-white">
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
                                            :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${cast.poster_path}`"
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
                                    :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${lm.poster_path}`"
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
        <Dialog as="div" @close="closeModal" class="relative z-10">
            <TransitionChild
                as="template"
                enter="duration-300 ease-out"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-black/25" />
            </TransitionChild>

            <div class="fixed inset-0 overflow-y-auto">
                <div
                    class="flex min-h-full items-center justify-center p-4 text-center"
                >
                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95"
                    >
                        <DialogPanel
                            class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
                        >
                            <DialogTitle
                                as="h3"
                                class="text-lg font-medium leading-6 text-gray-900"
                            >
                                Payment successful
                            </DialogTitle>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Your payment has been successfully
                                    submitted. We’ve sent you an email with all
                                    of the details of your order.
                                </p>
                            </div>

                            <div class="mt-4">
                                <button
                                    type="button"
                                    class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                                    @click="closeModal"
                                >
                                    Got it, thanks!
                                </button>
                            </div>
                        </DialogPanel>
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
</style>
