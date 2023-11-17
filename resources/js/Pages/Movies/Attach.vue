<template lang="">
    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Movie Attach
            </h2>
        </template>

        <div class="py-2">
            <div class="max-w-7xl mx-auto">
                <section class="container mx-auto p-6 font-mono">
                    <div
                        class="w-full mb-8 sm:max-w-md p-6 overflow-hidden bg-white rounded-lg shadow-lg"
                    >
                        <div class="flex space-x-2">
                            <div v-for="trailer in trailers" :key="trailer.id">
                                <Link
                                    class="px-4 py-2 bg-red-500 hover:bg-red-700 rounded"
                                    :href="
                                        route(
                                            'admin.trailers.destroy',
                                            trailer.id
                                        )
                                    "
                                    method="delete"
                                    as="button"
                                    type="button"
                                >
                                    {{ trailer.name }}
                                </Link>
                            </div>
                        </div>
                        <form @submit.prevent="submitTrailer">
                            <div>
                                <InputLabel for="name" value="Name" />
                                <TextInput
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    autofocus
                                    autocomplete="name"
                                />
                                <div
                                    class="text-sm text-red-400"
                                    v-if="form.errors.name"
                                >
                                    {{ form.errors.name }}
                                </div>
                            </div>

                            <div>
                                <InputLabel for="embed_html" value="Embed" />
                                <textarea
                                    id="embed_html"
                                    v-model="form.embed_html"
                                    type="text"
                                    class="mt-1 block w-full"
                                >
                                </textarea>
                                <div
                                    class="text-sm text-red-400"
                                    v-if="form.errors.embed_html"
                                >
                                    {{ form.errors.embed_html }}
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <PrimaryButton
                                    class="ml-4"
                                    :class="{
                                        'opacity-25': form.processing,
                                    }"
                                    :disabled="form.processing"
                                >
                                    add trailer</PrimaryButton
                                >
                            </div>
                        </form>
                    </div>

                    <div
                        class="w-full mb-8 sm:max-w-md p-6 overflow-hidden bg-white rounded-lg shadow-lg"
                    >
                        <div class="flex space-x-2">
                            <div
                                v-for="download in downloads"
                                :key="download.id"
                            >
                                <Link
                                    class="px-4 py-2 bg-red-500 hover:bg-red-700 rounded"
                                    :href="
                                        route(
                                            'admin.downloads.destroy',
                                            download.id
                                        )
                                    "
                                    method="delete"
                                    as="button"
                                    type="button"
                                >
                                    {{ download.name }}
                                </Link>
                            </div>
                        </div>
                        <form @submit.prevent="submitDownload">
                            <div>
                                <InputLabel for="name" value="Name" />
                                <TextInput
                                    id="name"
                                    v-model="formDownload.name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    autofocus
                                    autocomplete="name"
                                />
                                <div
                                    class="text-sm text-red-400"
                                    v-if="formDownload.errors.name"
                                >
                                    {{ formDownload.errors.name }}
                                </div>
                            </div>

                            <div>
                                <InputLabel for="web_url" value="Url" />
                                <TextInput
                                    id="web_url"
                                    v-model="formDownload.web_url"
                                    type="text"
                                    class="mt-1 block w-full"
                                />
                                <div
                                    class="text-sm text-red-400"
                                    v-if="formDownload.errors.web_url"
                                >
                                    {{ formDownload.errors.web_url }}
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <PrimaryButton
                                    class="ml-4"
                                    :class="{
                                        'opacity-25': formDownload.processing,
                                    }"
                                    :disabled="formDownload.processing"
                                >
                                    add download</PrimaryButton
                                >
                            </div>
                        </form>
                    </div>

                    <div
                        class="w-full mb-8 sm:max-w-md p-6 bg-white rounded-lg shadow-lg"
                    >
                        <div>
                            <div class="flex">
                                <div
                                    class="m-2 p-1 text-xs"
                                    v-for="mc in movieCasts"
                                    :key="mc.id"
                                >
                                    {{ mc.name }}
                                </div>
                            </div>
                            <form @submit.prevent="addCast">
                                <VueMultiselect
                                    v-model="selected"
                                    :options="options"
                                ></VueMultiselect>
                                <div class="mt-2">
                                    <JetButton>add casts</JetButton>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div
                        class="w-full mb-8 sm:max-w-md p-6 bg-white rounded-lg shadow-lg"
                    >
                        <div>
                            <div class="flex">
                                <div
                                    class="m-2 p-1 text-xs"
                                    v-for="mt in movieTags"
                                    :key="mt.id"
                                >
                                    {{ mt.tag_name }}
                                </div>
                            </div>
                            <form @submit.prevent="addTag">
                                <VueMultiselect
                                    v-model="selected"
                                    :options="options"
                                ></VueMultiselect>
                                <div class="mt-2">
                                    <JetButton>add tags</JetButton>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="ml-5 pt-2">
                        <Link
                            :href="route('admin.movies.index')"
                            class="px-4 py-2 bg-green-600 hover:bg-green-800 text-white rounded-lg"
                        >
                            Back Movie
                        </Link>
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
import VueMultiselect from "vue-multiselect";

const props = defineProps({
    movie: Object,
    trailers: Array,
    downloads: Array,
    casts: Array,
    tags: Array,
    movieTags: Array,
    movieCasts: Array,
});

const selected = ref("");
const options = ["list", "of", "options"];

const form = useForm({
    name: "",
    embed_html: "",
});

const formDownload = useForm({
    name: "",
    web_url: "",
});

const castForm = useForm({
    casts: props.movieCasts,
});
const tagForm = useForm({
    tags: props.movieTags,
});

function submitTrailer() {
    form.post(`/admin/movies/${props.movie.id}/add-trailer`, {
        onSuccess: () => form.reset(),
    });
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
<style lang=""></style>
