<template>
    <div class="relative">
        <div class="h-16 w-full"></div>
        <nav
            class="fixed left-0 right-0 top-0 bg-white border-b border-gray-200 px-4 md:px-6 z-40 h-16 flex items-center shadow-md"
        >
            <div class="flex flex-wrap justify-between items-center w-full">
                <div class="flex justify-start items-center">
                    <a href="/" class="flex items-center justify-between mr-4">
                        <img
                            src="https://flowbite.s3.amazonaws.com/logo.svg"
                            class="mr-3 h-8"
                            alt="Flowbite Logo"
                        />
                        <span
                            class="self-center text-2xl font-semibold whitespace-nowrap max-w-[120px] md:max-w-3xl truncate"
                        >
                            <!-- {{ $page.props.business.navbar_title }} -->
                        </span>
                    </a>
                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <Link
                            class="flex w-full justify-between rounded-lg px-4 py-2 text-left font-medium hover:bg-gray-100 focus:outline-none focus-visible:ring focus-visible:ring-gray-500 focus-visible:ring-opacity-75"
                            :href="'/dashboard'"
                            :class="[
                                $page.url.startsWith('/dashboard')
                                    ? 'text-gray-600 bg-sky-100 hover:bg-sky-200'
                                    : 'text-gray-700 hover:bg-gray-100',
                            ]"
                        >
                            Dashboard
                        </Link>
                    </div>

                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <Link
                            class="flex w-full justify-between rounded-lg px-4 py-2 text-left font-medium hover:bg-gray-100 focus:outline-none focus-visible:ring focus-visible:ring-gray-500 focus-visible:ring-opacity-75"
                            :href="'/pest-types'"
                            :class="[
                                $page.url.startsWith('/pest-types')
                                    ? 'text-gray-600 bg-sky-100 hover:bg-sky-200'
                                    : 'text-gray-700 hover:bg-gray-100',
                            ]"
                        >
                            Pest-types
                        </Link>
                    </div>
                </div>

                <div class="flex items-center lg:order-2">
                    <Menu
                        as="div"
                        class="relative inline-block text-left"
                        v-slot="{ open }"
                    >
                        <div>
                            <MenuButton
                                class="inline-flex w-full justify-center items-center gap-x-3 rounded-md py-2 text-sm font-medium focus:outline-none group"
                            >
                                <span
                                    class="hidden md:block text-gray-500 group-hover:text-gray-700 transition ease-in-out duration-300"
                                    :class="{ 'text-gray-700': open }"
                                >
                                    {{ $page.props.auth.user.name }}
                                </span>
                                <img
                                    v-if="$page.props.auth.user.profile_photo"
                                    :src="$page.props.auth.user.profile_photo"
                                    alt="user photo"
                                    class="w-8 h-8 object-cover border-2 border-gray-300 group-hover:border-gray-400 rounded-full transition ease-in-out duration-300"
                                    :class="{ 'border-gray-400': open }"
                                />
                                <div
                                    v-else
                                    class="bg-amber-200 text-amber-600 w-8 h-8 rounded-full flex justify-center items-center border-2 border-gray-300 group-hover:border-gray-400 transition ease-in-out duration-300"
                                    :class="{ 'border-gray-400': open }"
                                >
                                    {{ $page.props.auth.user.name[0] }}
                                </div>
                            </MenuButton>
                        </div>

                        <transition
                            enter-active-class="transition duration-100 ease-out"
                            enter-from-class="transform scale-95 opacity-0"
                            enter-to-class="transform scale-100 opacity-100"
                            leave-active-class="transition duration-75 ease-in"
                            leave-from-class="transform scale-100 opacity-100"
                            leave-to-class="transform scale-95 opacity-0"
                        >
                            <MenuItems
                                class="absolute right-0 mt- border w-56 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                            >
                                <div
                                    class="flex items-center py-3 px-5 gap-x-4"
                                >
                                    <div class="w-6 h-6">
                                        <UserCircleIcon
                                            class="w-6 h-6 text-gray-400"
                                        />
                                    </div>
                                    <div class="truncate">
                                        <span
                                            class="block text-sm font-semibold text-gray-600"
                                        >
                                            {{ $page.props.auth.user.username }}
                                        </span>
                                        <span
                                            class="block text-sm text-gray-600 truncate"
                                        >
                                            {{ $page.props.auth.user.email }}
                                        </span>
                                    </div>
                                </div>
                                <div class="px-1 py-1">
                                    <MenuItem v-slot="{ active }">
                                        <Link
                                            :href="route('profile.edit')"
                                            class="flex items-center gap-x-4 py-2 px-4 text-sm hover:bg-gray-200 text-gray-600"
                                        >
                                            <Cog6ToothIcon
                                                class="w-6 h-6 text-gray-400"
                                            />
                                            My profile
                                        </Link>
                                    </MenuItem>
                                </div>

                                <div class="px-1 py-1">
                                    <MenuItem v-slot="{ active }">
                                        <Link
                                            :href="route('logout')"
                                            method="post"
                                            as="button"
                                            class="flex items-center gap-x-4 py-2 px-4 text-sm hover:bg-gray-200 w-full text-start text-gray-600"
                                        >
                                            <ArrowRightOnRectangleIcon
                                                class="w-6 h-6 text-gray-400"
                                            />
                                            Logout
                                        </Link>
                                    </MenuItem>
                                </div>
                            </MenuItems>
                        </transition>
                    </Menu>
                </div>
            </div>
        </nav>
    </div>
</template>
<script setup>
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";
import { Link, usePage } from "@inertiajs/vue3";
import {
    Bars3CenterLeftIcon,
    UserCircleIcon,
    Cog6ToothIcon,
    ArrowRightOnRectangleIcon,
} from "@heroicons/vue/24/outline";
</script>
