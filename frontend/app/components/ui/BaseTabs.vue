<script setup lang="ts">
interface Tab {
  id: string;
  label: string;
  icon?: string;
}

interface Props {
  tabs: Tab[];
  activeTab: string;
}

const props = defineProps<Props>();
const emit = defineEmits<{
  (e: 'update:activeTab', id: string): void;
}>();
</script>

<template>
  <div class="border-b border-slate-200">
    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
      <button
        v-for="tab in tabs"
        :key="tab.id"
        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-all duration-200"
        :class="[
          activeTab === tab.id
            ? 'border-emerald-500 text-emerald-600'
            : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'
        ]"
        @click="emit('update:activeTab', tab.id)"
      >
        <div class="flex items-center gap-2">
          <!-- Icon slot or logic here -->
          {{ tab.label }}
        </div>
      </button>
    </nav>
  </div>
</template>