<script setup lang="ts">
import { ref, computed } from 'vue';

interface Props {
  events?: { date: string; title: string; type: string }[];
}

const props = defineProps<Props>();

const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
const currentDate = ref(new Date());

const currentMonthName = computed(() => {
  return currentDate.value.toLocaleString('default', { month: 'long', year: 'numeric' });
});

const calendarDays = computed(() => {
  const year = currentDate.value.getFullYear();
  const month = currentDate.value.getMonth();
  const firstDay = new Date(year, month, 1).getDay();
  const daysInMonth = new Date(year, month + 1, 0).getDate();
  
  const daysArray = [];
  
  // Padding for previous month
  for (let i = 0; i < firstDay; i++) {
    daysArray.push({ day: '', current: false });
  }
  
  // Current month days
  for (let i = 1; i <= daysInMonth; i++) {
    const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
    const dayEvents = props.events?.filter(e => e.date === dateStr) || [];
    daysArray.push({ day: i, current: true, date: dateStr, events: dayEvents });
  }
  
  return daysArray;
});

const prevMonth = () => {
  currentDate.value = new Date(currentDate.value.getFullYear(), currentDate.value.getMonth() - 1, 1);
};

const nextMonth = () => {
  currentDate.value = new Date(currentDate.value.getFullYear(), currentDate.value.getMonth() + 1, 1);
};
</script>

<template>
  <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-50 flex items-center justify-between">
      <h3 class="text-lg font-bold text-slate-900">{{ currentMonthName }}</h3>
      <div class="flex gap-2">
        <button @click="prevMonth" class="p-2 hover:bg-slate-100 rounded-lg text-slate-500 transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
        </button>
        <button @click="nextMonth" class="p-2 hover:bg-slate-100 rounded-lg text-slate-500 transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </button>
      </div>
    </div>
    
    <div class="grid grid-cols-7 border-b border-slate-50">
      <div v-for="day in days" :key="day" class="py-3 text-center text-[10px] font-bold uppercase tracking-widest text-slate-400 bg-slate-50/50">
        {{ day }}
      </div>
    </div>
    
    <div class="grid grid-cols-7">
      <div 
        v-for="(dateObj, index) in calendarDays" 
        :key="index"
        class="min-h-[100px] border-r border-b border-slate-50 p-2 transition-colors hover:bg-slate-50/30"
        :class="{ 'bg-slate-50/10': !dateObj.current }"
      >
        <div v-if="dateObj.day" class="flex flex-col h-full">
          <span 
            class="text-xs font-bold mb-1 w-6 h-6 flex items-center justify-center rounded-full"
            :class="[
              dateObj.date === new Date().toISOString().split('T')[0] 
                ? 'bg-emerald-600 text-white' 
                : 'text-slate-600'
            ]"
          >
            {{ dateObj.day }}
          </span>
          <div class="flex flex-col gap-1 overflow-y-auto max-h-[60px]">
            <div 
              v-for="event in dateObj.events" 
              :key="event.title"
              class="px-1.5 py-0.5 text-[9px] font-bold rounded truncate border"
              :class="[
                event.type === 'video' ? 'bg-blue-50 text-blue-700 border-blue-100' : 'bg-emerald-50 text-emerald-700 border-emerald-100'
              ]"
            >
              {{ event.title }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>