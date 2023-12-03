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
                        <img src="/pest-images.png" alt="" class="w-16">
                        <h1 class="text-5xl">{{ pageTitle }}</h1>
                    </div>
                </div>
                <div>
                    <Breadcrumb
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
                                    Pest Image Details
                                </h3>
                            </template>
                            <template #card-body>
                                <div
                                    class="grid gap-4 sm:gap-6 mb-5"
                                >
                                    <div class="grid md:grid-cols-2">
                                        <div class="">
                                            <InputLabel
                                                for="date_captured"
                                                value="Date Captured"
                                            />
                                            <TextInput
                                                id="date_captured"
                                                type="date"
                                                class="mt-1 block w-full h-10"
                                                v-model="form.date_captured"
                                                required
                                                autofocus
                                                autocomplete="off"
                                                placeholder="Date Captured"
                                            />
                                            <InputError
                                                class="mt-1"
                                                :message="form.errors.date_captured"
                                            />
                                        </div>
                                    </div>
                                    <div class="grid md:grid-cols-2">
                                        <div class="">
                                            <InputLabel
                                                for="date_captured"
                                                value="Images"
                                            />
                                            <input
                                                type="file"
                                                accept="image/*"
                                                id="photos"
                                                name="photos"
                                                multiple
                                                @change="onFileChange"
                                                class="mt-1 block w-full h-10"
                                            />
                                            <InputError
                                                class="mt-2"
                                                :message="form.errors.photos"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="flex flex-col md:flex-row gap-3 md:gap-2"
                                >
                                    <PrimaryButton
                                        :disabled="form.processing"
                                    >
                                        Save
                                    </PrimaryButton>
                                    <!-- <PrimaryButton
                                        type="button"
                                        :disabled="form.processing"
                                        @click="submitForm(true)"
                                    >
                                        Save & Add Another
                                    </PrimaryButton> -->
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
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import { CloudArrowUpIcon } from "@heroicons/vue/24/solid";
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

const moduleName = "Upload Pest Images";
const url = "pest-images";
const pageTitle = "Upload Pest Images";

const form = useForm({
    photos: [],
    remove_photos: false,
    date_captured: "",
});

let submitForm = (addAnother = false) => {
    form.post(route(url + ".store"), {
        preserveScroll: true,
        onSuccess: () => {
            router.get("/" + url);
            Swal.fire({
                title: "Uploaded successfully",
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
        form.photos = input.files[0];
        reader.readAsDataURL(input.files[0]);
        form.remove_photos = false;
    }
};

let browseFile = () => {
    document.getElementById("photos").click();
};

let resetFile = () => {
    form.photos = null;
    preview.value = null;
    form.remove_photos = true;
};

let onFileChange = (e) => {
    var files = e.target.files || e.dataTransfer.files;
    if (!files.length) return;
    createImage(files);
}
let createImage = (files) => {
    for (var index = 0; index < files.length; index++) {
        var reader = new FileReader();
        reader.onload = function(event) {
        const imageUrl = event.target.result;
        form.photos.push(imageUrl);
    }
    reader.readAsDataURL(files[index]);
}
}
</script>
<style lang=""></style>
