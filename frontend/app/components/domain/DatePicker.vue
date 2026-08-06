<script setup lang="ts">
import { ref } from 'vue';

interface Props {
  modelValue: string;
}

const props = defineProps<Props>();
const emit = defineEmits<{
  (e: 'update:modelValue', value: string): void;
}>();

// Minimalist inline date selector logic
const months = [
  'January', 'February', 'March', 'April', 'May', 'June',
  'July', 'August', 'September', 'October', 'November', 'December'
];

const selectedMonth = ref(new Date().getMonth());
const selectedYear = ref(new Date().getFullYear());

const daysInMonth = (month: number, year: number) => new Date(year, month + 1, 0).getDate();
const startDayOfMonth = (month: number, year: number) => new Date(year, month, 1).getDay();

const isSelected = (day: number) => {
  const d = new Date(selectedYear.value, selectedMonth.value, day).toISOString().split('T')[0];
  return props.modelValue === d;
};

const selectDate = (day: number) => {
  const d = new Date(selectedYear.value, selectedMonth.value, day).toISOString().split('T')[0];
  emit('update:modelValue', d);
};
</script>

<template>
  <div class="p-4 bg-white rounded-2xl border border-slate-100 shadow-sm w-full max-w-[320px]">
    <div class="flex items-center justify-between mb-4">
      <h4 class="text-sm font-bold text-slate-900">{{ months[selectedMonth] }} {{ selectedYear }}</h4>
      <div class="flex gap-1">
        <button @click="selectedMonth--" class="p-1.5 hover:bg-slate-100 rounded-lg text-slate-500">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
        </button>
        <button @click="selectedMonth++" class="p-1.5 hover:bg-slate-100 rounded-lg text-slate-500">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </button>
      </div>
    </div>
    
    <div class="grid grid-cols-7 gap-1 mb-2">
      <div v-for="d in ['S','M','T','W','T','F','S']" :key="d" class="text-center text-[10px] font-bold text-slate-400">
        {{ d }}
      </div>
    </div>
    
    <div class="grid grid-cols-7 gap-1">
      <div v-for="p in startDayOfMonth(selectedMonth, selectedYear)" :key="`p-${p}`" class="h-8"></div>
      <button
        v-for="day in daysInMonth(selectedMonth, selectedYear)"
        :key="day"
        @click="selectDate(day)"
        class="h-8 w-8 text-xs font-medium rounded-lg transition-all flex items-center justify-center"
        :class="[
          isSelected(day)
            ? 'bg-emerald-600 text-white shadow-md'
            : 'text-slate-600 hover:bg-emerald-50 hover:text-emerald-700'
        ]"
      >
        {{ day }}
      </button>
    </div>
  </div>
</template>