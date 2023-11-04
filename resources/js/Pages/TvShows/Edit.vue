<template lang="">
    <AdminLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tv Show Edit
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

                            <div class="mt-4">
                                <InputLabel for="poster_path" value="Poster" />
                                <TextInput
                                    id="poster_path"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.poster_path"
                                />
                                <div
                                    class="text-sm text-red-400"
                                    v-if="form.errors.poster_path"
                                >
                                    {{ form.errors.poster_path }}
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
                                        :href="route('admin.tv-shows.index')"
                                        class="px-4 py-2 bg-green-600 hover:bg-green-800 text-white rounded-lg"
                                    >
                                        Back Tv Shows
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
    tvShow: Object,
});

const form = useForm({
    name: props.tvShow.name,
    poster_path: props.tvShow.poster_path,
});

function submitGenre() {
    form.put(`/admin/tv-shows/${props.tvShow.id}`);
}
</script>

<style lang=""></style>
