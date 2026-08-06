<script setup lang="ts">
interface Props {
  modelValue: string | number | boolean;
  value: string | number | boolean;
  label?: string;
  name: string;
  disabled?: boolean;
}

const props = defineProps<Props>();
const emit = defineEmits<{
  (e: 'update:modelValue', value: string | number | boolean): void;
}>();

const isSelected = () => props.modelValue === props.value;

const select = () => {
  if (!props.disabled) {
    emit('update:modelValue', props.value);
  }
};
</script>

<template>
  <div class="flex items-center gap-3 cursor-pointer group" @click="select">
    <div
      class="relative flex items-center justify-center w-5 h-5 border-2 rounded-full transition-all duration-200 shrink-0"
      :class="[
        isSelected() 
          ? 'border-emerald-600' 
          : 'bg-white border-slate-200 group-hover:border-emerald-300',
        disabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer'
      ]"
    >
      <div 
        v-if="isSelected()"
        class="w-2.5 h-2.5 bg-emerald-600 rounded-full"
      />
    </div>
    <label v-if="label" class="text-sm text-slate-700 cursor-pointer select-none">
      {{ label }}
    </label>
  </div>
</template>