<script setup>
import { onMounted, ref } from "vue";

defineProps({
    modelValue: {
        type: String,
        required: true,
    },
    inputClass: {
        type: String,
        default: "",
    },
    inputTextSizeClass: {
        type: String,
        default: "text-sm",
    },
});

defineEmits(["update:modelValue"]);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute("autofocus")) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="border-gray-300 focus:border-blue-600 focus:ring-blue-600 rounded-md shadow-sm placeholder:text-gray-400"
        :class="inputClass + ' ' + inputTextSizeClass"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        ref="input"
    />
</template>
