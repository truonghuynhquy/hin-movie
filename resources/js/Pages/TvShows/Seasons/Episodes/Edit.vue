<template lang="">
    <AdminLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Episode Edit
            </h2>
        </template>

        <div class="py-2">
            <div class="max-w-7xl mx-auto">
                <section class="container mx-auto p-6 font-mono">
                    <div
                        class="w-full mb-8 sm:max-w-md p-6 overflow-hidden bg-white rounded-lg shadow-lg"
                    >
                        <form @submit.prevent="submitEpisode">
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
                                <InputLabel for="overview" value="Overview" />
                                <TextInput
                                    id="overview"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.overview"
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
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing"
                                >
                                    Update
                                </PrimaryButton>

                                <div class="ml-5 pt-2">
                                    <Link
                                        :href="
                                            route('admin.episodes.index', [
                                                tvShow.id,
                                                season.id,
                                            ])
                                        "
                                        class="px-4 py-2 bg-green-600 hover:bg-green-800 text-white rounded-lg"
                                    >
                                        Back Seasons
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
import Checkbox from "@/Components/Checkbox.vue";

const props = defineProps({
    tvShow: Object,
    season: Object,
    episode: Object,
});

const form = useForm({
    name: props.episode.name,
    overview: props.episode.overview,
    is_public: props.episode.is_public ? true : false,
});

function submitEpisode() {
    form.put(
        `/admin/tv-shows/${props.tvShow.id}/seasons/${props.season.id}/episodes/${props.episode.id}`
    );
}
</script>
<style lang=""></style>
