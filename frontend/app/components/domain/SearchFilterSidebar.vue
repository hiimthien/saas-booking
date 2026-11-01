<template>
  <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-md shadow-sm">
    <div class="flex justify-between items-center mb-md border-b border-outline-variant pb-sm">
      <h2 class="font-headline-md text-on-surface">Filters</h2>
      <UiBaseButton variant="ghost" size="sm" @click="emit('clear')">Clear all</UiBaseButton>
    </div>

    <!-- Price Range Filter -->
    <div class="mb-lg border-b border-outline-variant pb-md">
      <h3 class="font-label-md text-on-surface mb-sm">Hourly Rate</h3>
      <div class="flex items-center gap-sm mt-4">
        <div class="flex-1 relative">
          <span class="absolute left-2 top-[38%] -translate-y-1/2 text-on-surface-variant text-body-sm z-10">$</span>
          <UiBaseInput :model-value="minRate" @update:model-value="val => emit('update:minRate', val)" type="number" placeholder="Min" class="pl-6" />
        </div>
        <span class="text-on-surface-variant">-</span>
        <div class="flex-1 relative">
          <span class="absolute left-2 top-[38%] -translate-y-1/2 text-on-surface-variant text-body-sm z-10">$</span>
          <UiBaseInput :model-value="maxRate" @update:model-value="val => emit('update:maxRate', val)" type="number" placeholder="Max" class="pl-6" />
        </div>
      </div>
    </div>

    <!-- Rating Filter -->
    <div class="mb-md">
      <h3 class="font-label-md text-on-surface mb-sm">Minimum Rating</h3>
      <div class="space-y-2">
        <label class="flex items-center justify-between cursor-pointer group">
          <div class="flex items-center gap-sm">
            <input 
              type="radio" 
              :checked="minRating === 5.0" 
              @change="emit('update:minRating', 5.0)" 
              name="rating" 
              class="border-outline-variant text-primary focus:ring-primary w-4 h-4 cursor-pointer"
            >
            <div class="flex text-amber-500">
              <span v-for="n in 5" :key="n" class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
            </div>
          </div>
          <span class="font-body-sm text-on-surface-variant">5.0</span>
        </label>
        
        <label class="flex items-center justify-between cursor-pointer group">
          <div class="flex items-center gap-sm">
            <input 
              type="radio" 
              :checked="minRating === 4.0" 
              @change="emit('update:minRating', 4.0)" 
              name="rating" 
              class="border-outline-variant text-primary focus:ring-primary w-4 h-4 cursor-pointer"
            >
            <div class="flex text-amber-500">
              <span v-for="n in 4" :key="n" class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
              <span class="material-symbols-outlined text-sm text-outline-variant">star_border</span>
            </div>
          </div>
          <span class="font-body-sm text-on-surface-variant">4.0 & Up</span>
        </label>

        <label class="flex items-center justify-between cursor-pointer group">
          <div class="flex items-center gap-sm">
            <input 
              type="radio" 
              :checked="!minRating" 
              @change="emit('update:minRating', '')" 
              name="rating" 
              class="border-outline-variant text-primary focus:ring-primary w-4 h-4 cursor-pointer"
            >
            <span class="font-body-sm text-on-surface-variant">Any Rating</span>
          </div>
        </label>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
defineProps({
  minRate: {
    type: [String, Number],
    default: ''
  },
  maxRate: {
    type: [String, Number],
    default: ''
  },
  minRating: {
    type: [String, Number],
    default: ''
  }
})

const emit = defineEmits(['update:minRate', 'update:maxRate', 'update:minRating', 'clear'])
</script>

