<template>
    <Head :title="pageTitle" />

    <AuthenticatedLayout>
        <div class="py-4 px-4 sm:px-6 lg:px-8 relative">
            <PageHeader />
            <div class="mb-4">
                <div
                    class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-y-4 sm:gap-y-0"
                >
                <div class="flex items-center justify-start text-gray-950">
                        <img src="/pest-type.png" alt="" class="w-16">
                        <h1 class="text-5xl">{{ pageTitle }}</h1>
                    </div>
                </div>
                <div>
                    <Breadcrumb
                        :links="[
                            {
                                link: url,
                                title: moduleName,
                            },
                        ]"
                        :current="pageTitle"
                    />
                </div>
            </div>
            <form @submit.prevent="submitForm()" enctype="multipart/form-data">
                <div
                    class="grid grid-cols-1 lg:grid-cols-3 gap-y-4 lg:gap-y-0 lg:gap-x-4"
                >
                    <div class="col-span-2">
                        <Card class="mb-4">
                            <template #card-header>
                                <h3
                                    class="text-lg font-semibold text-gray-900 whitespace-nowrap md:mb-0 mb-3"
                                >
                                    Pest Type Details
                                </h3>
                            </template>
                            <template #card-body>
                                <div
                                    class="grid gap-4 md:grid-cols-2 sm:gap-6 mb-5"
                                >
                                    <div class="">
                                        <InputLabel for="name" value="Name" />
                                        <TextInput
                                            id="name"
                                            type="text"
                                            class="mt-1 block w-full h-10"
                                            v-model="form.name"
                                            required
                                            autofocus
                                            autocomplete="off"
                                            placeholder="Name"
                                        />
                                        <InputError
                                            class="mt-1"
                                            :message="form.errors.name"
                                        />
                                    </div>
                                </div>
                                <div class="grid gap-4 sm:gap-6 mb-5">
                                    <div class="">
                                        <InputLabel
                                            for="description"
                                            value="Description"
                                        />
                                        <TextareaInput
                                            id="description"
                                            type="number"
                                            class="mt-1 block w-full"
                                            v-model="form.description"
                                            placeholder="Description"
                                            rows="4"
                                        />
                                        <InputError
                                            class="mt-1"
                                            :message="form.errors.description"
                                        />
                                    </div>
                                </div>
                                <div
                                    class="grid gap-4 md:grid-cols-2 sm:gap-6 mb-5"
                                >
                                    <div class="">
                                        <InputLabel
                                            for="pesticide_id"
                                            value="Pesticide"
                                        />
                                        <Listbox
                                            as="div"
                                            v-model="form.pesticides"
                                            multiple
                                        >
                                            <div class="relative">
                                                <ListboxButton
                                                    class="relative w-full rounded-md border border-gray-300 bg-white pl-3 pr-10 text-left shadow-sm focus:border-blue-600 focus:outline-none focus:ring-1 focus:ring-blue-600 sm:text-sm h-10s py-2"
                                                >
                                                    <span
                                                        v-if="form.pesticides.length > 0"
                                                        class="flex flex-wrap gap-1"
                                                    >
                                                        <span
                                                            v-for="(item, index) in form.pesticides"
                                                            :key="index"
                                                            class="bg-blue-200 text-blue-700 px-2 py-1s rounded-lg font-bold"
                                                        >
                                                            {{ item.name }}
                                                        </span>
                                                    </span>
                                                    <span
                                                        v-else
                                                        class="text-gray-500"
                                                    >
                                                        Select Option
                                                    </span>
                                                    <span class="pointer-events-none absolute inset-y-0 right-0 ml-3 flex items-center pr-2">
                                                        <ChevronDownIcon class="h-4 w-4 text-gray-400" aria-hidden="true" />
                                                    </span>
                                                </ListboxButton>
                                                <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
                                                    <ListboxOptions
                                                        class="absolute z-10 mt-1 max-h-56 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
                                                    >
                                                        <ListboxOption
                                                            v-for="item in props.pesticides"
                                                            :key="item.id"
                                                            :value="item"
                                                            v-slot="{ active, selected }"
                                                        >
                                                        <li
                                                            :class="[
                                                                active ? 'text-white bg-blue-600' : '', 'relative cursor-default select-none py-2 pl-3 pr-9',
                                                                selected ? 'bg-blue-100 text-blue-700' : 'text-gray-900'
                                                                ]"
                                                        >
                                                            <div class="flex items-center">
                                                                <span :class="[selected ? 'font-semibold' : 'font-normal', 'block truncate']">{{ item.name }}</span>
                                                            </div>

                                                            <span v-if="selected" :class="[active ? 'text-white' : 'text-blue-600', 'absolute inset-y-0 right-0 flex items-center pr-4']">
                                                            <CheckIcon class="h-5 w-5" aria-hidden="true" />
                                                            </span>
                                                        </li>
                                                        </ListboxOption>
                                                    </ListboxOptions>
                                                </transition>
                                            </div>
                                        </Listbox>
                                        <InputError
                                            class="mt-1"
                                            :message="form.errors.pesticides"
                                        />
                                    </div>
                                </div>
                                <div
                                    class="flex flex-col md:flex-row gap-3 md:gap-2"
                                >
                                    <PrimaryButton :disabled="form.processing">
                                        Save
                                    </PrimaryButton>
                                    <DynamicLink
                                        :href="'/' + url"
                                        type="secondary"
                                    >
                                        Back
                                    </DynamicLink>
                                </div>
                            </template>
                        </Card>
                    </div>
                    <div class="col-span-1">
                        <div
                            class="mb-4 flex flex-col items-center p-4 lg:p-6 bg-white rounded-lg shadow"
                        >
                            <input
                                type="file"
                                accept="image/*"
                                @input="previewImage"
                                id="photo"
                                name="photo"
                                hidden
                            />

                            <div class="mb-4 flex flex-col items-center">
                                <img
                                    :src="
                                        (preview != null) & (preview != '')
                                            ? preview
                                            : '/no-image.png'
                                    "
                                    class="w-52 h-52 object-cover mb-2 rounded-md"
                                />
                                <div
                                    v-if="!!form.photo"
                                    class="text-sm text-gray-500"
                                >
                                    <p class="mb-0">
                                        File name: {{ form.photo.name }}
                                    </p>
                                    <p class="mb-0">
                                        Size:
                                        {{
                                            (form.photo.size / 1024).toFixed(2)
                                        }}KB
                                    </p>
                                </div>
                            </div>

                            <div class="flex justify-center gap-3">
                                <button
                                    @click="browseFile()"
                                    type="button"
                                    class="h-8 bg-blue-500 hover:bg-blue-600 text-white rounded-md px-3 text-sm"
                                >
                                    Browse File
                                </button>
                                <button
                                    v-if="preview"
                                    @click="resetFile()"
                                    type="button"
                                    class="h-8 bg-red-500 hover:bg-red-600 text-white rounded-md px-3 text-sm"
                                >
                                    Remove
                                </button>
                            </div>

                            <InputError
                                class="mt-2"
                                :message="form.errors.photo"
                            />
                        </div>
                        <!-- Timeline -->
                        <div class="mb-4 p-4 lg:p-6 bg-white rounded-lg shadow">
                            <DisplayData
                                label="Created:"
                                :value="
                                    model.created_at_iso_format +
                                    ' - ' +
                                    model.created_at_for_humans
                                "
                                class="mb-5"
                            />
                            <DisplayData
                                label="Updated:"
                                :value="
                                    model.updated_at_iso_format +
                                    ' - ' +
                                    model.updated_at_for_humans
                                "
                            />
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
import { ChevronDownIcon, CheckIcon } from "@heroicons/vue/24/solid";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import TextareaInput from "@/Components/TextareaInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import DynamicLink from "@/Components/DynamicLink.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Swal from "sweetalert2";
import { router } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import InputError from "@/Components/InputError.vue";
import DisplayData from "@/Components/DisplayData.vue";
import Card from "@/Components/Card.vue";
import {
    Listbox,
    ListboxButton,
    ListboxOptions,
    ListboxOption,
} from '@headlessui/vue'
import PageHeader from '@/Components/Layouts/PageHeader.vue'

