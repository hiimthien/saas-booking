<template>
  <div v-if="modelValue" class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-inverse-surface/50 backdrop-blur-sm" @click.self="close">
    <div :class="cn('relative w-full max-w-md max-h-full p-4 mx-4 md:mx-auto', props.class)">
      <div class="relative bg-surface-container-lowest rounded-xl shadow-lg border border-outline-variant flex flex-col max-h-[90vh]">
        
        <!-- Header -->
        <div class="flex items-center justify-between p-md border-b border-outline-variant shrink-0">
          <h3 class="font-headline-md text-on-surface">{{ title }}</h3>
          <button type="button" class="text-on-surface-variant bg-transparent hover:bg-surface-variant hover:text-on-surface rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" @click="close">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        
        <!-- Body -->
        <div class="p-md space-y-4 overflow-y-auto font-body-md text-on-surface shrink">
          <slot />
        </div>
        
        <!-- Footer -->
        <div v-if="$slots.footer" class="flex items-center p-md border-t border-outline-variant shrink-0 rounded-b-xl bg-surface-container">
          <slot name="footer" />
        </div>
        
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { cn } from '~/utils/cn'

const props = defineProps<{
  modelValue: boolean
  title: string
  class?: string
}>()

const emit = defineEmits<{
  (e: 'update:modelValue', value: boolean): void
}>()

function close() {
  emit('update:modelValue', false)
}
</script>
