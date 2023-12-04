<template>
    <Head :title="pageTitle" />

    <AuthenticatedLayout>
        <div class="py-4 px-4 sm:px-6 lg:px-8 relative">
            <div class="mb-4">
                <span
                    class="self-center text-2xl font-semibold whitespace-nowrap truncate"
                >
                    Capiz State University Pilar Satellite College
                </span>
            </div>
            <div class="mb-4">
                <div
                    class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-y-4 sm:gap-y-0"
                >
                <div class="flex items-center justify-start text-gray-950">
                        <img src="/total-pest.png" alt="" class="w-16">
                        <h1 class="text-5xl">{{ pageTitle }}</h1>
                    </div>
                </div>
                <div>
                    <Breadcrumb :current="pageTitle" />
                </div>
            </div>
            <form @submit.prevent="submitForm()">
                <div
                    class="grid grid-cols-1 lg:grid-cols-3 gap-y-4 lg:gap-y-0 lg:gap-x-4"
                >
                    <div class="col-span-2">
                        <Card class="mb-4">
                            <template #card-header>
                                <h3
                                    class="text-lg font-semibold text-gray-900 whitespace-nowrap md:mb-0 mb-3"
                                >
                                    Pest Types
                                </h3>
                            </template>
                            <template #card-body>
                                <div
                                    class="flex flex-wrap gap-5 justify-center"
                                >
                                    <div
                                        v-for="(item, index) in pest_types"
                                        :key="index"
                                        class=""
                                    >
                                        <div class="rounded-lg overflow-hidden">
                                            <img
                                                :src="
                                                    item.pest_type_photo != ''
                                                        ? item.pest_type_photo
                                                        : '/no-image.png'
                                                "
                                                alt="Pest Type Photo"
                                                class="object-contain w-full h-auto md:w-24 md:h-24"
                                            />
                                        </div>
                                        <div class="text-xs py-2">
                                            <div class="mb-1 w-24 truncate">
                                                {{ item.name }}
                                            </div>
                                            <div
                                                class="flex items-center rounded-md shadow-sm ring-1 focus-within:ring-2 ring-inset ring-gray-300 focus-within:ring-inset focus-within:ring-blue-600 h-6 w-full md:w-24"
                                                :class="[
                                                    item.count > 0
                                                        ? 'bg-amber-200'
                                                        : 'bg-white',
                                                ]"
                                            >
                                                <button
                                                    type="button"
                                                    class="items-center px-2 text-gray-400 sm:text-sm hover:text-gray-800"
                                                    @click="
                                                        updateItemQuantity(
                                                            index,
                                                            'decrement'
                                                        )
                                                    "
                                                >
                                                    <MinusIcon
                                                        class="h-4 w-4"
                                                    />
                                                </button>
                                                <input
                                                    :id="'quantity_' + index"
                                                    type="text"
                                                    min="0"
                                                    autocomplete="off"
                                                    class="border-0 bg-transparent py-0 px-0 text-gray-900 placeholder:text-gray-400 focus:ring-0 text-sm sm:leading-6 text-center w-full"
                                                    v-model="item.count"
                                                    required
                                                    placeholder="Qty"
                                                    @input="
                                                        calculateEachItemTotal(
                                                            index
                                                        )
                                                    "
                                                    disabled
                                                />
                                                <button
                                                    type="button"
                                                    class="items-center px-2 text-gray-400 sm:text-sm hover:text-gray-800"
                                                    @click="
                                                        updateItemQuantity(
                                                            index,
                                                            'increment'
                                                        )
                                                    "
                                                >
                                                    <PlusIcon class="h-4 w-4" />
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </Card>
                    </div>
                    <div class="col-span-1">
                        <div class="bg-white p-4 rounded-lg shadow">
                            <div class="mb-5">
                                <InputLabel
                                    for="date_captured"
                                    value="Date Captured"
                                />
                                <TextInput
                                    id="date_captured"
                                    type="date"
                                    class="mt-1 block w-full h-10"
                                    v-model="date_captured"
                                    autocomplete="off"
                                    placeholder="Date Captured"
                                />
                            </div>
                            <div v-if="props.pest_images.length > 0">
                                <div class="flex justify-center mb-5">
                                    <img
                                        :src="
                                            props.pest_images[
                                                currentPestImageIndex
                                            ].pest_image_photo
                                        "
                                        alt=""
                                        class="object-contain rounded-lg"
                                        width="250"
                                    />
                                </div>
                                <div class="flex justify-between items-center">
                                    <button
                                        type="button"
                                        class="px-4 py-2 border-2 border-gray-400 hover:border-gray-700 rounded-lg text-sm font-bold text-gray-600 hover:text-gray-700"
                                        @click="submit('prev')"
                                        :disabled="buttonDisabled"
                                        :class="{
                                            'opacity-50': buttonDisabled,
                                        }"
                                    >
                                        Prev
                                    </button>
                                    <div>
                                        {{ currentPestImageIndex + 1 }} /
                                        {{ props.pest_images.length }}
                                    </div>
                                    <button
                                        v-if="
                                            currentPestImageIndex !=
                                            props.pest_images.length - 1
                                        "
                                        type="button"
                                        class="px-4 py-2 border-2 rounded-lg text-sm border-green-500 hover:border-green-700 text-green-600 hover:text-green-700 font-bold"
                                        @click="submit('next')"
                                        :disabled="buttonDisabled"
                                        :class="{
                                            'opacity-50': buttonDisabled,
                                        }"
                                    >
                                        Next
                                    </button>
                                    <button
                                        v-else
                                        type="button"
                                        class="px-4 py-2 border-2 rounded-lg text-sm border-green-500 hover:border-green-700 text-green-600 hover:text-green-700 font-bold"
                                        @click="submit('done')"
                                        :disabled="buttonDisabled"
                                        :class="{
                                            'opacity-50': buttonDisabled,
                                        }"
                                    >
                                        Done
                                    </button>
                                </div>
                            </div>
                            <div v-else>
                                <div class="text-sm text-red-600">
                                    No image captured on this date
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import { BugAntIcon, MinusIcon, PlusIcon } from "@heroicons/vue/24/solid";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import TextareaInput from "@/Components/TextareaInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import DynamicLink from "@/Components/DynamicLink.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Swal from "sweetalert2";
import { router } from "@inertiajs/vue3";
import { ref, watch, computed, onMounted } from "vue";
import InputError from "@/Components/InputError.vue";
import Card from "@/Components/Card.vue";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";

