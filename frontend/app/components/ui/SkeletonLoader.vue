<script setup lang="ts">
interface Props {
  width?: string;
  height?: string;
  rounded?: 'sm' | 'md' | 'lg' | 'xl' | 'full';
}

const props = withDefaults(defineProps<Props>(), {
  width: '100%',
  height: '1rem',
  rounded: 'md',
});

const roundedClasses = {
  sm: 'rounded-sm',
  md: 'rounded-md',
  lg: 'rounded-lg',
  xl: 'rounded-xl',
  full: 'rounded-full',
};
</script>

<template>
  <div 
    class="animate-pulse bg-slate-200" 
    :class="roundedClasses[rounded]"
    :style="{ width, height }"
  />
</template>