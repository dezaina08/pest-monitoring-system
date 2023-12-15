<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-4 px-4 sm:px-6 lg:px-8 relative">
            <PageHeader />
            <div class="grid grid-cols-3 gap-4">
                <div class="col-span-2">
                    <Card class="mb-5">
                        <template #card-header>
                            <div class="flex items-center justify-between">
                                <h3
                                    class="text-lg font-semibold text-gray-900 whitespace-nowrap md:mb-0 mb-3"
                                >
                                    Pest Count
                                </h3>
                                <div class="flex items-center gap-x-3">
                                    <VueDatePicker
                                        v-model="barChartDate"
                                        range
                                        format="yyyy-MM-dd"
                                        model-type="yyyy-MM-dd"
                                        week-start="0"
                                        :enable-time-picker="false"
                                        :preset-dates="presetDates"
                                        :partial-range="false"
                                        placeholder="Enter date range"
                                        @update:model-value="setDate"
                                    >
                                        <template
                                            #preset-date-range-button="{ label, value, presetDate }"
                                        >
                                            <span
                                                role="button"
                                                :tabindex="0"
                                                @click="presetDate(value)"
                                                @keyup.enter.prevent="presetDate(value)"
                                                @keyup.space.prevent="presetDate(value)"
                                            >
                                            {{ label }}
                                            </span>
                                        </template>
                                    </VueDatePicker>
                                    <a
                                        :href="'/export-pest-types?bar_chart_date_from=' + bar_chart_date_from + '&bar_chart_date_to=' + bar_chart_date_to"
                                        target="_blank"
                                        class="text-xs h-10 flex items-center px-4 border border-green-500 text-green-600 rounded hover:text-green-700"
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
                    <Card>
                        <template #card-header>
                            <div class="flex items-center justify-between">
                                <h3
                                    class="text-lg font-semibold text-gray-900 whitespace-nowrap md:mb-0 mb-3"
                                >
                                    Current Month Count Status ({{ limit }})
                                </h3>
                            </div>
                        </template>
                        <template #card-body>
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead>
                                        <tr class="border-y bg-amber-200">
                                            <th class="text-start px-2">
                                                #
                                            </th>
                                            <th class="text-start px-2">
                                                Pest Type
                                            </th>
                                            <th class="text-start px-2">
                                                Count
                                            </th>
                                            <th class="text-start px-2">
                                                Status
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template
                                            v-for="(item, index) in props.pest_type_current_month_count" :key="index"
                                        >
                                            <tr
                                                v-if="item.pests_count >= limit"
                                                class="border-b"
                                            >
                                                <td class="py-1 px-2">
                                                    {{ index + 1 }}
                                                </td>
                                                <td class="py-1 px-2">
                                                    <Link
                                                        :href="'/pest-types/' + item.id"
                                                        class="hover:underline text-blue-600 hover:text-blue-800"
                                                    >
                                                        {{ item.name }}
                                                    </Link>
                                                </td>
                                                <td class="py-1 px-2">
                                                    {{ item.pests_count }}
                                                </td>
                                                <td class="py-1 px-2 flex text-xs">
                                                    <!-- limit value -->
                                                    <div
                                                        class="px-3 py-1 text-white bg-red-500 rounded-lg"
                                                    >
                                                        Over
                                                    </div>
                                                    <!-- <div
                                                        v-else
                                                        class="px-3 py-1 text-white bg-green-500 rounded-lg"
                                                    >
                                                        Normal
                                                    </div> -->
                                                </td>
                                            </tr>
                                        </template>
                                        <tr
                                            v-if="checkCount(props.pest_type_current_month_count)"
                                        >
                                            <td
                                                class="text-center py-1 px-2"
                                                colspan="4"
                                            >
                                                No item
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
                                <img src="/pest-type.png" alt="" class="w-12">
                            </div>
                        </div>
                    </div>
                    <div class="p-4 lg:p-6 bg-white rounded-lg shadow mb-4">
                        <div class="flex justify-between">
                            <div>
                                <h5
                                    class="leading-none text-3xl font-bold text-gray-900 dark:text-white pb-2"
                                >
                                    {{ pesticides_count }}
                                </h5>
                                <p
                                    class="text-base font-normal text-gray-500 dark:text-gray-400"
                                >
                                    Total Pesticides
                                </p>
                            </div>
                            <div
                                class="flex items-center px-2.5 py-0.5 text-base font-semibold text-gray-500 dark:text-gray-500 text-center"
                            >
                            <img src="/pesticide.png" alt="" class="w-12">
                            </div>
                        </div>
                    </div>
                    <div class="p-4 lg:p-6 bg-white rounded-lg shadow mb-4">
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
                                <img src="/pest-images.png" alt="" class="w-12">
                            </div>
                        </div>
                    </div>
                    <div class="p-4 lg:p-6 bg-white rounded-lg shadow">
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
                            <img src="/total-pest.png" alt="" class="w-12">
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
import { Head, Link } from "@inertiajs/vue3";
import { ref, computed, watch } from "vue";
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
import { router } from "@inertiajs/vue3"
import { DocumentArrowDownIcon } from "@heroicons/vue/24/solid"
import { BugAntIcon } from "@heroicons/vue/24/solid"
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import { endOfWeek, endOfMonth, endOfYear, startOfWeek, startOfMonth, startOfYear, subDays, subWeeks, subMonths } from 'date-fns';
import PageHeader from '@/Components/Layouts/PageHeader.vue'

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
    pesticides_count: {
        type: Number,
        default: 0,
    },
    bar_chart_date_from: {
        type: null,
        default: "",
    },
    bar_chart_date_to: {
        type: null,
        default: "",
    },
    pest_type_current_month_count: {
        type: Array,
        default: []
    },
});

