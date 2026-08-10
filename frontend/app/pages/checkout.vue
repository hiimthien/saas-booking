<template>
  <div v-if="pending" class="flex flex-col justify-center items-center h-screen bg-surface-container-lowest text-on-surface-variant">
    <span class="material-symbols-outlined animate-spin text-[48px] text-primary mb-md">progress_activity</span>
    <p class="font-headline-sm">Initializing Secure Checkout...</p>
  </div>
  <div v-else-if="!consultant" class="flex flex-col justify-center items-center h-screen bg-surface-container-lowest text-error text-center">
    <span class="material-symbols-outlined text-[64px] mb-md">error_outline</span>
    <h2 class="font-headline-md mb-sm">Session Expired or Invalid</h2>
    <p class="font-body-md text-on-surface-variant mb-lg">We couldn't find the booking details. Please try booking again.</p>
    <NuxtLink to="/" class="px-xl py-sm bg-primary text-on-primary rounded-xl font-label-md hover:bg-surface-tint transition-all shadow-sm">
      Return Home
    </NuxtLink>
  </div>
  <div v-else class="bg-background text-on-background font-body-md min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-surface-container-lowest border-b border-outline-variant py-md px-lg flex items-center justify-between shadow-sm sticky top-0 z-10">
      <NuxtLink :to="`/consultants/${consultant.slug}`" class="flex items-center gap-sm text-primary hover:text-primary-container transition-colors group">
        <span class="material-symbols-outlined group-hover:-translate-x-1 transition-transform" style="font-variation-settings: 'FILL' 0;">arrow_back</span>
        <span class="font-label-md text-label-md hidden md:inline">Back to profile</span>
      </NuxtLink>
      <div class="flex items-center gap-sm font-headline-md text-headline-md text-on-surface font-semibold tracking-tight">
        <span class="material-symbols-outlined text-primary text-[28px]">lock</span>
        Secure Checkout
      </div>
      <div class="w-24 text-right">
        <!-- Placeholder for symmetry -->
        <span class="font-label-sm text-on-surface-variant italic">Test Mode</span>
      </div>
    </header>

    <main class="max-w-6xl mx-auto px-lg py-xl md:py-2xl flex-grow w-full">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-xl">
        <!-- Left Column: Payment Details -->
        <div class="lg:col-span-7 flex flex-col gap-xl">
          
          <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant shadow-sm overflow-hidden">
            <div class="p-lg md:p-xl bg-surface-container/30 border-b border-outline-variant">
              <h2 class="font-headline-md text-on-surface">Payment Method</h2>
              <p class="font-body-sm text-on-surface-variant mt-xs">All transactions are secure and encrypted.</p>
            </div>
            
            <div class="p-lg md:p-xl">
              <label class="relative flex cursor-pointer rounded-xl border-2 border-primary bg-primary/5 p-md focus:outline-none mb-xl transition-colors">
                <input checked class="peer sr-only" name="payment-method" type="radio" value="credit-card" >
                <span class="flex w-full items-center justify-between">
                  <span class="flex items-center gap-md">
                    <span class="material-symbols-outlined text-primary text-[28px]" style="font-variation-settings: 'FILL' 1;">credit_card</span>
                    <span class="flex flex-col">
                      <span class="font-label-lg text-on-surface">Credit or Debit Card</span>
                    </span>
                  </span>
                  <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                </span>
              </label>

              <form @submit.prevent="submitBooking" class="space-y-lg">
                <!-- Cardholder Name -->
                <div class="space-y-xs">
                  <BaseInput v-model="paymentForm.name" label="Name on Card" placeholder="e.g. Jane Doe" required />
                </div>
                
                <!-- Card Number -->
                <div class="space-y-xs">
                  <div class="relative">
                    <BaseInput v-model="paymentForm.cardNumber" @input="formatCardNumber" label="Card Number" placeholder="4242 4242 4242 4242" required class="tracking-wider" />
                    <div class="absolute right-3 top-9 text-on-surface-variant flex gap-1 z-10">
                      <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" class="h-6 opacity-60 grayscale hover:grayscale-0 transition-all" alt="Visa">
                      <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" class="h-6 opacity-60 grayscale hover:grayscale-0 transition-all" alt="Mastercard">
                    </div>
                  </div>
                </div>

                <!-- Expiry & CVC -->
                <div class="grid grid-cols-2 gap-lg">
                  <div class="space-y-xs">
                    <BaseInput v-model="paymentForm.expiry" @input="formatExpiry" label="Expiry Date" placeholder="MM/YY" required class="text-center tracking-widest" />
                  </div>
                  <div class="space-y-xs">
                    <div class="relative">
                      <BaseInput v-model="paymentForm.cvc" label="CVC / CVV" placeholder="123" required class="text-center tracking-widest" />
                      <span class="material-symbols-outlined absolute right-3 top-9 text-on-surface-variant text-[18px] z-10">help</span>
                    </div>
                  </div>
                </div>

                <!-- Error Alert -->
                <div v-if="errorMsg" class="mt-md p-md bg-error-container border border-error/20 text-on-error-container rounded-xl font-body-sm flex items-start gap-sm">
                  <span class="material-symbols-outlined text-[20px] shrink-0">warning</span>
                  <p>{{ errorMsg }}</p>
                </div>
              </form>
            </div>
          </div>
        </div>

        <!-- Right Column: Order Summary -->
        <div class="lg:col-span-5">
          <div class="sticky top-24 bg-surface-container-lowest rounded-2xl border border-outline-variant shadow-sm overflow-hidden flex flex-col">
            <div class="p-lg bg-surface-container/30 border-b border-outline-variant">
              <h2 class="font-headline-md text-on-surface">Booking Summary</h2>
            </div>
            
            <div class="p-lg flex-1">
              <!-- Consultant Info -->
              <div class="flex items-center gap-md pb-md border-b border-outline-variant mb-md">
                <img class="w-16 h-16 rounded-xl object-cover border border-outline-variant shadow-sm" :src="consultant.user.avatar_url ? backendUrl(consultant.user.avatar_url) : `https://ui-avatars.com/api/?name=${consultant.user.name}&background=random`" >
                <div class="flex flex-col">
                  <span class="font-headline-sm text-on-surface">{{ consultant.user.name }}</span>
                  <span class="font-body-sm text-on-surface-variant">{{ consultant.title }}</span>
                </div>
              </div>
              
              <!-- Session Info -->
              <div class="bg-surface-container rounded-xl p-md flex flex-col gap-sm mb-lg">
                <div class="flex items-center gap-md text-on-surface">
                  <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center text-primary shrink-0">
                    <span class="material-symbols-outlined">calendar_today</span>
                  </div>
                  <div>
                    <div class="font-label-lg">{{ bookingDateFormatted }}</div>
                    <div class="font-body-sm text-on-surface-variant">{{ bookingTimeFormatted }} (60 mins)</div>
                  </div>
                </div>
              </div>
              
              <!-- Cost Breakdown -->
              <div class="flex flex-col gap-sm font-body-md text-on-surface-variant mb-xl">
                <div class="flex justify-between items-center">
                  <span>Consultation Fee</span>
                  <span class="font-medium text-on-surface">${{ consultant.hourly_rate }}</span>
                </div>
                <div class="flex justify-between items-center">
                  <span>Platform Fee</span>
                  <span class="font-medium text-on-surface">${{ platformFee.toFixed(2) }}</span>
                </div>
              </div>
              
              <!-- Total -->
              <div class="border-t border-outline-variant pt-lg flex justify-between items-end mb-xl">
                <div class="flex flex-col">
                  <span class="font-label-lg text-on-surface">Total Due</span>
                  <span class="font-body-sm text-on-surface-variant">Includes taxes</span>
                </div>
                <span class="text-primary font-display-sm font-bold">${{ total }}</span>
              </div>
              
              <!-- Submit Button -->
              <BaseButton 
                class="w-full py-lg font-headline-sm relative overflow-hidden group shadow-md"
                @click="submitBooking"
                :disabled="isSubmitting || !isFormValid"
                :loading="isSubmitting"
                size="lg"
              >
                <!-- Shine effect -->
                <div class="absolute inset-0 -translate-x-full group-hover:animate-[shimmer_1.5s_infinite] bg-gradient-to-r from-transparent via-white/20 to-transparent z-0"></div>
                <span class="relative z-10 flex items-center justify-center gap-sm">
                  <span v-if="!isSubmitting" class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">lock</span>
                  {{ isSubmitting ? 'Processing Payment...' : `Pay $${total}` }}
                </span>
              </BaseButton>
              
              <p class="text-center text-on-surface-variant text-[12px] mt-md mt-sm flex items-center justify-center gap-xs">
                <span class="material-symbols-outlined text-[14px]">shield</span>
                Guaranteed safe & secure checkout
              </p>
            </div>
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
import { usePaymentService } from '~/services/payment.service'
import { useRuntimeConfig } from '#app'

