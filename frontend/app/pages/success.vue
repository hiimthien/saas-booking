<template>
  <div class="min-h-[70vh] flex items-center justify-center bg-background px-4">
    <div class="max-w-md w-full bg-surface-container-lowest border border-outline-variant p-xl rounded-2xl shadow-lg text-center flex flex-col gap-lg items-center">
      
      <div class="w-20 h-20 bg-primary-container text-on-primary-container rounded-full flex items-center justify-center mb-sm">
        <CheckCircle class="w-10 h-10" />
      </div>
      
      <div class="flex flex-col gap-xs">
        <h1 class="font-headline-lg text-on-surface">Payment Successful!</h1>
        <p class="font-body-md text-on-surface-variant">Your consultation has been booked successfully. A confirmation email has been sent with the meeting details.</p>
      </div>

      <div v-if="consultant" class="w-full bg-surface-container border border-outline-variant p-md rounded-xl text-left flex flex-col gap-sm">
        <h3 class="font-label-md text-on-surface-variant uppercase tracking-wider mb-xs">Booking Details</h3>
        <div class="flex items-center gap-md">
          <img :src="consultant.avatar" class="w-12 h-12 rounded object-cover" >
          <div>
            <div class="font-headline-md text-on-surface">{{ selectedService?.name || 'Consultation' }}</div>
            <div class="font-body-sm text-on-surface-variant">with {{ consultant.name }}</div>
          </div>
        </div>
        <div class="grid grid-cols-2 gap-sm mt-xs pt-sm border-t border-outline-variant">
          <div class="flex flex-col">
            <span class="font-label-sm text-on-surface-variant">Date</span>
            <span class="font-label-md text-on-surface">{{ bookingStore.selectedDate || 'Nov 3, 2023' }}</span>
          </div>
          <div class="flex flex-col">
            <span class="font-label-sm text-on-surface-variant">Time</span>
            <span class="font-label-md text-on-surface">{{ bookingStore.selectedTimeSlot || '10:30 AM' }}</span>
          </div>
        </div>
      </div>

      <div class="flex w-full gap-md mt-sm">
        <NuxtLink to="/" class="flex-1">
          <UiButton variant="outline" class="w-full">Back to Home</UiButton>
        </NuxtLink>
        <NuxtLink to="/provider/dashboard" class="flex-1">
          <UiButton variant="primary" class="w-full">View Dashboard</UiButton>
        </NuxtLink>
      </div>

    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { useBookingStore } from '~/stores/booking'
import { useConsultantStore } from '~/stores/consultant'
import { CheckCircle } from 'lucide-vue-next'

definePageMeta({ layout: 'default' })

const bookingStore = useBookingStore()
const consultantStore = useConsultantStore()

const consultant = computed(() => {
  return bookingStore.selectedConsultantId 
    ? consultantStore.getConsultantById(bookingStore.selectedConsultantId) 
    : null
})

const selectedService = computed(() => {
  if (!consultant.value || !bookingStore.selectedServiceId) return null
  return consultant.value.services.find(s => s.id === bookingStore.selectedServiceId)
})
</script>
