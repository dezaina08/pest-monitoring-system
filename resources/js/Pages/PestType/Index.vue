<template>
    <Table
        :url="url"
        :response="props.response"
        :table-header="tableHeader"
        :search="props.search"
        :order="props.order"
    >
        <template #tr>
            <tr
                v-if="props.response.data.length"
                v-for="item in props.response.data"
                :key="item.id"
                class="border-b hover:bg-gray-100 text-gray-500"
            >
                <td class="pl-4 py-3">
                    <input
                        :id="'checkbox_' + item.id"
                        type="checkbox"
                        class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-600 transition ease-in-out duration-150"
                        :value="item"
                        v-model="deleteItem.selectedItems"
                    />
                </td>
                <td v-show="tableHeader[0].visible" class="px-4 py-3">
                    {{ item.id }}
                </td>
                <td
                    v-show="tableHeader[1].visible"
                    class="px-4 py-3 font-medium whitespace-nowrap text-gray-900"
                >
                    {{ item.name }}
                </td>
                <!-- Actions -->
                <td class="text-sm font-light px-4 py-3">
                    <Menu
                        as="div"
                        class="inline-block text-left"
                        v-slot="{ open }"
                    >
                        <MenuButton
                            :class="open ? 'bg-gray-200' : ''"
                            class="inline-flex items-center text-sm font-medium hover:bg-gray-200 p-1.5 text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none"
                        >
                            <EllipsisHorizontalIcon
                                class="w-5 h-5 text-gray-500"
                            />
                        </MenuButton>
                        <transition
                            enter-active-class="transition duration-100 ease-out"
                            enter-from-class="transform scale-95 opacity-0"
                            enter-to-class="transform scale-100 opacity-100"
                            leave-active-class="transition duration-75 ease-in"
                            leave-from-class="transform scale-100 opacity-100"
                            leave-to-class="transform scale-95 opacity-0"
                        >
                            <MenuItems
                                as="ul"
                                class="absolute right-8 sm:right-10 lg:right-12 min-w-[164px] origin-top-right mt-1 divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none grid z-50"
                            >
                                <MenuItem as="li">
                                    <Link
                                        :href="url + '/' + item.id"
                                        class="flex items-center py-2 px-4 hover:bg-gray-100 w-full"
                                    >
                                        <EyeIcon
                                            class="block h-5 w-5 mr-2"
                                            aria-hidden="true"
                                        />
                                        View
                                    </Link>
                                </MenuItem>
                                <MenuItem as="li">
                                    <Link
                                        :href="url + '/' + item.id + '/edit'"
                                        class="flex items-center py-2 px-4 hover:bg-gray-100 w-full"
                                    >
                                        <PencilSquareIcon
                                            class="block h-5 w-5 mr-2"
                                            aria-hidden="true"
                                        />
                                        Edit
                                    </Link>
                                </MenuItem>
                                <MenuItem as="li">
                                    <button
                                        type="button"
                                        class="flex items-center py-2 px-4 hover:bg-gray-100 text-red-500 w-full"
                                        @click="
                                            deleteItem.confirmDelete(
                                                url,
                                                item.id,
                                                item.name
                                            )
                                        "
                                    >
                                        <TrashIcon
                                            class="block h-5 w-5 mr-2"
                                            aria-hidden="true"
                                        />
                                        Delete
                                    </button>
                                </MenuItem>
                            </MenuItems>
                        </transition>
                    </Menu>
                </td>
            </tr>
            <tr
                v-else
                class="bg-white border-b transition duration-300 ease-in-out hover:bg-gray-100"
            >
                <td
                    :colspan="tableHeader.length"
                    class="text-sm text-gray-900 font-light px-6 py-3 whitespace-nowrap text-center"
                >
                    No records
                </td>
            </tr>
        </template>
    </Table>
</template>
<script setup>
import { Link } from "@inertiajs/vue3";
import {
    EyeIcon,
    PencilSquareIcon,
    TrashIcon,
    EllipsisHorizontalIcon,
} from "@heroicons/vue/24/outline";
import { ref } from "vue";
import Table from "@/Components/Table/Table.vue";
import { useDeleteItemStore } from "@/stores/deleteItem";
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";

const url = "pest-types";
const pageTitle = "Pest Types";
const deleteItem = useDeleteItemStore();

const props = defineProps({
    columns: Array,
    response: Object,
});

// column = database column name, used for sortBy, null to disable sorting
const tableHeader = ref([
    {
        title: "ID",
        class: "px-4 py-3",
        column: "id",
        visible: true,
    },
    {
        title: "NAME",
        class: "px-4 py-3",
        column: "name",
        visible: true,
    },
    {
        title: "",
        class: "px-4 py-3 w-8",
        column: null,
        visible: true,
    },
]);
</script>
<style lang=""></style>
