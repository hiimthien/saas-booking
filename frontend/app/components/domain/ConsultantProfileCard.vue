<script setup lang="ts">

interface Consultant {
  id: string;
  name: string;
  title: string;
  avatar: string;
  rating: number;
  reviews: number;
  price: number;
  tags: string[];
}

interface Props {
  consultant: Consultant;
}

const props = defineProps<Props>();
const emit = defineEmits<{
  (e: 'book', id: string): void;
}>();
</script>

<template>
  <UiBaseCard isHoverable padding="sm" class="flex flex-col h-full">
    <div class="flex items-start justify-between mb-4">
      <UiUserAvatar :src="consultant.avatar" size="lg" status="online" />
      <div class="flex items-center bg-emerald-50 text-emerald-700 px-2 py-1 rounded-lg text-xs font-bold">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" viewBox="0 0 20 20" fill="currentColor">
          <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
        </svg>
        {{ consultant.rating }}
      </div>
    </div>
    
    <div class="mb-4 flex-grow">
      <h3 class="text-base font-bold text-slate-900 leading-tight">{{ consultant.name }}</h3>
      <p class="text-sm text-slate-500 mb-2">{{ consultant.title }}</p>
      <div class="flex flex-wrap gap-1">
        <span v-for="tag in consultant.tags" :key="tag" class="text-[10px] uppercase tracking-wider font-bold text-slate-400 bg-slate-100 px-1.5 py-0.5 rounded">
          {{ tag }}
        </span>
      </div>
    </div>

    <div class="flex items-center justify-between pt-4 border-t border-slate-50 mt-auto">
      <div>
        <span class="text-lg font-bold text-slate-900">${{ consultant.price }}</span>
        <span class="text-xs text-slate-500 ml-1">/hr</span>
      </div>
      <UiBaseButton size="sm" @click="emit('book', consultant.id)">
        View Profile
      </UiBaseButton>
    </div>
  </UiBaseCard>
</template>