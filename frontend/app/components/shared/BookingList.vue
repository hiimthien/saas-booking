<template>
  <div class="space-y-md">
    <div v-if="bookings.length === 0" class="py-2xl flex flex-col items-center justify-center text-on-surface-variant">
      <div class="w-16 h-16 rounded-full bg-surface-container flex items-center justify-center mb-md">
         <span class="material-symbols-outlined text-[32px]">event_busy</span>
      </div>
      <p class="font-body-lg">No bookings found</p>
    </div>
    <div v-for="booking in bookings" :key="booking.id" class="p-md border border-outline-variant rounded-xl flex flex-col md:flex-row md:items-center justify-between gap-md hover:bg-surface-container-lowest/50 transition-colors">
      <div class="flex items-center gap-md">
         <img v-if="getAvatar(booking)" :src="getAvatar(booking)" class="w-12 h-12 rounded-full object-cover shadow-sm"/>
         <div v-else class="w-12 h-12 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center font-headline-sm">
           {{ getName(booking).charAt(0) || 'U' }}
         </div>
         <div>
           <h4 class="font-label-lg">{{ getName(booking) }}</h4>
           <p v-if="getSubtext(booking)" class="font-body-sm text-on-surface-variant">{{ getSubtext(booking) }}</p>
         </div>
      </div>
        <div class="flex flex-col md:items-end gap-xs">
          <div class="flex items-center gap-xs font-label-md bg-surface-container px-sm py-xs rounded-md">
            <span class="material-symbols-outlined text-[16px]">calendar_today</span>
            {{ new Date(booking.start_time).toLocaleString() }}
          </div>
          <span class="font-body-sm font-semibold" :class="getStatusClass(booking.status)">
            {{ booking.status.toUpperCase() }}
          </span>
          <div class="flex items-center gap-xs mt-xs">
            <a 
              v-if="booking.meeting_link && ['confirmed', 'pending'].includes(booking.status)" 
              :href="`/room/${booking.id}`" 
              class="inline-flex items-center gap-xs px-sm py-xs bg-primary text-on-primary rounded font-label-sm hover:bg-primary/90 transition-colors shadow-sm"
            >
              <span class="material-symbols-outlined text-[16px]">videocam</span>
              Join Room
            </a>
            <button
              v-if="role === 'client' && booking.status === 'completed'"
              @click="openReview(booking)"
              class="inline-flex items-center gap-xs px-sm py-xs bg-amber-500/10 text-amber-600 border border-amber-500/20 rounded font-label-sm hover:bg-amber-500/20 transition-colors"
            >
              <span class="material-symbols-outlined text-[16px]" style="font-variation-settings: 'FILL' 1;">star</span>
              Rate & Review
            </button>
          </div>
        </div>
    </div>

    <!-- Review Modal -->
    <SharedReviewModal
      v-if="selectedBooking"
      :is-open="isReviewOpen"
      :booking-id="selectedBooking.id"
      :consultant-name="getName(selectedBooking)"
      @close="isReviewOpen = false"
      @reviewed="handleReviewed"
    />
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useRuntimeConfig } from '#app'
import SharedReviewModal from '~/components/shared/ReviewModal.vue'

const isReviewOpen = ref(false)
const selectedBooking = ref<any>(null)

const openReview = (booking: any) => {
  selectedBooking.value = booking
  isReviewOpen.value = true
}

const emit = defineEmits(['bookingUpdated'])

const handleReviewed = () => {
  emit('bookingUpdated')
}

const config = useRuntimeConfig()
const backendUrl = (path: string | undefined) => {
  if (!path) return ''
  if (path.startsWith('http')) return path
  const base = (config.public.apiBase as string).replace('/api', '')
  return `${base}${path}`
}

const props = defineProps({
  bookings: {
    type: Array as PropType<any[]>,
    default: () => []
  },
  role: {
    type: String as PropType<'client' | 'provider'>,
    required: true
  }
})

const getAvatar = (booking: any) => {
  if (props.role === 'client') {
    return booking.consultantProfile?.user?.avatar_url ? backendUrl(booking.consultantProfile.user.avatar_url) : null
  }
  return booking.customer?.avatar_url ? backendUrl(booking.customer.avatar_url) : null
}

const getName = (booking: any) => {
  if (props.role === 'client') {
    return booking.consultantProfile?.user?.name || 'Consultant'
  }
  return booking.customer?.name || 'Client'
}

const getSubtext = (booking: any) => {
  if (props.role === 'client') {
    return booking.consultantProfile?.title || ''
  }
  return `Duration: ${booking.duration_minutes} mins`
}

const getStatusClass = (status: string) => {
  switch (status) {
    case 'confirmed': return 'text-primary'
    case 'pending': return 'text-amber-500'
    case 'cancelled': return 'text-error'
    default: return 'text-on-surface-variant'
  }
}
</script>
