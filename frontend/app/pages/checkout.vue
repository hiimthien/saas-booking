<template>
  <div v-if="pending" class="flex justify-center items-center py-24 text-on-surface-variant">
    Loading checkout...
  </div>
  <div v-else-if="!consultant" class="flex justify-center items-center py-24 text-error">
    Invalid consultant or missing data.
  </div>
  <div v-else class="bg-background text-on-background font-body-md min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-surface-container-lowest border-b border-outline-variant py-md px-lg flex items-center shadow-sm">
      <NuxtLink :to="`/consultants/${consultant.slug}`" class="flex items-center gap-sm text-primary hover:text-primary-container transition-colors">
        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">arrow_back</span>
        <span class="font-label-md text-label-md">Back to profile</span>
      </NuxtLink>
      <div class="mx-auto font-headline-md text-headline-md text-on-surface font-semibold tracking-tight">Secure Checkout</div>
    </header>

    <main class="max-w-container-max mx-auto px-margin-mobile md:px-gutter py-xl md:py-2xl flex-grow w-full">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-lg">
        <!-- Left Column -->
        <div class="lg:col-span-7 xl:col-span-8 flex flex-col gap-xl">
          <!-- Payment Method -->
          <section class="bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm p-lg md:p-xl">
            <h2 class="font-headline-md text-headline-md text-on-surface mb-md">Payment Method</h2>
            <div class="flex flex-col gap-sm">
              <label class="relative flex cursor-pointer rounded-lg border border-primary bg-primary-fixed/10 p-md focus:outline-none">
                <input checked class="peer sr-only" name="payment-method" type="radio" value="credit-card" >
                <span class="flex w-full items-center justify-between">
                  <span class="flex items-center gap-md">
                    <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">credit_card</span>
                    <span class="flex flex-col">
                      <span class="font-label-md text-label-md text-on-surface">Credit or Debit Card</span>
                    </span>
                  </span>
                  <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                </span>
              </label>
              <div class="pl-md md:pl-2xl pr-md pb-md flex flex-col gap-md">
                <input class="block w-full rounded-lg border border-outline-variant py-sm px-sm" placeholder="Card number" type="text" >
              </div>
            </div>
          </section>
        </div>

        <!-- Right Column: Order Summary -->
        <div class="lg:col-span-5 xl:col-span-4">
          <div class="sticky top-xl bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm p-lg flex flex-col gap-md">
            <h2 class="font-headline-md text-headline-md text-on-surface pb-sm border-b border-outline-variant">Booking Summary</h2>
            
            <div class="flex items-start gap-md py-sm">
              <img class="w-16 h-16 rounded-full object-cover border border-outline-variant" :src="consultant.user.avatar_url || `https://ui-avatars.com/api/?name=${consultant.user.name}&background=random`" >
              <div class="flex flex-col">
                <span class="font-label-md text-label-md text-on-surface">{{ consultant.title }}</span>
                <span class="font-body-sm text-body-sm text-on-surface-variant">with {{ consultant.user.name }}</span>
              </div>
            </div>
            
            <div class="bg-surface-container rounded-lg p-sm flex items-center gap-sm">
              <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 0;">event</span>
              <div class="flex flex-col">
                <span class="font-label-sm text-label-sm text-on-surface">{{ bookingDate }}</span>
                <span class="font-body-sm text-body-sm text-on-surface-variant">{{ bookingTime }}</span>
              </div>
            </div>
            
            <div class="border-t border-outline-variant my-xs"/>
            
            <div class="flex flex-col gap-sm font-body-sm text-body-sm">
              <div class="flex justify-between items-center text-on-surface-variant">
                <span>Consultation Fee</span>
                <span>${{ consultant.hourly_rate }}</span>
              </div>
              <div class="flex justify-between items-center text-on-surface-variant">
                <span>Platform Fee</span>
                <span>${{ platformFee }}</span>
              </div>
              <div class="flex justify-between items-center font-label-md text-label-md text-on-surface pt-sm">
                <span>Total Due</span>
                <span class="text-primary font-bold text-lg">${{ total }}</span>
              </div>
            </div>
            
            <button 
              class="mt-md w-full bg-primary hover:brightness-90 text-on-primary font-label-md text-label-md py-md rounded-lg flex items-center justify-center gap-sm transition-all focus:outline-none disabled:opacity-50" 
              @click="submitBooking"
              :disabled="isSubmitting"
            >
              <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">lock</span>
              {{ isSubmitting ? 'Processing...' : `Confirm & Pay $${total}` }}
            </button>

            <p v-if="errorMsg" class="text-error text-center text-sm">{{ errorMsg }}</p>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useConsultantService } from '~/services/consultant.service'
import { useBookingService } from '~/services/booking.service'

definePageMeta({ layout: false })

const route = useRoute()
const router = useRouter()

const consultantSlug = route.query.consultant as string
const bookingDate = route.query.date as string
const bookingTime = route.query.time as string

const { getConsultantBySlug } = useConsultantService()
const { createBooking } = useBookingService()

const { data, pending } = await useAsyncData(`checkout-consultant-${consultantSlug}`, () => {
  if (!consultantSlug) return Promise.resolve(null)
  return getConsultantBySlug(consultantSlug)
})

const consultant = computed(() => data.value?.data)

useHead({
  title: 'Secure Checkout | ConsultFlow'
})
const platformFee = 12.50
const total = computed(() => {
  if (!consultant.value) return 0
  return (Number(consultant.value.hourly_rate) + platformFee).toFixed(2)
})

const isSubmitting = ref(false)
const errorMsg = ref('')

const submitBooking = async () => {
  if (!consultant.value || !bookingDate || !bookingTime) {
    errorMsg.value = 'Missing booking details'
    return
  }

  try {
    isSubmitting.value = true
    errorMsg.value = ''
    
    await createBooking({
      consultant_profile_id: consultant.value.id,
      start_time: `${bookingDate} ${bookingTime}`,
      duration_minutes: 60
    })

    // On success
    router.push('/client/dashboard')
  } catch (err: any) {
    errorMsg.value = err.response?._data?.message || 'Failed to create booking'
  } finally {
    isSubmitting.value = false
  }
}
</script>
