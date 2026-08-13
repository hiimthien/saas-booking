<script setup lang="ts">
import { cn } from '~/utils/cn'

interface Props {
  title: string
  description?: string
  icon?: any
}

defineProps<Props>()
</script>

<template>
  <div :class="cn('flex flex-col items-center justify-center p-12 text-center bg-slate-50/50 rounded-xl border-2 border-dashed border-slate-200', $attrs.class as any)">
    <div v-if="icon" class="mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-emerald-50 text-emerald-600 ring-8 ring-emerald-50/50">
      <component :is="icon" class="h-7 w-7" />
    </div>
    <h3 class="mb-2 text-lg font-medium text-slate-900">{{ title }}</h3>
    <p v-if="description" class="mb-6 text-sm text-slate-500 max-w-sm">
      {{ description }}
    </p>
    <slot name="action" />
  </div>
</template>
