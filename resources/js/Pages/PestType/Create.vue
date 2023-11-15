<template>
    <Head :title="pageTitle" />

    <AuthenticatedLayout>
        <div class="py-12 grid px-4 sm:px-6 lg:px-8">
            <div class="mb-4">
                <div
                    class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-y-4 sm:gap-y-0"
                >
                    <div class="flex items-center justify-start text-gray-500">
                        <BugAntIcon
                            class="h-10 w-10 transition duration-75 mr-3"
                        />
                        <h1 class="text-3xl">{{ pageTitle }}</h1>
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
                                    Pest Type Details
                                </h3>
                            </template>
                            <template #card-body>
                                <div
                                    class="grid gap-4 md:grid-cols-2 sm:gap-6 mb-5"
                                >
                                    <div class="">
                                        <InputLabel
                                            for="name"
                                            value="Name"
                                        />
                                        <TextInput
                                            id="name"
                                            type="text"
                                            class="mt-1 block w-full h-10"
                                            v-model="form.name"
                                            required
                                            autofocus
                                            autocomplete="off"
                                            placeholder="Type pest name"
                                        />
                                        <InputError
                                            class="mt-1"
                                            :message="form.errors.name"
                                        />
                                    </div>
                                </div>
                                <div
                                    class="grid gap-4 md:grid-cols-2 sm:gap-6 mb-5"
                                >
                                    <div class="">
                                        <InputLabel
                                            for="description"
                                            value="Description"
                                        />
                                        <TextareaInput
                                            id="description"
                                            class="mt-1 block w-full"
                                            v-model="form.description"
                                            placeholder="Type pest description"
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
                                        <ListBox
                                            id="pesticide_id"
                                            :items="props.pesticides"
                                            :model-value="form.pesticide_id"
                                            v-on:update:model-value="form.pesticide_id = $event.id"
                                        />
                                        <InputError
                                            class="mt-1"
                                            :message="form.errors.pesticide_id"
                                        />
                                    </div>
                                </div>
                                <div
                                    class="flex flex-col md:flex-row gap-3 md:gap-2"
                                >
                                    <PrimaryButton :disabled="form.processing">
                                        Save
                                    </PrimaryButton>
                                    <PrimaryButton
                                        type="button"
                                        :disabled="form.processing"
                                        @click="submitForm(true)"
                                    >
                                        Save & Add Another
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
                        <Card class="mb-4">
                            <template #card-header>
                                <h3
                                    class="text-lg font-semibold text-gray-900 whitespace-nowrap md:mb-0 mb-3"
                                >
                                    Image
                                </h3>
                            </template>
                            <template #card-body>
                                <input
                                    type="file"
                                    accept="image/*"
                                    @input="previewImage"
                                    id="photo"
                                    name="photo"
                                    hidden
                                />

                                <div class="mb-2 flex flex-col items-center">
                                    <img
                                        :src="preview ?? '/pest-no-image.png'"
                                        class="h-44 object-cover mb-2 rounded-md"
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
                                                (
                                                    form.photo.size / 1024
                                                ).toFixed(2)
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
                            </template>
                        </Card>
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
import { BugAntIcon } from "@heroicons/vue/24/solid";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import TextareaInput from "@/Components/TextareaInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import DynamicLink from "@/Components/DynamicLink.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Swal from "sweetalert2";
import { router } from "@inertiajs/vue3";
import { ref } from "vue";
import InputError from "@/Components/InputError.vue";
import Card from "@/Components/Card.vue";
import ListBox from "@/Components/ListBox.vue";

const moduleName = "Pest Types";
const url = "pest-types";
const pageTitle = "Create Pest Types";

const props = defineProps({
    pesticides: Array,
})

const form = useForm({
    photo: null,
    remove_photo: false,
    name: "",
    description: "",
    pesticide_id: "",
});

let submitForm = (addAnother = false) => {
    form.post(route(url + ".store"), {
        preserveScroll: true,
        onSuccess: () => {
            if (addAnother) {
                router.get("/" + url + "/create");
            } else {
                router.get("/" + url);
            }
            Swal.fire({
                title: "Created successfully",
                // text: "Created successfully.",
                icon: "success",
                confirmButtonColor: "#16A34A",
            }).then(() => {
                //
            });
        },
    });
};

const preview = ref(null);

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
</script>
<style lang=""></style>
