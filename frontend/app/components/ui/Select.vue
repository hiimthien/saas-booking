<template>
  <div class="flex flex-col gap-xs">
    <label v-if="label" :for="id" class="font-label-sm text-on-surface-variant uppercase">{{ label }}</label>
    <div class="relative">
      <select
        :id="id"
        :value="modelValue"
        :disabled="disabled"
        :class="cn(
          'w-full appearance-none bg-surface-container-lowest border border-outline-variant rounded-xl px-4 py-2 pr-10 text-on-surface font-body-md transition-all focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary',
          error ? 'border-error focus:ring-error focus:border-error' : '',
          disabled ? 'opacity-50 cursor-not-allowed bg-surface-container' : '',
          props.class
        )"
        @change="emit('update:modelValue', ($event.target as HTMLSelectElement).value)"
      >
        <option v-if="placeholder" value="" disabled>{{ placeholder }}</option>
        <option v-for="option in options" :key="option.value" :value="option.value">
          {{ option.label }}
        </option>
      </select>
      <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-on-surface-variant">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
      </div>
    </div>
    <span v-if="error" class="text-label-sm text-error mt-1">{{ error }}</span>
  </div>
</template>

<script setup lang="ts">
import { cn } from '~/utils/cn'

export interface SelectOption {
  value: string | number
  label: string
}

const props = withDefaults(defineProps<{
  id?: string
  modelValue?: string | number
  options: SelectOption[]
  label?: string
  placeholder?: string
  error?: string
  disabled?: boolean
  class?: string
}>(), {
  id: () => `select-${Math.random().toString(36).slice(2, 9)}`,
  disabled: false
})

const emit = defineEmits<{
  (e: 'update:modelValue', value: string): void
}>()
</script>
