<script setup lang="ts">
import { computed } from 'vue';

interface Props {
  label: string;
  type?: 'success' | 'warning' | 'error' | 'neutral' | 'info';
  isRounded?: boolean;
  dot?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
  type: 'neutral',
  isRounded: true,
  dot: false,
});

const classes = computed(() => {
  const base = 'inline-flex items-center px-2.5 py-0.5 text-xs font-medium';
  const rounded = props.isRounded ? 'rounded-full' : 'rounded-lg';
  
  const types = {
    success: 'bg-emerald-50 text-emerald-700',
    warning: 'bg-amber-50 text-amber-700',
    error: 'bg-red-50 text-red-700',
    neutral: 'bg-slate-100 text-slate-700',
    info: 'bg-blue-50 text-blue-700',
  };

  return `${base} ${rounded} ${types[props.type]}`;
});

const dotClasses = computed(() => {
  const base = 'mr-1.5 h-1.5 w-1.5 rounded-full';
  const types = {
    success: 'bg-emerald-500',
    warning: 'bg-amber-500',
    error: 'bg-red-500',
    neutral: 'bg-slate-500',
    info: 'bg-blue-500',
  };
  return `${base} ${types[props.type]}`;
});
</script>

<template>
  <span :class="classes">
    <span v-if="dot" :class="dotClasses"></span>
    {{ label }}
  </span>
</template>