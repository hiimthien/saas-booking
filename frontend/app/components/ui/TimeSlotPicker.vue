<script setup lang="ts">
interface Props {
  slots: string[];
  selectedSlot?: string;
  loading?: boolean;
}

const props = defineProps<Props>();
const emit = defineEmits<{
  (e: 'select', slot: string): void;
}>();
</script>

<template>
  <div class="grid grid-cols-3 sm:grid-cols-4 gap-2">
    <button
      v-for="slot in slots"
      :key="slot"
      type="button"
      :class="[
        'py-2.5 text-sm font-medium rounded-xl border transition-all duration-200',
        selectedSlot === slot
          ? 'bg-emerald-600 border-emerald-600 text-white shadow-md'
          : 'bg-white border-slate-200 text-slate-700 hover:border-emerald-300 hover:bg-emerald-50'
      ]"
      @click="emit('select', slot)"
    >
      {{ slot }}
    </button>
  </div>
</template>