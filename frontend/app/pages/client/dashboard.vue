<template>
  <div>
    <header class="mb-xl flex flex-col md:flex-row md:items-end justify-between gap-md">
      <div>
        <h1 class="font-display-lg text-on-surface mb-xs">My Bookings</h1>
        <p class="font-body-md text-on-surface-variant">Manage your upcoming consultations and review past sessions.</p>
      </div>
      <!-- Tabs -->
      <div class="flex bg-surface-container-low rounded-lg p-xs border border-outline-variant/30">
        <button class="px-md py-sm rounded-md bg-surface text-primary shadow-sm font-label-md transition-all">Upcoming</button>
        <button class="px-md py-sm rounded-md text-on-surface-variant hover:text-on-surface font-label-md transition-all">Past</button>
        <button class="px-md py-sm rounded-md text-on-surface-variant hover:text-on-surface font-label-md transition-all">Canceled</button>
      </div>
    </header>

    <!-- Bookings Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-md md:gap-lg">
      <DomainBookingStatusCard 
        v-for="booking in mockBookings" 
        :key="booking.id"
        :booking="booking"
        @join="handleJoin"
        @reschedule="handleReschedule"
      />
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

definePageMeta({ layout: 'client' })

const mockBookings = ref([
  {
    id: '1',
    consultantName: 'Dr. Marcus Chen',
    consultantAvatar: 'https://ui-avatars.com/api/?name=Marcus+Chen&background=0D8ABC&color=fff',
    consultantTitle: 'Financial Strategy',
    date: 'Oct 24, 2023',
    time: '10:00 AM EST',
    status: 'upcoming',
    type: 'video'
  },
  {
    id: '2',
    consultantName: 'Sarah Jenkins',
    consultantAvatar: 'https://ui-avatars.com/api/?name=Sarah+Jenkins&background=random',
    consultantTitle: 'UX Portfolio Review',
    date: 'Oct 26, 2023',
    time: '2:30 PM EST',
    status: 'cancelled', // Changed to match the available types, or keep it as pending if mapped, but interface only allows upcoming/completed/cancelled
    type: 'video'
  }
])

const handleJoin = (id: string) => {
  console.log('Joining session', id)
}
const handleReschedule = (id: string) => {
  console.log('Rescheduling session', id)
}
</script>
