<template lang="">
    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Movie Edit
            </h2>
        </template>

        <div class="py-2">
            <div class="max-w-7xl mx-auto">
                <section class="flex container mx-auto p-6 font-mono">
                    <div
                        class="w-full mb-8 sm:max-w-md p-6 overflow-hidden bg-white rounded-lg shadow-lg"
                    >
                        <form @submit.prevent="submitMovie">
                            <div>
                                <InputLabel for="title" value="Title" />
                                <TextInput
                                    id="title"
                                    v-model="form.title"
                                    type="text"
                                    class="mt-1 block w-full"
                                    autofocus
                                    autocomplete="title"
                                />
                                <div
                                    class="text-sm text-red-400"
                                    v-if="form.errors.title"
                                >
                                    {{ form.errors.title }}
                                </div>
                            </div>

                            <div class="mt-4">
                                <InputLabel for="runtime" value="Runtime" />
                                <TextInput
                                    id="runtime"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.runtime"
                                    autofocus
                                    autocomplete="runtime"
                                />
                                <div
                                    class="text-sm text-red-400"
                                    v-if="form.errors.runtime"
                                >
                                    {{ form.errors.runtime }}
                                </div>
                            </div>

                            <div class="mt-4">
                                <InputLabel for="lang" value="Language" />
                                <TextInput
                                    id="lang"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.lang"
                                    autofocus
                                    autocomplete="lang"
                                />
                                <div
                                    class="text-sm text-red-400"
                                    v-if="form.errors.lang"
                                >
                                    {{ form.errors.lang }}
                                </div>
                            </div>

                            <div class="mt-4">
                                <InputLabel for="video_format" value="Format" />
                                <TextInput
                                    id="video_format"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.video_format"
                                    autofocus
                                    autocomplete="video_format"
                                />
                                <div
                                    class="text-sm text-red-400"
                                    v-if="form.errors.video_format"
                                >
                                    {{ form.errors.video_format }}
                                </div>
                            </div>

                            <div class="mt-4">
                                <InputLabel for="rating" value="Rating" />
                                <TextInput
                                    id="rating"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.rating"
                                    autofocus
                                    autocomplete="rating"
                                />
                                <div
                                    class="text-sm text-red-400"
                                    v-if="form.errors.rating"
                                >
                                    {{ form.errors.rating }}
                                </div>
                            </div>

                            <div class="mt-4">
                                <InputLabel for="poster_path" value="Poster" />
                                <TextInput
                                    id="poster_path"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.poster_path"
                                    autofocus
                                    autocomplete="poster_path"
                                />
                                <div
                                    class="text-sm text-red-400"
                                    v-if="form.errors.poster_path"
                                >
                                    {{ form.errors.poster_path }}
                                </div>
                            </div>

                            <div class="mt-4">
                                <InputLabel
                                    for="backdrop_path"
                                    value="Backdrop"
                                />
                                <TextInput
                                    id="backdrop_path"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.backdrop_path"
                                    autofocus
                                    autocomplete="backdrop_path"
                                />
                                <div
                                    class="text-sm text-red-400"
                                    v-if="form.errors.backdrop_path"
                                >
                                    {{ form.errors.backdrop_path }}
                                </div>
                            </div>

                            <div class="mt-4">
                                <InputLabel for="overview" value="Overview" />
                                <TextInput
                                    id="overview"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.overview"
                                    autofocus
                                    autocomplete="overview"
                                />
                                <div
                                    class="text-sm text-red-400"
                                    v-if="form.errors.overview"
                                >
                                    {{ form.errors.overview }}
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="flex items-center">
                                    <Checkbox
                                        name="is_public"
                                        v-model:checked="form.is_public"
                                    />
                                    <span class="ml-2 text-sm text-gray-600"
                                        >Public</span
                                    >
                                </label>
                                <div
                                    class="text-sm text-red-400"
                                    v-if="form.errors.is_public"
                                >
                                    {{ form.errors.is_public }}
                                </div>
                            </div>

                            <div class="flex items-center pt-6 justify-between">
                                <PrimaryButton
                                    class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 text-white rounded"
                                    :class="{
                                        'opacity-25': form.processing,
                                    }"
                                    :disabled="form.processing"
                                >
                                    Update
                                </PrimaryButton>

                                <div class="ml-5 pt-2">
                                    <Link
                                        :href="route('admin.movies.index')"
                                        class="px-4 py-2 bg-green-600 hover:bg-green-800 text-white rounded-lg"
                                    >
                                        Back Movie
                                    </Link>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div
                        class="w-2/3 flex flex-col text-xl justify-center items-center"
                    >
                        <span class="mb-2 text-gray-800 font-semibold"
                            >Poster for reference</span
                        >
                        <img
                            class="w-7/12 h-7/12 rounded"
                            :src="`https://www.themoviedb.org/t/p/w600_and_h900_bestv2/${movie.poster_path}`"
                        />
                    </div>
                </section>
            </div>
        </div>
    </AdminLayout>
</template>
<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Link, useForm } from "@inertiajs/vue3";
import { ref, watch, defineProps } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import Checkbox from "@/Components/Checkbox.vue";

const props = defineProps({
    movie: Object,
});

const form = useForm({
    title: props.movie.title,
    poster_path: props.movie.poster_path,
    video_format: props.movie.video_format,
    runtime: props.movie.runtime,
    rating: props.movie.rating,
    backdrop_path: props.movie.backdrop_path,
    overview: props.movie.overview,
    is_public: props.movie.is_public ? true : false,
    lang: props.movie.lang,
});

function submitMovie() {
    form.put(`/admin/movies/${props.movie.id}`);
}
</script>
<style lang=""></style>
