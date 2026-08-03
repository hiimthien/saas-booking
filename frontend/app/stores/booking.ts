import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useBookingStore = defineStore('booking', () => {
  const selectedConsultantId = ref<string | null>(null)
  const selectedServiceId = ref<string | null>(null)
  const selectedDate = ref<string | null>(null)
  const selectedTimeSlot = ref<string | null>(null)

  const availableDates = ref([
    '2023-11-03', '2023-11-04', '2023-11-05', '2023-11-06'
  ])

  const availableSlots = ref([
    { time: '09:00 AM', available: false },
    { time: '10:30 AM', available: true },
    { time: '01:00 PM', available: true },
    { time: '03:30 PM', available: true }
  ])

  function setBookingDetails(consultantId: string, serviceId: string, date: string, time: string) {
    selectedConsultantId.value = consultantId
    selectedServiceId.value = serviceId
    selectedDate.value = date
    selectedTimeSlot.value = time
  }

  function clearBooking() {
    selectedConsultantId.value = null
    selectedServiceId.value = null
    selectedDate.value = null
    selectedTimeSlot.value = null
  }

  return {
    selectedConsultantId,
    selectedServiceId,
    selectedDate,
    selectedTimeSlot,
    availableDates,
    availableSlots,
    setBookingDetails,
    clearBooking
  }
})
