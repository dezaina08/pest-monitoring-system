<template>
    <div class="pb-4 bg-white rounded-t-lg shadow">
        <div
            class="flex flex-col md:flex-row justify-between gap-y-4 px-4 pt-5 gap-x-10"
        >
            <div class="flex items-center justify-center gap-x-2">
                <label
                    for="per_page"
                    class="block text-sm font-medium text-gray-700 dark:text-white whitespace-nowrap"
                    >Per Page</label
                >
                <select
                    v-model="currentPerPage"
                    id="per_page"
                    name="per_page"
                    autocomplete="per_page"
                    class="block w-full rounded-md border border-gray-300 bg-white dark:bg-gray-700 h-10 pl-3 pr-8 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm text-gray-700 dark:text-white"
                >
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div class="flex">
                <!-- START: Search Input -->
                <div
                    class="flex items-center rounded-lg shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-inset focus-within:ring-blue-600 focus-within:ring-2 bg-white h-10 w-full md:w-auto pr-7 relative"
                    v-if="hasSearchInput"
                >
                    <span
                        class="flex select-none items-center pl-3 text-gray-500 sm:text-sm"
                    >
                        <MagnifyingGlassIcon class="h-6 w-6" />
                    </span>
                    <input
                        type="text"
                        id="search"
                        autocomplete="off"
                        class="block flex-1 border-0 bg-transparent py-1.5 pl-2 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                        placeholder="Search"
                        v-model="tempSearch"
                        @keyup.enter="searchRecords()"
                    />
                    <button
                        v-if="tempSearch"
                        class="w-6 h-6 flex items-center justify-center absolute right-2"
                        @click="clearSearch()"
                    >
                        <XMarkIcon class="h-4 w-4" />
                    </button>
                </div>
                <!-- END: Search Input -->
                <slot name="filter"></slot>
                <slot name="column-toggle"></slot>
            </div>
        </div>
    </div>
    <div class="overflow-x-auto bg-white rounded-b-lg shadow">
        <div class="mb-4">
            <div
                v-if="deleteItem.selectedItems.length"
                class="px-4 flex justify-between items-center bg-gray-100 border-b py-3"
            >
                <div class="text-gray-700 font-medium">
                    {{ deleteItem.selectedItems.length }} item<span
                        v-if="deleteItem.selectedItems.length > 1"
                        >s</span
                    >
                    selected
                </div>
                <div v-if="hasCheckbox">
                    <button
                        class="flex items-center text-sm font-bold text-red-400 hover:text-red-500"
                        @click="
                            deleteItem.confirmDelete(
                                props.url,
                                deleteItem.selectedItems
                            )
                        "
                    >
                        <TrashIcon class="w-4 h-4 mr-1" />
                        Delete Selected
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th class="pl-4 py-3 w-8" v-if="hasCheckbox">
                                <input
                                    id="check-all-boxes"
                                    type="checkbox"
                                    class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-600"
                                    v-model="deleteItem.selectAll"
                                    @click="toggleSelectAll()"
                                />
                            </th>
                            <th
                                v-for="(header, index) in visibleTableHeader"
                                :key="header.title"
                                :class="header.class"
                                scope="col"
                            >
                                <button
                                    type="button"
                                    class="flex items-center gap-x-1s"
                                    @click="setOrderBy(header.column)"
                                    :disabled="header.column == null"
                                    :class="[
                                        header.column == orderBy
                                            ? 'text-blue-600 hover:text-blue-700'
                                            : 'hover:text-gray-900',
                                    ]"
                                >
                                    {{ header.title }}
                                    <div class="h-5 w-5">
                                        <ChevronUpDownIcon
                                            v-if="header.column != null"
                                            class="h-5 w-5"
                                        />
                                    </div>
                                </button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <slot name="tr"> </slot>
                    </tbody>
                </table>
            </div>
        </div>
        <PaginationComponent
            class="px-4 pb-4"
            :totalPages="props.response.last_page ?? 0"
            :perPage="parseInt(currentPerPage) ?? 0"
            :currentPage="props.response.current_page ?? 0"
            :from="props.response.from ?? 0"
            :to="props.response.to ?? 0"
            :total="props.response.total ?? 0"
            :maxVisibleButtons="
                props.response.last_page > 7 ? 7 : props.response.last_page
            "
            :url="props.url"
            :search="search"
            :orderBy="orderBy"
            :orderType="orderType"
            :additionalArgumentProp="additionalArgumentProp"
        />
    </div>
</template>
<script setup>
import PaginationComponent from "@/Components/Table/Pagination.vue";
import {
    MagnifyingGlassIcon,
    ChevronUpDownIcon,
    XMarkIcon,
    TrashIcon,
} from "@heroicons/vue/24/outline";
import { ref, toRef, watch, onUnmounted, computed } from "vue";
import { useDeleteItemStore } from "@/stores/deleteItem";

const props = defineProps({
    response: Object,
    search: {
        type: String,
        default: "",
    },
    url: {
        type: String,
        default: "",
    },
    tableHeader: Object,
    order: {
        type: Object,
        default: {
            orderBy: "",
            orderType: "",
        },
    },
    additionalArgumentProp: {
        type: String,
        default: "",
    },
    hasCheckbox: {
        type: Boolean,
        default: true,
    },
    hasSearchInput: {
        type: Boolean,
        default: true,
    },
});

// START FOR TOGGLE
const headerVisibility = toRef(props, "tableHeader");

const toggleColumnVisibility = (index) => {
    headerVisibility.value[index].visible =
        !headerVisibility.value[index].visible;
};

const visibleTableHeader = computed(() => {
    return props.tableHeader.filter((header) => header.visible);
});
// END FOR TOGGLE

const emit = defineEmits(["update:selectedItems"]);
const deleteItem = useDeleteItemStore();

// Temporary search variable
const tempSearch = ref(JSON.parse(JSON.stringify(props.search)));

const currentPerPage = ref(
    JSON.parse(JSON.stringify(props.response.per_page ?? 10))
);

const search =
    props.search != ""
        ? ref(JSON.parse(JSON.stringify(props.search)))
        : ref("");

const orderBy =
    props.order.orderBy != ""
        ? ref(JSON.parse(JSON.stringify(props.order.orderBy)))
        : ref("");

const orderType =
    props.order.orderType != ""
        ? ref(JSON.parse(JSON.stringify(props.order.orderType)))
        : ref("");

const setOrderBy = (column) => {
    if (orderBy.value != column) {
        orderBy.value = column;
        orderType.value = "";
    } else {
        if (orderType.value == "desc") {
            orderType.value = "asc";
        } else {
            // reset values
            orderType.value = "";
            orderBy.value = "";
        }
    }
};

const searchRecords = () => {
    // Set for watcher in Pagination component
    search.value = tempSearch.value;
};

const clearSearch = () => {
    tempSearch.value = "";
    searchRecords();
};

const toggleSelectAll = () => {
    if (deleteItem.selectAll == false) {
        // Select all items
        deleteItem.selectedItems = props.response.data;
    } else {
        // Select none
        deleteItem.selectedItems = [];
    }
};

// Uncheck 'Select All' box when 'per page' is changed
watch(currentPerPage, (newValue, oldValue) => {
    deleteItem.selectAll = false;
});

onUnmounted(() => {
    deleteItem.selectAll = false;
    deleteItem.selectedItems = [];
});
</script>
<style lang="scss"></style>
