<script setup lang="ts">
import { ref } from 'vue';

interface Props {
  title?: string;
  content?: string;
  defaultOpen?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
  defaultOpen: false,
});

const isOpen = ref(props.defaultOpen);

const toggle = () => {
  isOpen.value = !isOpen.value;
};
</script>

<template>
  <div class="border border-slate-100 rounded-xl overflow-hidden bg-white">
    <button
      @click="toggle"
      class="w-full px-6 py-4 flex items-center justify-between text-left hover:bg-slate-50 transition-colors"
    >
      <span class="text-sm font-semibold text-slate-900">
        <slot name="title">{{ title }}</slot>
      </span>
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="h-5 w-5 text-slate-400 transition-transform duration-300"
        :class="{ 'rotate-180': isOpen }"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
      >
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
      </svg>
    </button>
    
    <div
      v-show="isOpen"
      class="px-6 py-4 border-t border-slate-50 text-sm text-slate-600 leading-relaxed"
    >
      <slot>{{ content }}</slot>
    </div>
  </div>
</template>