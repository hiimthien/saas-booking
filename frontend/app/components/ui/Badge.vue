<template>
  <span
    :class="cn(
      'px-sm py-xs rounded-full font-label-sm flex items-center justify-center gap-xs w-max border',
      variant === 'primary' ? 'bg-primary-container/20 text-primary border-primary/30' : '',
      variant === 'success' ? 'bg-primary-fixed text-on-primary-fixed border-primary-fixed-dim/30' : '',
      variant === 'warning' ? 'bg-[#fff8e6] text-[#b38600] border-[#ffe599]' : '',
      variant === 'error' ? 'bg-error-container text-error border-error/30' : '',
      variant === 'neutral' ? 'bg-surface-variant text-on-surface-variant border-outline-variant/30' : '',
      props.class
    )"
  >
    <slot />
  </span>
</template>

<script setup lang="ts">
import { cn } from '~/utils/cn'

const props = withDefaults(defineProps<{
  variant?: 'primary' | 'success' | 'warning' | 'error' | 'neutral'
  class?: string
}>(), {
  variant: 'neutral'
})
</script>
