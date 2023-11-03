<template>
    <Head :title="pageTitle" />

    <div class="py-12 grid px-4 sm:px-6 lg:px-8">
        <div class="mb-4">
            <div
                class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-y-4 sm:gap-y-0"
            >
                <div class="flex items-center justify-start text-gray-500">
                    <TagIcon class="h-10 w-10 transition duration-75 mr-3" />
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
                                class="flex flex-col md:flex-row gap-3 md:gap-2"
                            >
                                <PrimaryButton :disabled="form.processing">
                                    Save
                                </PrimaryButton>
                                <DynamicLink :href="'/' + url" type="secondary">
                                    Back
                                </DynamicLink>
                            </div>
                        </template>
                    </Card>
                </div>
                <div class="col-span-1">
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
</template>
<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import { TagIcon } from "@heroicons/vue/24/solid";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import TextareaInput from "@/Components/TextareaInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import DynamicLink from "@/Components/DynamicLink.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Swal from "sweetalert2";
import { router } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import DisplayData from "@/Components/DisplayData.vue";
import Card from "@/Components/Card.vue";

const moduleName = "PestTypes";
const url = "pest-types";
const pageTitle = "Update Pest Types";

const props = defineProps({
    model: Object,
});

const form = useForm({
    id: props.model.id,
    name: props.model.name,
    symbol: props.model.symbol,
    description: props.model.description,
});

let submitForm = () => {
    form.patch(route(url + ".update", props.model.id), {
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
</script>
<style lang=""></style>
