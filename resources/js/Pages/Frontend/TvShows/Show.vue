<template lang="">
    <Head :title="`${tvShow.name}`" />
    <FrontLayout>
        <main v-if="tvShow" class="mt-[-8px]">
            <section class="bg-gradient-to-r from-[#131244] to-transparent">
                <div class="max-w-6xl mx-auto m-4 p-2">
                    <div class="flex">
                        <div class="w-3/12">
                            <div class="w-full">
                                <img
                                    class="w-full h-full rounded"
                                    :src="`https://www.themoviedb.org/t/p/w600_and_h900_face/${tvShow.poster_path}`"
                                />
                            </div>
                        </div>

                        <div class="w-8/12">
                            <div class="m-4 p-6">
                                <h1 class="flex text-white font-bold text-4xl">
                                    {{ tvShow.name }}
                                </h1>
                                <div
                                    class="flex pt-4 pr-3 pb-3 pl-0 text-white space-x-4"
                                >
                                    <span>{{ tvShow.created_year }}</span>
                                    <span>
                                        <Link
                                            v-for="(
                                                genre, index
                                            ) in tvShow.genreNames"
                                            :key="genre.id"
                                            class="font-thin subpixel-antialiased hover:text-blue-500"
                                            :href="`/genres/${genre.slug}`"
                                        >
                                            {{ genre }}
                                            <template
                                                v-if="
                                                    index !==
                                                    tvShow.genreNames.length - 1
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
                                </div>
                            </div>
                            <div class="pl-10 text-white mb-4">
                                <p class="font-bold text-xl">Overview</p>
                                <p>{{ tvShow.overView }}</p>
                            </div>
                            <div
                                v-if="tvShow.creatorNames != null"
                                class="mt-10 pl-10 text-white"
                            >
                                <p class="font-bold text-lg">
                                    {{ tvShow.creatorNames }}
                                </p>
                                <p class="font-light italic">Creator</p>
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
                            Seasons
                        </h1>
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mt-4">
                            <MovieCard
                                v-for="season in seasons"
                                :key="season.id"
                            >
                                <template #image>
                                    <Link
                                        :href="`/tv-shows/${tvShow.slug}/seasons/${season.slug}`"
                                    >
                                        <img
                                            class=""
                                            :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${season.poster_path}`"
                                        />
                                    </Link>
                                </template>
                                <Link
                                    :href="`/tv-shows/${tvShow.slug}/seasons/${season.slug}`"
                                >
                                    <span
                                        class="text-slate-600 dark:text-white"
                                        >{{ season.name }}</span
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
    seasons: Array,
});
</script>
<style>
.italic {
    font-style: italic;
}
.font-light {
    font-weight: 300;
}
</style>
