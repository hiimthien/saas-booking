<template>
  <div class="bg-background text-on-background font-body-md min-h-screen flex flex-col">
    <main class="flex-grow w-full max-w-container-max mx-auto px-margin-mobile md:px-gutter py-lg md:py-xl grid grid-cols-1 lg:grid-cols-12 gap-lg relative">
      
      <!-- Main Content -->
      <div v-if="consultant" class="lg:col-span-8 flex flex-col gap-xl">
        
        <!-- Consultant Profile Bento -->
        <section class="bg-surface-container-lowest border border-outline-variant rounded-xl p-lg shadow-sm flex flex-col md:flex-row gap-lg items-start">
          <img :src="consultant.avatar" :alt="consultant.name" class="w-32 h-32 md:w-48 md:h-48 rounded-xl object-cover border-4 border-surface-container" >
          <div class="flex flex-col gap-sm flex-grow">
            <div class="flex justify-between items-start w-full">
              <div>
                <h1 class="font-headline-lg text-on-surface">{{ consultant.name }}</h1>
                <p class="font-body-lg text-on-surface-variant">{{ consultant.title }}</p>
              </div>
              <div class="flex gap-xs">
                <span class="bg-secondary-container text-on-secondary-container px-sm py-xs rounded font-label-sm flex items-center gap-xs">
                  <Verified class="w-4 h-4" /> Top Rated
                </span>
              </div>
            </div>
            <div class="mt-md text-on-surface font-body-md flex flex-col gap-sm">
              <p>{{ consultant.bio }}</p>
              <div class="flex flex-wrap gap-xs mt-sm">
                <UiBadge v-for="skill in consultant.skills" :key="skill" variant="surface">{{ skill }}</UiBadge>
              </div>
            </div>
          </div>
        </section>

        <!-- Service Offerings -->
        <section class="flex flex-col gap-md">
          <h2 class="font-headline-md text-on-surface">Service Offerings</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
            <div 
              v-for="service in consultant.services" :key="service.id"
              :class="[
                'bg-surface-container-lowest border rounded-lg p-md transition-colors cursor-pointer flex flex-col gap-sm',
                bookingStore.selectedServiceId === service.id ? 'border-primary ring-1 ring-primary' : 'border-outline-variant hover:border-primary'
              ]"
              @click="bookingStore.setBookingDetails(consultant.id, service.id, bookingStore.selectedDate || '2023-11-03', bookingStore.selectedTimeSlot || '')"
            >
              <div class="flex items-center justify-between">
                <Compass class="w-6 h-6 text-primary" />
                <span class="font-label-sm text-on-surface-variant">{{ service.durationMin }} mins</span>
              </div>
              <h3 class="font-label-md text-on-surface">{{ service.name }}</h3>
              <p class="font-body-sm text-on-surface-variant line-clamp-2">{{ service.description }}</p>
              <span class="font-label-md text-primary mt-auto">${{ service.price }}</span>
            </div>
          </div>
        </section>
      </div>

      <!-- Sticky Sidebar -->
      <aside v-if="consultant" class="lg:col-span-4 relative">
        <div class="sticky top-[100px] bg-surface-container-lowest border border-outline-variant rounded-xl p-lg shadow-sm flex flex-col gap-lg">
          
          <div class="flex justify-between items-end border-b border-outline-variant pb-md">
            <div class="flex flex-col">
              <span class="font-label-sm text-on-surface-variant uppercase tracking-wider">Consultation Rate</span>
              <span class="font-headline-lg text-on-surface">
                ${{ selectedServicePrice }}<span class="font-body-md text-on-surface-variant">/session</span>
              </span>
            </div>
          </div>

          <div class="flex flex-col gap-sm">
            <span class="font-label-md text-on-surface">Select Date & Time</span>
            <div class="grid grid-cols-2 gap-sm">
              <button 
                v-for="slot in bookingStore.availableSlots" :key="slot.time"
                :disabled="!slot.available"
                :class="[
                  'border rounded py-sm font-label-sm transition-colors',
                  !slot.available ? 'border-outline-variant/30 bg-surface-container text-on-surface-variant/50 cursor-not-allowed' : 
                  bookingStore.selectedTimeSlot === slot.time ? 'border-primary bg-primary text-on-primary' : 'border-outline-variant text-on-surface hover:border-primary'
                ]"
                @click="slot.available && bookingStore.setBookingDetails(consultant.id, bookingStore.selectedServiceId || consultant.services[0].id, '2023-11-03', slot.time)"
              >
                {{ slot.time }}
              </button>
            </div>
          </div>

          <div class="flex flex-col gap-md pt-sm">
            <UiButton 
              :disabled="!bookingStore.selectedTimeSlot || !bookingStore.selectedServiceId"
              class="w-full"
              @click="handleProceed"
            >
              Proceed to Payment
            </UiButton>
            <div class="flex justify-center gap-lg text-on-surface-variant font-label-sm">
              <span class="flex items-center gap-xs"><Lock class="w-4 h-4" /> Secure Payment</span>
            </div>
          </div>

        </div>
      </aside>
      
      <div v-if="!consultant" class="lg:col-span-12 py-2xl text-center text-on-surface-variant font-body-lg">
        Consultant not found.
      </div>
    </main>
  </div>
</template>

<script setup lang="ts">
import { computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useConsultantStore } from '~/stores/consultant'
import { useBookingStore } from '~/stores/booking'
import { Verified, Compass, Lock } from 'lucide-vue-next'

definePageMeta({ layout: 'default' })

const route = useRoute()
const router = useRouter()
const consultantStore = useConsultantStore()
const bookingStore = useBookingStore()

const consultantId = route.params.id as string
const consultant = computed(() => consultantStore.getConsultantById(consultantId))

const selectedServicePrice = computed(() => {
  if (!consultant.value) return 0
  if (!bookingStore.selectedServiceId) return consultant.value.services[0]?.price || consultant.value.hourlyRate
  const service = consultant.value.services.find(s => s.id === bookingStore.selectedServiceId)
  return service ? service.price : consultant.value.hourlyRate
})

onMounted(() => {
  if (consultant.value && consultant.value.services.length > 0 && !bookingStore.selectedServiceId) {
    bookingStore.setBookingDetails(consultant.value.id, consultant.value.services[0].id, '2023-11-03', '')
  }
})

const handleProceed = () => {
  if (bookingStore.selectedTimeSlot && bookingStore.selectedServiceId) {
    router.push('/checkout')
  }
}
</script>
