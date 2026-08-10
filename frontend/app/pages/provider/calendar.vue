<template>
  <div class="p-margin-mobile md:p-lg xl:p-xl flex-1 w-full max-w-7xl mx-auto flex flex-col gap-lg">
    <!-- Header -->
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-md">
      <div>
        <h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface">Calendar & Availability</h1>
        <p class="font-body-sm text-on-surface-variant mt-xs">Manage your working hours and view upcoming consultations.</p>
      </div>
      <div class="flex items-center gap-sm">
        <UiBaseButton variant="outline" @click="fetchData">
          <span class="material-symbols-outlined mr-2" :class="{ 'animate-spin': isFetching }">refresh</span>
          Refresh
        </UiBaseButton>
        <UiBaseButton variant="primary" @click="showAvailabilityModal = true">
          <span class="material-symbols-outlined mr-2">edit_calendar</span>
          Edit Weekly Hours
        </UiBaseButton>
      </div>
    </header>

    <div v-if="successMsg" class="p-sm bg-primary-container text-on-primary-container rounded-lg font-body-sm flex items-center gap-sm">
      <span class="material-symbols-outlined">check_circle</span>
      {{ successMsg }}
    </div>
    <div v-if="errorMsg" class="p-sm bg-error-container text-on-error-container rounded-lg font-body-sm flex items-center gap-sm">
      <span class="material-symbols-outlined">error</span>
      {{ errorMsg }}
    </div>

    <!-- Calendar View -->
    <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl shadow-sm overflow-hidden flex flex-col">
      <div class="p-md border-b border-outline-variant bg-surface-container/30 flex justify-between items-center">
        <h2 class="font-headline-md">Upcoming Consultations (List View)</h2>
      </div>
      <div class="p-md">
        <div v-if="isFetching" class="py-xl flex justify-center">
          <span class="material-symbols-outlined animate-spin text-primary text-[32px]">progress_activity</span>
        </div>
        <div v-else-if="bookings.length === 0" class="py-2xl flex flex-col items-center justify-center text-on-surface-variant">
          <div class="w-16 h-16 rounded-full bg-surface-container flex items-center justify-center mb-md">
             <span class="material-symbols-outlined text-[32px]">event_busy</span>
          </div>
          <p class="font-body-lg">No bookings found</p>
          <p class="font-body-sm mt-xs">You don't have any consultations scheduled yet.</p>
        </div>
        <div v-else class="space-y-md">
          <SharedBookingList :bookings="bookings" role="provider" />
        </div>
      </div>
    </div>

    <!-- Availability Modal (Custom inline form for now) -->
    <div v-if="showAvailabilityModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
      <div class="bg-surface-container-lowest rounded-2xl max-w-2xl w-full max-h-[90vh] flex flex-col shadow-xl">
        <div class="p-lg border-b border-outline-variant flex justify-between items-center">
          <h2 class="font-headline-md">Edit Weekly Hours</h2>
          <button @click="showAvailabilityModal = false" class="p-sm hover:bg-surface-variant rounded-full text-on-surface-variant">
            <span class="material-symbols-outlined">close</span>
          </button>
        </div>
        <div class="p-lg overflow-y-auto flex-1">
          <form @submit.prevent="saveAvailabilities" class="space-y-md">
            <div v-for="(day, index) in workingHours" :key="day.day_of_week" class="flex flex-col md:flex-row md:items-center justify-between p-md border border-outline-variant rounded-xl hover:bg-surface-container-low transition-colors">
              <div class="flex items-center gap-md w-1/3 mb-sm md:mb-0">
                <label class="relative inline-flex items-center cursor-pointer">
                  <input type="checkbox" v-model="day.is_closed" class="sr-only peer" :true-value="false" :false-value="true">
                  <div class="w-11 h-6 bg-surface-variant peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                </label>
                <span class="font-label-md" :class="day.is_closed ? 'text-on-surface-variant' : 'text-on-surface'">
                  {{ daysOfWeek[day.day_of_week] }}
                </span>
              </div>

              <div v-if="!day.is_closed" class="flex items-center gap-sm flex-1 justify-end">
                <input v-model="day.start_time" type="time" class="w-32 px-sm py-xs rounded-lg border border-outline-variant bg-surface-container-lowest outline-none focus:border-primary text-on-surface">
                <span class="text-on-surface-variant font-label-sm">to</span>
                <input v-model="day.end_time" type="time" class="w-32 px-sm py-xs rounded-lg border border-outline-variant bg-surface-container-lowest outline-none focus:border-primary text-on-surface">
              </div>
              <div v-else class="flex-1 text-right text-on-surface-variant italic font-body-sm">
                Closed
              </div>
            </div>
          </form>
        </div>
        <div class="p-lg border-t border-outline-variant flex justify-end gap-md">
          <UiBaseButton variant="outline" @click="showAvailabilityModal = false">Cancel</UiBaseButton>
          <UiBaseButton variant="primary" @click="saveAvailabilities" :disabled="isSaving">
            <span v-if="isSaving" class="material-symbols-outlined animate-spin mr-2">progress_activity</span>
            Save Schedule
          </UiBaseButton>
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
const isSaving = ref(false)
const successMsg = ref('')
const errorMsg = ref('')
const showAvailabilityModal = ref(false)

const bookings = ref<any[]>([])
const workingHours = ref<any[]>([])
const daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']

const fetchData = async () => {
  isFetching.value = true
  errorMsg.value = ''
  try {
    const availRes: any = await authStore.apiFetch('/provider/availabilities')
    workingHours.value = availRes.data.map((h: any) => ({
      ...h,
      start_time: h.start_time ? h.start_time.substring(0,5) : null,
      end_time: h.end_time ? h.end_time.substring(0,5) : null
    }))

    const bookRes: any = await authStore.apiFetch('/bookings')
    bookings.value = bookRes.data
  } catch (e: any) {
    console.error(e)
    errorMsg.value = e.data?.message || 'Failed to load calendar data.'
  } finally {
    isFetching.value = false
  }
}

const saveAvailabilities = async () => {
  isSaving.value = true
  successMsg.value = ''
  errorMsg.value = ''
  try {
    const formattedHours = workingHours.value.map(h => ({
      ...h,
      start_time: h.start_time ? h.start_time.substring(0,5) : null,
      end_time: h.end_time ? h.end_time.substring(0,5) : null
    }))
    await authStore.apiFetch('/provider/availabilities', { method: 'POST', body: { working_hours: formattedHours } })
    successMsg.value = 'Working hours updated successfully!'
    showAvailabilityModal.value = false
    setTimeout(() => successMsg.value = '', 4000)
  } catch (e: any) {
    console.error(e)
    errorMsg.value = e.data?.message || 'Failed to update working hours.'
  } finally {
    isSaving.value = false
  }
}

onMounted(() => {
  fetchData()
})
</script>
