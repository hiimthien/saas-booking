<script setup lang="ts">
/**
 * BaseIcon Component
 * 
 * Recommended: Use 'lucide-vue-next' or 'heroicons' for a consistent look.
 * This implementation acts as a wrapper for SVG icons.
 */
interface Props {
  name: string;
  size?: string | number;
  color?: string;
  strokeWidth?: number;
}

const props = withDefaults(defineProps<Props>(), {
  size: 20,
  color: 'currentColor',
  strokeWidth: 2,
});
</script>

<template>
  <span 
    class="inline-flex items-center justify-center shrink-0"
    :style="{ width: `${size}px`, height: `${size}px`, color: color }"
  >
    <!-- Placeholder for Lucide or Heroicon component -->
    <!-- Usage: <LucideIcon :is="name" :size="size" :stroke-width="strokeWidth" /> -->
    <slot>
      <svg
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
        :stroke-width="strokeWidth"
        class="w-full h-full"
      >
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
      </svg>
    </slot>
  </span>
</template>