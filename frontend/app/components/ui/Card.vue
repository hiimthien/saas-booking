<template>
  <div :class="cn('bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm text-on-surface overflow-hidden', props.class)">
    <slot />
  </div>
</template>

<script setup lang="ts">
import { cn } from '~/utils/cn'

const props = defineProps<{
  class?: string
}>()
</script>
