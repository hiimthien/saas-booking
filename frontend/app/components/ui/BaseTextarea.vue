<script setup lang="ts">
import { computed } from 'vue';

interface Props {
  label?: string;
  id?: string;
  modelValue: string | number;
  placeholder?: string;
  error?: string;
  charLimit?: number;
  rows?: number;
  required?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
  rows: 4,
  required: false,
});

const emit = defineEmits<{
  (e: 'update:modelValue', value: string): void;
}>();

const charCount = computed(() => props.modelValue?.toString().length || 0);

const handleInput = (event: Event) => {
  const target = event.target as HTMLTextAreaElement;
  emit('update:modelValue', target.value);
};
</script>

<template>
  <div class="flex flex-col gap-1.5 w-full text-left">
    <div class="flex justify-between items-end">
      <label v-if="label" :for="id" class="text-sm font-medium text-slate-700">
        {{ label }}<span v-if="required" class="text-emerald-600 ml-0.5">*</span>
      </label>
      <span v-if="charLimit" class="text-[10px] font-medium text-slate-400">
        {{ charCount }} / {{ charLimit }}
      </span>
    </div>
    
    <div class="relative">
      <textarea
        :id="id"
        :value="modelValue"
        :placeholder="placeholder"
        :rows="rows"
        :maxlength="charLimit"
        :class="[
          'w-full px-4 py-3 text-sm border bg-white focus:outline-none focus:ring-2 transition-all duration-200 rounded-xl resize-none',
          error 
            ? 'border-red-300 focus:ring-red-100 text-red-900 placeholder-red-300' 
            : 'border-slate-200 focus:ring-emerald-50 focus:border-emerald-500 text-slate-900 placeholder-slate-400'
        ]"
        @input="handleInput"
      ></textarea>
    </div>
    
    <p v-if="error" class="text-xs text-red-600 mt-1">{{ error }}</p>
  </div>
</template>