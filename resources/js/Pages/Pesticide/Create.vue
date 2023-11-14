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
                                    Pesticide Details
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

const moduleName = "Pesticides";
const url = "pesticides";
const pageTitle = "Create Pesticide";

const form = useForm({
    name: "",
    description: "",
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
</script>
<style lang=""></style>