const moduleName = "Counting";
const url = "pests";
const pageTitle = "Counting";

const $toast = useToast();

const props = defineProps({
    pest_types: {
        type: Array,
        default: [],
    },
    pest_images: {
        type: Array,
        default: [],
    },
    date_captured: {
        type: String,
        default: "",
    },
    pest_image_id: {
        type: null,
        default: "",
    },
});

// Deep Copy
const date_captured =
    props.date_captured != ""
        ? ref(JSON.parse(JSON.stringify(props.date_captured)))
        : ref("");

const pest_types =
    props.pest_types != []
        ? ref(JSON.parse(JSON.stringify(props.pest_types)))
        : ref([]);

const additionalArgument = ref("");

watch(
    () => date_captured.value,
    (newValue, oldValue) => {
        if (newValue != "") {
            additionalArgument.value = "?date_captured=" + date_captured.value;
        }
    }
);

watch(
    () => additionalArgument.value,
    (newValue, oldValue) => {
        router.get("/" + url + additionalArgument.value);
    }
);

const submit = (action = "prev") => {
    if (
        (action == "prev" && currentPestImageIndex.value == 0) ||
        (action == "next" &&
            currentPestImageIndex.value == props.pest_images.length - 1)
    ) {
        return false;
    }

    axios
        .post("/" + url, {
            pest_image_id: pestImageId.value,
            pest_types: pest_types.value,
            date_captured: date_captured.value,
        })
        .then(function (response) {
            if (action == "prev") {
                prevPestImage();
            } else if (action == "next") {
                nextPestImage();
            }
            $toast.open({
                type: "success",
                message: "Pest count saved!",
                position: "top-right",
            });
        })
        .catch(function (error) {
            console.log(error);
        });
};

const currentPestImageIndex = ref(
    props.pest_images.findIndex((object) => {
        return object.id == props.pest_image_id;
    })
);

// Set current pests count
onMounted(() => {
    props.pest_images[currentPestImageIndex.value]?.pests.forEach(
        (pestObject) => {
            pest_types.value.find((pestTypeObject) => {
                if (pestObject.pest_type_id == pestTypeObject.id) {
                    pestTypeObject.count = pestObject.count;
                    return true;
                }
            });
        }
    );
});

let pestImageId = computed(() => {
    return props.pest_images[currentPestImageIndex.value]["id"];
});

let buttonDisabled = computed(() => {
    let disabled = true;
    pest_types.value.forEach((element) => {
        if (element.count > 0) {
            disabled = false;
        }
    });
    return disabled;
});

const prevPestImage = () => {
    if (currentPestImageIndex.value != 0) {
        currentPestImageIndex.value -= 1;
        additionalArgument.value =
            "?date_captured=" +
            date_captured.value +
            "&pest_image_id=" +
            pestImageId.value;
    }
};

const nextPestImage = () => {
    if (currentPestImageIndex.value != props.pest_images.length - 1) {
        currentPestImageIndex.value += 1;
        additionalArgument.value =
            "?date_captured=" +
            date_captured.value +
            "&pest_image_id=" +
            pestImageId.value;
    }
};

const updateItemQuantity = (index, method) => {
    let item = pest_types.value[index];

    if (method == "increment") {
        if (item.count == "") {
            item.count = 0;
        }

        item.count = parseInt(item.count) + 1;
    } else {
        if (item.count == "" || parseInt(item.count) < 1) {
            item.count = 0;
        } else {
            item.count = parseInt(item.count) - 1;
        }
    }
};
</script>
<style lang=""></style>
