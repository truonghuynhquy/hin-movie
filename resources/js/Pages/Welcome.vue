<script>
import { defineComponent } from "vue";
import { Head, Link } from "@inertiajs/vue3";
import FrontLayout from "@/Layouts/FrontLayout.vue";

export default defineComponent({
    components: {
        Head,
        Link,
        FrontLayout,
    },
});
</script>

<template>
    <Head title="Welcome" />

    <FrontLayout> Content </FrontLayout>
</template>