definePageMeta({ layout: false, middleware: ['auth'] })

const route = useRoute()
const router = useRouter()
const config = useRuntimeConfig()

const consultantSlug = route.query.consultant as string
const bookingDate = route.query.date as string
const bookingTime = route.query.time as string

const { getConsultantBySlug } = useConsultantService()
const { createBooking } = useBookingService()
const { processPayment } = usePaymentService()

const { data, pending } = await useAsyncData(`checkout-consultant-${consultantSlug}`, () => {
  if (!consultantSlug) return Promise.resolve(null)
  return getConsultantBySlug(consultantSlug)
})

const consultant = computed(() => data.value?.data)

useHead({ title: 'Secure Checkout | ConsultFlow' })

const backendUrl = (path: string | undefined) => {
  if (!path) return ''
  if (path.startsWith('http')) return path
  const base = (config.public.apiBase as string).replace('/api', '')
  return `${base}${path}`
}

const bookingDateFormatted = computed(() => {
  if (!bookingDate) return ''
  return new Date(bookingDate).toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })
})

const bookingTimeFormatted = computed(() => {
  if (!bookingTime) return ''
  // Convert "08:00:00" to "08:00 AM"
  const [h, m] = bookingTime.split(':')
  const date = new Date()
  date.setHours(parseInt(h, 10), parseInt(m, 10))
  return date.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' })
})

