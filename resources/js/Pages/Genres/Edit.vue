<template lang="">
    <AdminLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Genre Edit
            </h2>
        </template>

        <div class="py-2">
            <div class="max-w-7xl mx-auto">
                <section class="container mx-auto p-6 font-mono">
                    <div
                        class="w-full mb-8 p-6 sm:max-w-md overflow-hidden bg-white rounded-lg shadow-lg"
                    >
                        <form @submit.prevent="submitGenre">
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

                            <div class="flex items-center pt-6 justify-between">
                                <PrimaryButton
                                    class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 text-white rounded"
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing"
                                >
                                    Update
                                </PrimaryButton>

                                <div class="ml-5 pt-2">
                                    <Link
                                        :href="route('admin.genres.index')"
                                        class="px-4 py-2 bg-green-600 hover:bg-green-800 text-white rounded-lg"
                                    >
                                        Back Genres
                                    </Link>
                                </div>
                            </div>
                        </form>
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

const props = defineProps({
    genre: Object,
});

const form = useForm({
    title: props.genre.title,
});

function submitGenre() {
    form.put("/admin/genres/" + props.genre.id);
}
</script>

<style lang=""></style>
