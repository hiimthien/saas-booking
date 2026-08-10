<template>
  <div class="p-margin-mobile md:p-lg xl:p-xl flex-1 w-full max-w-7xl mx-auto">
    <!-- Header -->
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-md mb-lg">
      <div>
        <h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface">Client Consultations</h1>
        <p class="font-body-md text-on-surface-variant mt-xs">View and manage your upcoming and past bookings from clients.</p>
      </div>
      <div class="flex items-center gap-sm">
        <UiBaseButton variant="outline" @click="fetchBookings">
          <span class="material-symbols-outlined mr-2" :class="{ 'animate-spin': isFetching }">refresh</span>
          Refresh
        </UiBaseButton>
      </div>
    </header>

    <div v-if="errorMsg" class="mb-lg p-sm bg-error-container text-on-error-container rounded-lg font-body-sm flex items-center gap-sm">
      <span class="material-symbols-outlined">error</span>
      {{ errorMsg }}
    </div>

    <!-- Bookings List -->
    <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl shadow-sm overflow-hidden">
      <div class="p-md">
        <div v-if="isFetching" class="py-2xl flex justify-center">
          <span class="material-symbols-outlined animate-spin text-primary text-[40px]">progress_activity</span>
        </div>
        <div v-else-if="bookings.length === 0" class="py-3xl flex flex-col items-center justify-center text-on-surface-variant">
          <div class="w-20 h-20 rounded-full bg-surface-container flex items-center justify-center mb-md">
             <span class="material-symbols-outlined text-[40px]">event_busy</span>
          </div>
          <p class="font-headline-sm text-on-surface">No bookings found</p>
          <p class="font-body-sm mt-xs">You don't have any client consultations yet.</p>
        </div>
        <div v-else class="space-y-md">
          <SharedBookingList :bookings="bookings" role="provider" />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useAuthStore } from '~/stores/auth'
import SharedBookingList from '~/components/shared/BookingList.vue'

definePageMeta({ layout: 'provider', middleware: ['auth'] })

const authStore = useAuthStore()

const isFetching = ref(false)
const errorMsg = ref('')
const bookings = ref<any[]>([])

const fetchBookings = async () => {
  isFetching.value = true
  errorMsg.value = ''
  try {
    const res: any = await authStore.apiFetch('/bookings')
    bookings.value = res.data
  } catch (e: any) {
    console.error(e)
    errorMsg.value = e.data?.message || 'Failed to fetch bookings.'
  } finally {
    isFetching.value = false
  }
}

onMounted(() => {
  fetchBookings()
})
</script>
