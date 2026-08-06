<script setup lang="ts">
interface Props {
  modelValue: boolean;
  label?: string;
  id?: string;
  disabled?: boolean;
  required?: boolean;
}

const props = defineProps<Props>();
const emit = defineEmits<{
  (e: 'update:modelValue', value: boolean): void;
}>();

const toggle = () => {
  if (!props.disabled) {
    emit('update:modelValue', !props.modelValue);
  }
};
</script>

<template>
  <div class="flex items-center gap-3 cursor-pointer group" @click="toggle">
    <div
      class="relative flex items-center justify-center w-5 h-5 border-2 rounded-lg transition-all duration-200 shrink-0"
      :class="[
        modelValue 
          ? 'bg-emerald-600 border-emerald-600' 
          : 'bg-white border-slate-200 group-hover:border-emerald-300',
        disabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer'
      ]"
    >
      <svg
        v-if="modelValue"
        xmlns="http://www.w3.org/2000/svg"
        class="h-3.5 w-3.5 text-white"
        viewBox="0 0 20 20"
        fill="currentColor"
      >
        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
      </svg>
    </div>
    <label v-if="label" :for="id" class="text-sm text-slate-700 cursor-pointer select-none">
      {{ label }}<span v-if="required" class="text-emerald-600 ml-0.5">*</span>
    </label>
  </div>
</template>