<script setup>
import { ref } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";
import ApplicationMark from "@/Components/ApplicationMark.vue";
import Banner from "@/Components/Banner.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import Sidebar from "@/Components/Sidebar.vue";

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);
const dropdownOpen = ref(false);
const notificationOpen = ref(false);

const switchToTeam = (team) => {
    router.put(
        route("current-team.update"),
        {
            team_id: team.id,
        },
        {
            preserveState: false,
        }
    );
};

const logout = () => {
    router.post(route("logout"));
};
</script>

<template>
    <div>
        <Head :title="title" />

        <Banner />

        <div class="flex h-screen bg-gray-200 font-roboto">
            <Sidebar />
            <div class="flex-1 flex flex-col overflow-hidden">
                <header
                    class="flex justify-between items-center py-4 px-6 bg-white border-b-4 border-indigo-600"
                >
                    <div class="flex items-center">
                        <button
                            @click="sidebarOpen = true"
                            class="text-gray-500 focus:outline-none lg:hidden"
                        >
                            <svg
                                class="h-6 w-6"
                                viewBox="0 0 24 24"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M4 6H20M4 12H20M4 18H11"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>
                        </button>

                        <div class="relative mx-4 lg:mx-0">
                            <span
                                class="absolute inset-y-0 left-0 pl-3 flex items-center"
                            >
                                <svg
                                    class="h-5 w-5 text-gray-500"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                >
                                    <path
                                        d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    />
                                </svg>
                            </span>

                            <input
                                class="form-input w-32 sm:w-64 rounded-md pl-10 pr-4 focus:border-indigo-600"
                                type="text"
                                placeholder="Search"
                            />
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div
                            x-data="{ notificationOpen: false }"
                            class="relative"
                        >
                            <button
                                @click="notificationOpen = !notificationOpen"
                                class="flex mx-4 text-gray-600 focus:outline-none"
                            >
                                <svg
                                    class="h-6 w-6"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M15 17H20L18.5951 15.5951C18.2141 15.2141 18 14.6973 18 14.1585V11C18 8.38757 16.3304 6.16509 14 5.34142V5C14 3.89543 13.1046 3 12 3C10.8954 3 10 3.89543 10 5V5.34142C7.66962 6.16509 6 8.38757 6 11V14.1585C6 14.6973 5.78595 15.2141 5.40493 15.5951L4 17H9M15 17V18C15 19.6569 13.6569 21 12 21C10.3431 21 9 19.6569 9 18V17M15 17H9"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    />
                                </svg>
                            </button>

                            <div
                                v-show="notificationOpen"
                                @click="notificationOpen = false"
                                class="fixed inset-0 h-full w-full z-10"
                            ></div>

                            <div
                                v-show="notificationOpen"
                                class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl overflow-hidden z-10"
                                style="width: 20rem"
                            >
                                <a
                                    href="#"
                                    class="flex items-center px-4 py-3 text-gray-600 hover:text-white hover:bg-indigo-600 -mx-2"
                                >
                                    <img
                                        class="h-8 w-8 rounded-full object-cover mx-1"
                                        src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=334&q=80"
                                        alt="avatar"
                                    />
                                    <p class="text-sm mx-2">
                                        <span class="font-bold" href="#"
                                            >Sara Salah</span
                                        >
                                        replied on the
                                        <span
                                            class="font-bold text-indigo-400"
                                            href="#"
                                            >Upload Image</span
                                        >
                                        artical . 2m
                                    </p>
                                </a>
                                <a
                                    href="#"
                                    class="flex items-center px-4 py-3 text-gray-600 hover:text-white hover:bg-indigo-600 -mx-2"
                                >
                                    <img
                                        class="h-8 w-8 rounded-full object-cover mx-1"
                                        src="https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=634&q=80"
                                        alt="avatar"
                                    />
                                    <p class="text-sm mx-2">
                                        <span class="font-bold" href="#"
                                            >Slick Net</span
                                        >
                                        start following you . 45m
                                    </p>
                                </a>
                                <a
                                    href="#"
                                    class="flex items-center px-4 py-3 text-gray-600 hover:text-white hover:bg-indigo-600 -mx-2"
                                >
                                    <img
                                        class="h-8 w-8 rounded-full object-cover mx-1"
                                        src="https://images.unsplash.com/photo-1450297350677-623de575f31c?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=334&q=80"
                                        alt="avatar"
                                    />
                                    <p class="text-sm mx-2">
                                        <span class="font-bold" href="#"
                                            >Jane Doe</span
                                        >
                                        Like Your reply on
                                        <span
                                            class="font-bold text-indigo-400"
                                            href="#"
                                            >Test with TDD</span
                                        >
                                        artical . 1h
                                    </p>
                                </a>
                                <a
                                    href="#"
                                    class="flex items-center px-4 py-3 text-gray-600 hover:text-white hover:bg-indigo-600 -mx-2"
                                >
                                    <img
                                        class="h-8 w-8 rounded-full object-cover mx-1"
                                        src="https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=398&q=80"
                                        alt="avatar"
                                    />
                                    <p class="text-sm mx-2">
                                        <span class="font-bold" href="#"
                                            >Abigail Bennett</span
                                        >
                                        start following you . 3h
                                    </p>
                                </a>
                            </div>
                        </div>

                        <div class="relative">
                            <button
                                @click="dropdownOpen = !dropdownOpen"
                                class="relative block h-8 w-8 rounded-full overflow-hidden shadow focus:outline-none"
                            >
                                <img
                                    class="h-full w-full object-cover"
                                    src="https://haycafe.vn/wp-content/uploads/2022/03/Anime-nu-dang-yeu.jpg"
                                    alt="Your avatar"
                                />
                            </button>

                            <div
                                v-show="dropdownOpen"
                                @click="dropdownOpen = false"
                                class="fixed inset-0 h-full w-full z-10"
                            ></div>

                            <div
                                v-show="dropdownOpen"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md overflow-hidden shadow-xl z-10"
                            >
                                <a
                                    href=""
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white"
                                    >Profile</a
                                >
                                <a
                                    href=""
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white"
                                >
                                    {{ $page.props.auth.user.name }}</a
                                >
                                <form @submit.prevent="logout">
                                    <button
                                        type="submit"
                                        class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-indigo-600 hover:text-white focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                                    >
                                        Log out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </header>
                <!-- Page Heading -->
                <header v-if="$slots.header" class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <slot name="header" />
                    </div>
                </header>

                <!-- Page Content -->
                <main
                    class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200"
                >
                    <slot></slot>
                </main>
            </div>
        </div>
    </div>
</template>
