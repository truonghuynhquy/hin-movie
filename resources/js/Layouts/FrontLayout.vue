<template lang="">
    <div>
        <Head :title="title" />

        <Banner />

        <div class="min-h-screen bg-gray-100 dark:bg-gray-700">
            <!-- nav -->
            <Navbar />

            <!-- Page Content -->
            <main>
                <slot></slot>
            </main>
        </div>

        <Footer />
    </div>
</template>
<script>
import { defineComponent } from "vue";
import { Head, Link } from "@inertiajs/vue3";
import Navbar from "@/Components/Navbar.vue";
import Footer from "@/Components/Footer.vue";

export default defineComponent({
    props: {
        title: String,
    },

    components: {
        Head,
        Link,
        Navbar,
        Footer,
    },
});
</script>
<style lang=""></style>
