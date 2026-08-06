<script setup lang="ts">

interface Booking {
  id: string;
  consultantName: string;
  consultantAvatar: string;
  consultantTitle: string;
  date: string;
  time: string;
  status: 'upcoming' | 'completed' | 'cancelled';
  type: 'video' | 'in-person';
}

interface Props {
  booking: Booking;
}

const props = defineProps<Props>();
const emit = defineEmits<{
  (e: 'join', id: string): void;
  (e: 'reschedule', id: string): void;
}>();

const statusType = {
  upcoming: 'info',
  completed: 'success',
  cancelled: 'error'
} as const;
</script>

<template>
  <UiBaseCard padding="md" class="border-l-4" :class="booking.status === 'upcoming' ? 'border-l-emerald-500' : 'border-l-slate-200'">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
      <div class="flex items-center gap-4">
        <UiUserAvatar :src="booking.consultantAvatar" size="lg" />
        <div>
          <h4 class="text-base font-bold text-slate-900">{{ booking.consultantName }}</h4>
          <p class="text-sm text-slate-500">{{ booking.consultantTitle }}</p>
        </div>
      </div>
      
      <div class="flex flex-wrap items-center gap-3">
        <UiStatusBadge :label="booking.status" :type="statusType[booking.status]" />
        <div class="flex items-center gap-2 text-slate-500">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
          <span class="text-sm font-medium">{{ booking.date }}</span>
        </div>
        <div class="flex items-center gap-2 text-slate-500">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span class="text-sm font-medium">{{ booking.time }}</span>
        </div>
      </div>

      <div class="flex gap-2">
        <UiBaseButton 
          v-if="booking.status === 'upcoming'" 
          size="sm" 
          @click="emit('join', booking.id)"
        >
          Join Session
        </UiBaseButton>
        <UiBaseButton 
          variant="outline" 
          size="sm" 
          @click="emit('reschedule', booking.id)"
        >
          {{ booking.status === 'upcoming' ? 'Reschedule' : 'View Details' }}
        </UiBaseButton>
      </div>
    </div>
  </UiBaseCard>
</template>