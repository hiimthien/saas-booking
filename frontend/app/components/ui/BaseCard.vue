<script setup lang="ts">
interface Props {
  padding?: 'none' | 'sm' | 'md' | 'lg';
  hasShadow?: boolean;
  isHoverable?: boolean;
  border?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
  padding: 'md',
  hasShadow: true,
  isHoverable: false,
  border: true,
});

const paddingClasses = {
  none: '',
  sm: 'p-4',
  md: 'p-6',
  lg: 'p-8',
};
</script>

<template>
  <div
    :class="[
      'bg-white rounded-xl transition-all duration-200',
      paddingClasses[padding],
      hasShadow ? 'shadow-sm' : '',
      isHoverable ? 'hover:shadow-md hover:-translate-y-0.5 cursor-pointer' : '',
      border ? 'border border-slate-100' : ''
    ]"
  >
    <div v-if="$slots.header" class="mb-4">
      <slot name="header" />
    </div>
    
    <slot />

    <div v-if="$slots.footer" class="mt-4 pt-4 border-t border-slate-50">
      <slot name="footer" />
    </div>
  </div>
</template>