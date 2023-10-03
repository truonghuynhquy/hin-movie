<template lang="">
    <div class="flex justify-center">
        <template v-for="(link, key) in links" :key="key">
            <div
                v-if="link.url === null"
                v-html="link.label"
                class="mb-1 mr-1 px-4 py-3 text-gray-400 text-sm leading-4 border border-gray-400 rounded"
            ></div>
            <Link
                v-else
                :href="link.url"
                v-html="link.label"
                class="mb-1 mr-1 px-4 py-3 text-gray-800 text-sm leading-4 border border-gray-800 rounded hover:text-indigo-700 hover:bg-gray-100"
                :class="{
                    'bg-indigo-200': link.active,
                }"
            ></Link>
        </template>
    </div>
</template>
<script setup>
import { Link } from "@inertiajs/vue3";
import { defineProps } from "vue";

defineProps({
    links: Array,
});
</script>
<style lang=""></style>
