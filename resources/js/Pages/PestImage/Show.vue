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
            <div
                class="grid grid-cols-1 lg:grid-cols-3 gap-y-4 lg:gap-y-0 lg:gap-x-4"
            >
                <div class="">
                    <Card class="mb-4">
                        <template #card-header>
                            <h3
                                class="text-lg font-semibold text-gray-900 whitespace-nowrap md:mb-0 mb-3"
                            >
                                Pest Image Details
                            </h3>
                        </template>
                        <template #card-body>
                            <!-- START: Image -->
                            <div
                                class="mb-4 flex flex-col items-center p-4 lg:p-6 bg-white rounded-lg shadow"
                            >
                                <img
                                    :src="
                                        (model.pest_image_photo != null) &
                                        (model.pest_image_photo != '')
                                            ? model.pest_image_photo
                                            : '/pestType-no-image.png'
                                    "
                                    class="w-52 h-52 object-cover rounded-md"
                                />
                            </div>
                            <!-- END: Image -->
                            <!-- START: Timeline -->
                            <div
                                class="mb-4 p-4 lg:p-6 bg-white rounded-lg shadow"
                            >
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
                            <!-- END: Timeline -->
                        </template>
                    </Card>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script setup>
import { Head, Link } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { BugAntIcon } from "@heroicons/vue/24/solid";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import DynamicLink from "@/Components/DynamicLink.vue";
import DisplayData from "@/Components/DisplayData.vue";
import Card from "@/Components/Card.vue";

const moduleName = "Pest Images";
const url = "pest-images";
const pageTitle = "View Pest Image";

const props = defineProps({
    model: Object,
});
</script>
<style lang=""></style>