const moduleName = "Pest Types";
const url = "pest-types";
const pageTitle = "Update Pest Types";

const props = defineProps({
    model: Object,
    pesticides: Array,
});

const form = useForm({
    id: props.model.id,
    photo: null,
    remove_photo: false,
    name: props.model.name,
    description: props.model.description,
    pesticides: [],
    // Form method spoofing
    _method: "put",
});

let submitForm = () => {
    form.post(route(url + ".update", props.model.id), {
        preserveScroll: true,
        onSuccess: () => {
            router.get("/" + url);
            Swal.fire({
                title: "Updated successfully",
                // text: "Created successfully.",
                icon: "success",
                confirmButtonColor: "#16A34A",
            }).then(() => {
                //
            });
        },
    });
};

const preview = ref(props.model.pest_type_photo);

let previewImage = (event) => {
    let input = event.target;
    if (input.files.length) {
        let reader = new FileReader();
        reader.onload = (e) => {
            preview.value = e.target.result;
        };
        form.photo = input.files[0];
        reader.readAsDataURL(input.files[0]);
        form.remove_photo = false;
    }
};

let browseFile = () => {
    document.getElementById("photo").click();
};

let resetFile = () => {
    form.photo = null;
    preview.value = null;
    form.remove_photo = true;
};

onMounted(() => {
    props.model.pesticides.forEach(modelItem => {
        let itemToPush = props.pesticides.find(item => item.id == modelItem.id)
        if (!!itemToPush) {
            form.pesticides.push(itemToPush)
        }
    })
})
</script>
<style lang=""></style>
