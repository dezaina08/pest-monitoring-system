<template>
    <div :class="props.class">
        <dt :class="[
            labelClass == ''
                ? 'mb-2 font-semibold leading-none text-gray-900'
                : labelClass
            ]"
        >
            {{ props.label }}
        </dt>
        <dd :class="[
            valueClass == ''
                ? 'font-light text-gray-500 whitespace-pre-wrap break-all'
                : valueClass
            ]"
        >
            <slot>
                {{ !!props.value && props.value != '' ? props.value : '--' }}
            </slot>
        </dd>
    </div>
</template>
<script setup>
const props = defineProps({
    label: {
        type: String,
        default: '',
    },
    value: {
        type: null,
        default: '',
    },
    class: {
        type: String,
        default: '',
    },
    labelClass: {
        type: String,
        default: '',
    },
    valueClass: {
        type: String,
        default: '',
    }
})
</script>
