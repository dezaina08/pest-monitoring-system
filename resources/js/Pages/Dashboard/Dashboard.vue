<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-12 px-4 sm:px-6 lg:px-8 relative">
            <div class="grid grid-cols-3">

            </div>
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
                                <div>
                                    <ListBox
                                        :items="dateRange"
                                        no-initial-item
                                        :model-value="bar_chart_date_range"
                                        v-on:update:model-value="bar_chart_date_range = $event.id ?? ''"
                                    />
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
                <!-- <div class="">
                    <Card>
                        <template #card-header>
                            <h3
                                class="text-lg font-semibold text-gray-900 whitespace-nowrap md:mb-0 mb-3"
                            >
                                Pest Count
                            </h3>
                        </template>
                        <template #card-body>

                        </template>
                    </Card>
                </div> -->
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref, computed, watch } from 'vue'
import { Chart as ChartJS,
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
import { router } from "@inertiajs/vue3";

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
    ArcElement,
)

const url = "dashboard";

const props = defineProps({
    pest_types: {
        type: Array,
        default: []
    },
    bar_chart_date_range: {
        type: null,
        default: ''
    },
})

const additionalArgument = ref('')

// Deep Copy
const bar_chart_date_range =
    props.bar_chart_date_range != ""
        ? ref(JSON.parse(JSON.stringify(props.bar_chart_date_range)))
        : ref("");

const pestTypeData = computed(() => {
    return props.pest_types.map(object => object.pests_count)
})

const pestTypeNames = computed(() => {
    return props.pest_types.map(object => object.name)
})

const barChartData = ref({
    labels: pestTypeNames.value,
    datasets: [
        {
            label: 'Pest Count',
            backgroundColor: '#f87979',
            data: pestTypeData.value
        }
    ]
})

const dateRange = ref([
    {
        id: 1,
        name: 'Today',
    },
    {
        id: 2,
        name: 'Yesterday',
    },
    {
        id: 3,
        name: 'Last 7 days',
    },
    {
        id: 4,
        name: 'Last 30 days',
    },
    {
        id: 5,
        name: 'Last 90 days',
    },
    {
        id: 6,
        name: 'All'
    },
])

watch(
    () => additionalArgument.value,
    (newValue, oldValue) => {
        router.get("/" + url + additionalArgument.value)
    }
)

watch(
    () => bar_chart_date_range.value,
    (newValue, oldValue) => {
        if (newValue != "") {
            additionalArgument.value = "?bar_chart_date_range=" + bar_chart_date_range.value
        }
    }
)
</script>
