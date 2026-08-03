<template>
  <component
    :is="to ? resolveComponent('NuxtLink') : 'button'"
    :to="to"
    :class="cn(
      'rounded-xl px-lg py-sm font-label-md transition-colors duration-200 shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-secondary disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-sm',
      variant === 'primary' ? 'bg-primary text-on-primary hover:bg-surface-tint' : '',
      variant === 'outline' ? 'bg-surface-container-lowest border border-outline-variant text-on-surface hover:bg-surface-container-low' : '',
      variant === 'ghost' ? 'text-on-surface-variant hover:text-primary hover:bg-surface-variant shadow-none' : '',
      variant === 'danger' ? 'bg-error text-on-error hover:bg-error-container hover:text-error' : '',
      block ? 'w-full' : '',
      props.class
    )"
    :disabled="disabled"
    @click="emit('click')"
  >
    <slot />
  </component>
</template>

<script setup lang="ts">
import { cn } from '~/utils/cn'

const props = withDefaults(defineProps<{
  variant?: 'primary' | 'outline' | 'ghost' | 'danger'
  block?: boolean
  disabled?: boolean
  to?: string | object
  class?: string
}>(), {
  variant: 'primary',
  block: false,
  disabled: false
})

const emit = defineEmits<{
  (e: 'click'): void
}>()
</script>
