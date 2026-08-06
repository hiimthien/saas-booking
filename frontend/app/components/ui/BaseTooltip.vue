<script setup lang="ts">
import { ref } from 'vue';

interface Props {
  content: string;
  position?: 'top' | 'bottom' | 'left' | 'right';
}

const props = withDefaults(defineProps<Props>(), {
  position: 'top',
});

const isVisible = ref(false);

const positionClasses = {
  top: 'bottom-full left-1/2 -translate-x-1/2 mb-2',
  bottom: 'top-full left-1/2 -translate-x-1/2 mt-2',
  left: 'right-full top-1/2 -translate-y-1/2 mr-2',
  right: 'left-full top-1/2 -translate-y-1/2 ml-2',
};

const arrowClasses = {
  top: 'top-full left-1/2 -translate-x-1/2 border-t-slate-900',
  bottom: 'bottom-full left-1/2 -translate-x-1/2 border-b-slate-900',
  left: 'left-full top-1/2 -translate-y-1/2 border-l-slate-900',
  right: 'right-full top-1/2 -translate-y-1/2 border-r-slate-900',
};
</script>

<template>
  <div 
    class="relative inline-block"
    @mouseenter="isVisible = true"
    @mouseleave="isVisible = false"
  >
    <slot />
    
    <Transition
      enter-active-class="transition duration-200 ease-out"
      enter-from-class="opacity-0 scale-95"
      enter-to-class="opacity-100 scale-100"
      leave-active-class="transition duration-150 ease-in"
      leave-from-class="opacity-100 scale-100"
      leave-to-class="opacity-0 scale-95"
    >
      <div
        v-if="isVisible"
        class="absolute z-[60] px-2 py-1 text-[10px] font-bold text-white bg-slate-900 rounded-md whitespace-nowrap pointer-events-none shadow-lg"
        :class="positionClasses[position]"
      >
        {{ content }}
        <div 
          class="absolute border-4 border-transparent"
          :class="arrowClasses[position]"
        ></div>
      </div>
    </Transition>
  </div>
</template>