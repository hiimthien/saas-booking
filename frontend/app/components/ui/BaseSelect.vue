<script setup lang="ts">
interface Props {
  modelValue: string | number;
  options: { label: string; value: string | number }[];
  label?: string;
  placeholder?: string;
  error?: string;
  required?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
  placeholder: 'Select an option',
});

const emit = defineEmits<{
  (e: 'update:modelValue', value: string | number): void;
}>();

const handleChange = (event: Event) => {
  const target = event.target as HTMLSelectElement;
  emit('update:modelValue', target.value);
};
</script>

<template>
  <div class="flex flex-col gap-1.5 w-full text-left">
    <label v-if="label" class="text-sm font-medium text-slate-700">
      {{ label }}<span v-if="required" class="text-emerald-600 ml-0.5">*</span>
    </label>
    <div class="relative">
      <select
        :value="modelValue"
        class="w-full px-3 py-2 text-sm border bg-white appearance-none focus:outline-none focus:ring-2 transition-all duration-200 rounded-xl cursor-pointer"
        :class="[
          error 
            ? 'border-red-300 focus:ring-red-100 text-red-900' 
            : 'border-slate-200 focus:ring-emerald-50 focus:border-emerald-500 text-slate-900'
        ]"
        @change="handleChange"
      >
        <option disabled value="">{{ placeholder }}</option>
        <option v-for="opt in options" :key="opt.value" :value="opt.value">
          {{ opt.label }}
        </option>
      </select>
      <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
      </div>
    </div>
    <p v-if="error" class="text-xs text-red-600 mt-1">{{ error }}</p>
  </div>
</template>