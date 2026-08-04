<template>
  <div v-if="pending" class="flex justify-center items-center py-24 text-on-surface-variant">
    Loading profile...
  </div>
  <div v-else-if="!consultant" class="flex justify-center items-center py-24 text-error">
    Consultant not found
  </div>
  <div v-else class="w-full max-w-container-max mx-auto px-margin-mobile md:px-gutter py-lg md:py-xl grid grid-cols-1 lg:grid-cols-12 gap-lg relative">
    <!-- Main Content -->
    <div class="lg:col-span-8 flex flex-col gap-xl">
      <!-- Consultant Profile Bento -->
      <section class="bg-surface-container-lowest border border-outline-variant rounded-xl p-lg shadow-sm flex flex-col md:flex-row gap-lg items-start">
        <img :src="consultant.user.avatar_url || `https://ui-avatars.com/api/?name=${consultant.user.name}&background=random`" :alt="consultant.user.name" class="w-32 h-32 md:w-48 md:h-48 rounded-xl object-cover border-4 border-surface-container" >
        
        <div class="flex flex-col gap-sm flex-grow">
          <div class="flex justify-between items-start w-full">
            <div>
              <h1 class="font-headline-lg text-on-surface">{{ consultant.user.name }}</h1>
              <p class="font-body-lg text-on-surface-variant">{{ consultant.title }}</p>
            </div>
            <div class="flex gap-xs">
              <span class="bg-secondary-container text-on-secondary-container px-sm py-xs rounded font-label-sm flex items-center gap-xs">
                <span class="material-symbols-outlined text-[16px]" style="font-variation-settings: 'FILL' 1;">verified</span> Top Rated
              </span>
            </div>
          </div>
          
          <div class="mt-md text-on-surface font-body-md flex flex-col gap-sm">
            <p>{{ consultant.bio }}</p>
            <div class="flex items-center gap-sm text-on-surface-variant font-body-sm mt-sm">
              <span class="flex items-center gap-xs"><span class="material-symbols-outlined text-[18px]">location_on</span> Remote</span>
            </div>
          </div>
        </div>
      </section>

      <!-- Tags -->
      <section class="flex flex-col gap-md">
        <h2 class="font-headline-md text-on-surface">Expertise</h2>
        <div class="flex flex-wrap gap-xs">
          <NuxtLink v-if="selectedDate && selectedTime" :to="`/checkout?consultant=${consultant?.slug}&date=${selectedDate}&time=${selectedTime}`" class="block w-full py-3 px-4 bg-primary text-on-primary text-center font-label-lg rounded-xl hover:bg-surface-tint hover:shadow-md transition-all">
            Proceed to Payment
          </NuxtLink>
        </div>
      </section>

      <!-- Reviews -->
      <section class="flex flex-col gap-lg border-t border-outline-variant pt-lg">
        <div class="flex items-center justify-between">
          <h2 class="font-headline-md text-on-surface">Customer Reviews</h2>
          <div class="flex items-center gap-sm">
            <span class="font-headline-md text-on-surface">{{ Number(consultant.rating).toFixed(1) }}</span>
            <div class="flex text-amber-500">
              <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
            </div>
            <span class="font-body-sm text-on-surface-variant">({{ consultant.reviews_count }} reviews)</span>
          </div>
        </div>
      </section>
    </div>

    <!-- Sticky Sidebar -->
    <aside class="lg:col-span-4 relative">
      <div class="sticky top-[100px] bg-surface-container-lowest border border-outline-variant rounded-xl p-lg shadow-sm flex flex-col gap-lg">
        <!-- Pricing Header -->
        <div class="flex justify-between items-end border-b border-outline-variant pb-md">
          <div class="flex flex-col">
            <span class="font-label-sm text-on-surface-variant uppercase tracking-wider">Consultation Rate</span>
            <span class="font-headline-lg text-on-surface">${{ consultant.hourly_rate }}<span class="font-body-md text-on-surface-variant">/hr</span></span>
          </div>
        </div>

        <!-- Calendar Picker Mockup -->
        <div class="flex flex-col gap-sm">
          <div class="flex justify-between items-center">
            <button class="p-xs hover:bg-surface-variant rounded transition-colors"><span class="material-symbols-outlined">chevron_left</span></button>
            <span class="font-label-md text-on-surface">October 2026</span>
            <button class="p-xs hover:bg-surface-variant rounded transition-colors"><span class="material-symbols-outlined">chevron_right</span></button>
          </div>
          <div class="grid grid-cols-7 gap-xs text-center font-label-sm text-on-surface-variant mb-xs">
            <span>Su</span><span>Mo</span><span>Tu</span><span>We</span><span>Th</span><span>Fr</span><span>Sa</span>
          </div>
          <div class="grid grid-cols-7 gap-xs text-center font-body-sm">
            <span class="py-sm hover:bg-surface-variant rounded cursor-pointer text-on-surface-variant">10</span>
            <span class="py-sm hover:bg-surface-variant rounded cursor-pointer text-on-surface-variant">11</span>
            <span class="py-sm bg-primary text-on-primary rounded font-bold cursor-pointer shadow-sm">12</span>
            <span class="py-sm hover:bg-surface-variant rounded cursor-pointer text-on-surface-variant">13</span>
            <span class="py-sm hover:bg-surface-variant rounded cursor-pointer text-on-surface-variant">14</span>
          </div>
        </div>

        <!-- Time Slots -->
        <div class="flex flex-col gap-sm pt-sm border-t border-outline-variant">
          <span class="font-label-md text-on-surface">Available Times</span>
          <div class="grid grid-cols-2 gap-sm">
            <button 
              v-for="time in availableTimes" 
              :key="time"
              @click="selectedTime = time"
              :class="['border rounded py-sm font-label-sm transition-colors', selectedTime === time ? 'border-primary bg-primary-container/10 text-primary' : 'border-outline-variant text-on-surface hover:border-primary hover:text-primary']"
            >
              {{ time }}
            </button>
          </div>
        </div>

        <!-- CTA & Badges -->
        <div class="flex flex-col gap-md pt-sm">
          <button 
            :disabled="!selectedTime"
            class="w-full bg-primary text-on-primary font-label-md py-md rounded-lg hover:bg-primary-container hover:text-on-primary-container transition-colors shadow-sm focus:ring-2 focus:ring-secondary focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed" 
            @click="proceedToPayment"
          >
            Proceed to Payment
          </button>
          <div class="flex justify-center gap-lg text-on-surface-variant font-label-sm">
            <span class="flex items-center gap-xs"><span class="material-symbols-outlined text-[16px]">lock</span> Secure</span>
            <span class="flex items-center gap-xs"><span class="material-symbols-outlined text-[16px]">verified_user</span> Verified</span>
          </div>
        </div>
      </div>
    </aside>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, watchEffect } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useConsultantService } from '~/services/consultant.service'

const route = useRoute()
const router = useRouter()
const slug = route.params.slug as string

const { getConsultantBySlug } = useConsultantService()
const { data, pending } = await useAsyncData(`consultant-${slug}`, () => getConsultantBySlug(slug))
const consultant = computed(() => data.value?.data)

useHead({
  title: computed(() => consultant.value ? `${consultant.value.user.name} - ${consultant.value.title} | ConsultFlow` : 'Consultant Profile')
})

const selectedDate = ref('2026-10-12')
const selectedTime = ref('')

const availableTimes = ['09:00:00', '10:30:00', '14:00:00', '16:00:00']

const proceedToPayment = () => {
  if (!selectedTime.value) return
  router.push(`/checkout?consultant=${slug}&date=${selectedDate.value}&time=${selectedTime.value}`)
}
</script>
