<script setup lang="ts">
import { computed } from 'vue';

interface Props {
  src?: string;
  alt?: string;
  size?: 'xs' | 'sm' | 'md' | 'lg' | 'xl';
  status?: 'online' | 'offline' | 'busy';
  placeholder?: string;
}

const props = withDefaults(defineProps<Props>(), {
  size: 'md',
  alt: 'User avatar',
});

const emit = defineEmits<{
  (e: 'click'): void;
}>();

const sizeClasses = computed(() => {
  const sizes = {
    xs: 'h-6 w-6 text-[10px]',
    sm: 'h-8 w-8 text-xs',
    md: 'h-10 w-10 text-sm',
    lg: 'h-12 w-12 text-base',
    xl: 'h-16 w-16 text-xl',
  };
  return sizes[props.size];
});

const statusClasses = computed(() => {
  const base = 'absolute bottom-0 right-0 block rounded-full ring-2 ring-white';
  const sizes = {
    xs: 'h-1.5 w-1.5',
    sm: 'h-2 w-2',
    md: 'h-2.5 w-2.5',
    lg: 'h-3 w-3',
    xl: 'h-4 w-4',
  };
  const colors = {
    online: 'bg-emerald-500',
    offline: 'bg-slate-300',
    busy: 'bg-red-500',
  };
  return `${base} ${sizes[props.size]} ${colors[props.status!]}`;
});
</script>

<template>
  <div class="relative inline-block" @click="emit('click')">
    <div 
      :class="[
        'flex items-center justify-center bg-slate-100 text-slate-500 font-semibold overflow-hidden rounded-full ring-2 ring-white',
        sizeClasses
      ]"
    >
      <img 
        v-if="src" 
        :src="src" 
        :alt="alt" 
        class="h-full w-full object-cover"
      />
      <span v-else>{{ placeholder || '?' }}</span>
    </div>
    <span v-if="status" :class="statusClasses"></span>
  </div>
</template>