const platformFee = 12.50
const total = computed(() => {
  if (!consultant.value) return '0.00'
  return (Number(consultant.value.hourly_rate) + platformFee).toFixed(2)
})

const isSubmitting = ref(false)
const errorMsg = ref('')

const paymentForm = ref({
  name: 'Jane Doe', // pre-filled for demo
  cardNumber: '4242 4242 4242 4242',
  expiry: '12/25',
  cvc: '123'
})

// Visual formatting for card inputs
const formatCardNumber = (e: Event) => {
  const target = e.target as HTMLInputElement
  let val = target.value.replace(/\D/g, '')
  if (val.length > 16) val = val.substring(0, 16)
  const matches = val.match(/.{1,4}/g)
  paymentForm.value.cardNumber = matches ? matches.join(' ') : val
}

const formatExpiry = (e: Event) => {
  const target = e.target as HTMLInputElement
  let val = target.value.replace(/\D/g, '')
  if (val.length >= 2) {
    paymentForm.value.expiry = val.substring(0, 2) + '/' + val.substring(2, 4)
  } else {
    paymentForm.value.expiry = val
  }
}

const isFormValid = computed(() => {
  return paymentForm.value.name.length > 0 &&
         paymentForm.value.cardNumber.replace(/\s/g, '').length === 16 &&
         paymentForm.value.expiry.length === 5 &&
         paymentForm.value.cvc.length >= 3
})

const submitBooking = async () => {
  if (!consultant.value || !bookingDate || !bookingTime) {
    errorMsg.value = 'Missing booking details. Please go back and try again.'
    return
  }
  
  if (!isFormValid.value) {
    errorMsg.value = 'Please fill out all payment details correctly.'
    return
  }

  try {
    isSubmitting.value = true
    errorMsg.value = ''
    
    // 1. Create Booking
    const bookingRes = await createBooking({
      consultant_profile_id: consultant.value.id,
      start_time: `${bookingDate} ${bookingTime}`,
      duration_minutes: 60
    })

    const consultationId = bookingRes.data?.id
    if (!consultationId) {
      throw new Error("Failed to retrieve booking ID from server.")
    }

    // 2. Process Payment Mock
    await processPayment({
      consultation_id: consultationId,
      payment_method: 'credit-card'
    })

    // 3. Success Redirect
    router.push(`/checkout/success?booking_id=${consultationId}`)
    
  } catch (err: any) {
    errorMsg.value = err.response?._data?.message || err.message || 'Failed to process checkout. Please try again.'
  } finally {
    isSubmitting.value = false
  }
}
</script>

<style scoped>
@keyframes shimmer {
  100% { transform: translateX(100%); }
}
</style>
