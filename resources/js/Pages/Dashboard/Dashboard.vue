<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-12 px-4 sm:px-6 lg:px-8 relative">
            <div class="grid grid-cols-3"></div>
            <div class="grid grid-cols-3 gap-4">
                <div class="col-span-2">
                    <Card>
                        <template #card-header>
                            <div class="flex items-center justify-between">
                                <h3
                                    class="text-lg font-semibold text-gray-900 whitespace-nowrap md:mb-0 mb-3"
                                >
                                    Pest Count
                                </h3>
                                <div class="flex items-center gap-x-3">
                                    <ListBox
                                        :items="dateRange"
                                        no-initial-item
                                        :model-value="bar_chart_date_range"
                                        v-on:update:model-value="
                                            bar_chart_date_range =
                                                $event.id ?? ''
                                        "
                                        class="min-w-[160px]"
                                    />
                                    <a
                                        :href="'/pest-types-export?bar_chart_date_range=' + bar_chart_date_range"
                                        target="_blank"
                                        class="text-xs h-10 flex items-center px-4 border border-green-500 text-green-600 rounded-lg hover:text-green-700"
                                        @click="exportPestCount()"
                                    >
                                        <DocumentArrowDownIcon class="h-5 w-5 mr-1" />
                                        Export
                                    </a>
                                </div>
                            </div>
                        </template>
                        <template #card-body>
                            <div>
                                <Bar :data="barChartData" />
                            </div>
                        </template>
                    </Card>
                </div>
                <div class="col-span-1">
                    <div class="p-4 lg:p-6 bg-white rounded-lg shadow mb-4">
                        <div class="flex justify-between">
                            <div>
                                <h5
                                    class="leading-none text-3xl font-bold text-gray-900 dark:text-white pb-2"
                                >
                                    {{ pests_count }}
                                </h5>
                                <p
                                    class="text-base font-normal text-gray-500 dark:text-gray-400"
                                >
                                    Total Pests
                                </p>
                            </div>
                            <div
                                class="flex items-center px-2.5 py-0.5 text-base font-semibold text-gray-500 dark:text-gray-500 text-center"
                            >
                                <BugAntIcon
                                    class="h-10 w-10 transition duration-75 mr-3"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="p-4 lg:p-6 bg-white rounded-lg shadow mb-4">
                        <div class="flex justify-between">
                            <div>
                                <h5
                                    class="leading-none text-3xl font-bold text-gray-900 dark:text-white pb-2"
                                >
                                    {{ pest_types_count }}
                                </h5>
                                <p
                                    class="text-base font-normal text-gray-500 dark:text-gray-400"
                                >
                                    Total Pest Types
                                </p>
                            </div>
                            <div
                                class="flex items-center px-2.5 py-0.5 text-base font-semibold text-gray-500 dark:text-gray-500 text-center"
                            >
                                <BugAntIcon
                                    class="h-10 w-10 transition duration-75 mr-3"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="p-4 lg:p-6 bg-white rounded-lg shadow">
                        <div class="flex justify-between">
                            <div>
                                <h5
                                    class="leading-none text-3xl font-bold text-gray-900 dark:text-white pb-2"
                                >
                                    {{ pest_images_count }}
                                </h5>
                                <p
                                    class="text-base font-normal text-gray-500 dark:text-gray-400"
                                >
                                    Total Pest Images
                                </p>
                            </div>
                            <div
                                class="flex items-center px-2.5 py-0.5 text-base font-semibold text-gray-500 dark:text-gray-500 text-center"
                            >
                                <BugAntIcon
                                    class="h-10 w-10 transition duration-75 mr-3"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref, computed, watch, onMounted } from "vue";
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
    ArcElement,
} from 'chart.js'
import { Bar } from 'vue-chartjs'
import Card from '@/Components/Card.vue'
import ListBox from '@/Components/ListBox.vue'
import { router } from "@inertiajs/vue3"
import { DocumentArrowDownIcon } from "@heroicons/vue/24/solid"
import { BugAntIcon } from "@heroicons/vue/24/solid";

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
    ArcElement
);

const url = "dashboard";

const props = defineProps({
    pest_types: {
        type: Array,
        default: [],
    },
    pests_count: {
        type: null,
        default: 0,
    },
    pest_types_count: {
        type: Number,
        default: 0,
    },
    pest_images_count: {
        type: Number,
        default: 0,
    },
    bar_chart_date_range: {
        type: null,
        default: "",
    },
});

const additionalArgument = ref("");

// Deep Copy
const bar_chart_date_range =
    props.bar_chart_date_range != ""
        ? ref(JSON.parse(JSON.stringify(props.bar_chart_date_range)))
        : ref("");

const pestTypeData = computed(() => {
    return props.pest_types.map((object) => object.pests_count);
});

const pestTypeNames = computed(() => {
    return props.pest_types.map((object) => object.name);
});

const barChartData = ref({
    labels: pestTypeNames.value,
    datasets: [
        {
            label: "Pest Count",
            backgroundColor: "#f87979",
            data: pestTypeData.value,
        },
    ],
});

const dateRange = ref([
    {
        id: 1,
        name: "Today",
    },
    {
        id: 2,
        name: "Yesterday",
    },
    {
        id: 3,
        name: "Last 7 days",
    },
    {
        id: 4,
        name: "Last 30 days",
    },
    {
        id: 5,
        name: "Last 90 days",
    },
    {
        id: 6,
        name: "All",
    },
]);

watch(
    () => additionalArgument.value,
    (newValue, oldValue) => {
        router.get("/" + url + additionalArgument.value);
    }
);

watch(
    () => bar_chart_date_range.value,
    (newValue, oldValue) => {
        if (newValue != "") {
            additionalArgument.value =
                "?bar_chart_date_range=" + bar_chart_date_range.value;
        }
    }
)

const exportPestCount = () => {
    router.get('/pest-types-export?bar_chart_date_range=' + bar_chart_date_range)
}
</script>
