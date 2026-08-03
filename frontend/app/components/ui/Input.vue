<template>
  <div :class="cn('relative', props.class)">
    <div v-if="!floating && label" class="mb-xs">
      <label :for="id" class="font-label-sm text-on-surface-variant uppercase">{{ label }}</label>
    </div>
    <div class="relative flex items-center">
      <div v-if="$slots.icon" class="absolute left-3 text-on-surface-variant flex items-center justify-center pointer-events-none">
        <slot name="icon" />
      </div>
      <input
        :id="id"
        :type="type"
        :value="modelValue"
        :placeholder="floating ? ' ' : placeholder"
        :disabled="disabled"
        :required="required"
        :class="cn(
          'block w-full font-body-md text-body-md text-on-surface bg-surface-container-lowest border border-outline-variant appearance-none focus:outline-none focus:ring-1 focus:ring-secondary focus:border-secondary transition-colors',
          floating ? 'rounded-lg px-md pb-sm pt-xl peer' : 'rounded-xl px-4 py-2 placeholder:text-on-surface-variant/50',
          $slots.icon && !floating ? 'pl-10' : '',
          error ? 'border-error focus:ring-error focus:border-error' : '',
          disabled ? 'opacity-50 cursor-not-allowed bg-surface-container' : ''
        )"
        @input="emit('update:modelValue', ($event.target as HTMLInputElement).value)"
      >
      <label v-if="floating && label" :for="id" class="absolute font-body-sm text-body-sm text-on-surface-variant duration-300 transform -translate-y-3 scale-75 top-md z-10 origin-[0] start-md peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3 pointer-events-none">
        {{ label }}
      </label>
    </div>
    <span v-if="error" class="block text-label-sm text-error mt-1">{{ error }}</span>
  </div>
</template>

<script setup lang="ts">
import { cn } from '~/utils/cn'

const props = withDefaults(defineProps<{
  id?: string
  modelValue?: string | number
  label?: string
  placeholder?: string
  type?: string
  error?: string
  disabled?: boolean
  required?: boolean
  floating?: boolean
  class?: string
}>(), {
  id: () => `input-${Math.random().toString(36).slice(2, 9)}`,
  type: 'text',
  disabled: false,
  required: false,
  floating: false
})

const emit = defineEmits<{
  (e: 'update:modelValue', value: string): void
}>()
</script>
