<script setup lang="ts">
import { computed } from 'vue';

interface Step {
  id: number;
  title: string;
  description?: string;
}

interface Props {
  steps: Step[];
  currentStep: number;
}

const props = defineProps<Props>();

const progressPercentage = computed(() => {
  return ((props.currentStep - 1) / (props.steps.length - 1)) * 100;
});
</script>

<template>
  <div class="w-full">
    <!-- Progress Bar (Background) -->
    <div class="relative flex items-center justify-between mb-8">
      <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-0.5 bg-slate-100 z-0"></div>
      
      <!-- Progress Bar (Active) -->
      <div 
        class="absolute left-0 top-1/2 -translate-y-1/2 h-0.5 bg-emerald-500 transition-all duration-500 ease-in-out z-0"
        :style="{ width: `${progressPercentage}%` }"
      ></div>

      <div 
        v-for="step in steps" 
        :key="step.id"
        class="relative z-10 flex flex-col items-center"
      >
        <div 
          class="w-10 h-10 rounded-full flex items-center justify-center border-2 transition-all duration-300"
          :class="[
            currentStep >= step.id 
              ? 'bg-emerald-600 border-emerald-600 text-white shadow-lg shadow-emerald-100' 
              : 'bg-white border-slate-200 text-slate-400'
          ]"
        >
          <svg v-if="currentStep > step.id" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
          <span v-else class="text-sm font-bold">{{ step.id }}</span>
        </div>
        <div class="absolute top-12 whitespace-nowrap text-center">
          <p 
            class="text-xs font-bold transition-colors duration-300"
            :class="currentStep >= step.id ? 'text-slate-900' : 'text-slate-400'"
          >
            {{ step.title }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>