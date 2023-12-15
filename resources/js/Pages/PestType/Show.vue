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
            <div
                class="grid grid-cols-1 lg:grid-cols-3 gap-y-4 lg:gap-y-0 lg:gap-x-4"
            >
                <div class="col-span-2">
                    <!-- START: Details -->
                    <Card class="mb-4">
                        <template #card-header>
                            <h3
                                class="text-lg font-semibold text-gray-900 whitespace-nowrap md:mb-0 mb-3"
                            >
                                Details
                            </h3>
                        </template>
                        <template #card-body>
                            <div
                                class="grid gap-4 md:grid-cols-2 sm:gap-6 mb-5"
                            >
                                <!-- Name -->
                                <DisplayData label="Name" :value="model.name" />
                            </div>
                            <div class="grid gap-4 sm:gap-6 mb-5">
                                <DisplayData
                                    label="Description"
                                    :value="model.description"
                                />
                            </div>
                            <div class="grid gap-4 sm:gap-6 mb-5">
                                <DisplayData
                                    label="Pesticide"
                                >
                                    <div
                                        v-for="(item, index) in model.pesticides" :key="index"
                                    >
                                        {{ index + 1 }}. {{ item.name }}
                                    </div>
                                </DisplayData>
                            </div>
                        </template>
                    </Card>
                    <!-- END: Details -->
                    <div class="flex flex-col md:flex-row gap-3 md:gap-2">
                        <DynamicLink
                            :href="
                                '/' + url + '/' + model.id.toString() + '/edit'
                            "
                            type="primary"
                        >
                            Edit
                        </DynamicLink>
                        <DynamicLink :href="'/' + url" type="secondary">
                            Back
                        </DynamicLink>
                    </div>
                </div>
                <div class="col-span-1">
                    <!-- START: Image -->
                    <div
                        class="mb-4 flex flex-col items-center p-4 lg:p-6 bg-white rounded-lg shadow"
                    >
                        <img
                            :src="
                                (model.pest_type_photo != null) &
                                (model.pest_type_photo != '')
                                    ? model.pest_type_photo
                                    : '/no-image.png'
                            "
                            class="w-52 h-52 object-cover rounded-md"
                        />
                    </div>
                    <!-- END: Image -->
                    <!-- START: Timeline -->
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
                    <!-- END: Timeline -->
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
import PageHeader from '@/Components/Layouts/PageHeader.vue'

const moduleName = "Pest Types";
const url = "pest-types";
const pageTitle = "View Pest Type";

const props = defineProps({
    model: Object,
});
</script>
<style lang=""></style>