const additionalArgument = ref("");
const limit = ref(10)

// Deep Copy
const bar_chart_date_from =
    props.bar_chart_date_from != ""
        ? ref(JSON.parse(JSON.stringify(props.bar_chart_date_from)))
        : ref(startOfMonth(new Date()));

const bar_chart_date_to =
    props.bar_chart_date_to != ""
        ? ref(JSON.parse(JSON.stringify(props.bar_chart_date_to)))
        : ref(endOfMonth(new Date()));

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

const barChartDate = ref([
    bar_chart_date_from.value,
    bar_chart_date_to.value
]);

const presetDates = ref([
    {
        label: 'Today',
        value: [new Date(), new Date()]
    },
    {
        label: 'Yesterday',
        value: [subDays(new Date(), 1), subDays(new Date(), 1)],
    },
    {
        label: 'This Week',
        value: [startOfWeek(new Date()), endOfWeek(new Date())],
    },
    {
        label: 'Last Week',
        value: [startOfWeek(subWeeks(new Date(), 1)), endOfWeek(subWeeks(new Date(), 1))],
    },
    {
        label: 'This month',
        value: [startOfMonth(new Date()), endOfMonth(new Date())]
    },
    {
        label: 'Last month',
        value: [startOfMonth(subMonths(new Date(), 1)), endOfMonth(subMonths(new Date(), 1))],
    },
    {
        label: 'This year',
        value: [startOfYear(new Date()), endOfYear(new Date())]
    },
]);

const setDate = (value) => {
    if (value != null) {
        bar_chart_date_from.value = value[0]
        bar_chart_date_to.value = value[1]
    }
}

watch(
    () => additionalArgument.value,
    (newValue, oldValue) => {
        router.get("/" + url + additionalArgument.value);
    }
);

watch(
    () => barChartDate.value,
    (newValue, oldValue) => {
        if (newValue != null) {
            additionalArgument.value =
                "?bar_chart_date_from=" + bar_chart_date_from.value
                + "&bar_chart_date_to=" + bar_chart_date_to.value
        } else {
            router.get("/" + url)
        }
    }
)

let checkCount = (items) => {
    let visibility = true

    items.forEach(item => {
        if (item.pests_count >= limit.value) {
            visibility = false
        }
    })

    return visibility
}
</script>
