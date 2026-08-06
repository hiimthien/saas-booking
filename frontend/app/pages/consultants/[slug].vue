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
        <div class="flex items-center justify-between mb-4">
          <h2 class="font-headline-md text-on-surface">Customer Reviews</h2>
          <div class="flex items-center gap-sm">
            <span class="font-headline-md text-on-surface">{{ Number(consultant?.rating || 0).toFixed(1) }}</span>
            <div class="flex text-amber-500">
              <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
            </div>
            <span class="font-body-sm text-on-surface-variant">({{ consultant?.reviews_count || 0 }} reviews)</span>
          </div>
        </div>
        
        <div v-if="!consultant?.reviews || consultant.reviews.length === 0" class="text-on-surface-variant text-body-md py-4 text-center border rounded-xl border-dashed border-outline-variant">
          No reviews yet. Be the first to book!
        </div>
        
        <div v-else class="flex flex-col gap-md">
          <div v-for="review in consultant.reviews" :key="review.id" class="flex flex-col gap-sm p-4 bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm">
            <div class="flex justify-between items-center">
              <div class="flex items-center gap-3">
                <img :src="review.customer?.avatar_url || `https://ui-avatars.com/api/?name=${review.customer?.name}&background=random`" class="w-10 h-10 rounded-full" alt="avatar">
                <span class="font-label-md text-on-surface">{{ review.customer?.name || 'Anonymous' }}</span>
              </div>
              <div class="flex text-amber-500 text-sm">
                <span v-for="n in 5" :key="n" class="material-symbols-outlined text-[16px]" :class="n <= review.rating ? '' : 'text-outline-variant'" :style="n <= review.rating ? 'font-variation-settings: \'FILL\' 1;' : ''">star</span>
              </div>
            </div>
            <p class="text-body-sm text-on-surface-variant mt-2">{{ review.comment }}</p>
            <span class="text-xs text-on-surface-variant/70">{{ new Date(review.created_at).toLocaleDateString() }}</span>
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

        <!-- Calendar Picker -->
        <div class="flex flex-col gap-sm">
          <div class="flex justify-between items-center">
            <button @click="changeMonth(-1)" class="p-xs hover:bg-surface-variant rounded transition-colors"><span class="material-symbols-outlined">chevron_left</span></button>
            <span class="font-label-md text-on-surface">{{ currentMonthName }}</span>
            <button @click="changeMonth(1)" class="p-xs hover:bg-surface-variant rounded transition-colors"><span class="material-symbols-outlined">chevron_right</span></button>
          </div>
          <div class="grid grid-cols-7 gap-xs text-center font-label-sm text-on-surface-variant mb-xs">
            <span>Su</span><span>Mo</span><span>Tu</span><span>We</span><span>Th</span><span>Fr</span><span>Sa</span>
          </div>
          <div class="grid grid-cols-7 gap-xs text-center font-body-sm">
            <span 
              v-for="(day, idx) in calendarDays" 
              :key="idx"
              @click="!day.disabled && selectDate(day.date)"
              :class="[
                'py-sm rounded cursor-pointer',
                !day.isCurrentMonth ? 'text-transparent' : '',
                day.disabled ? 'text-on-surface-variant/30 cursor-not-allowed' : 'text-on-surface-variant hover:bg-surface-variant',
                selectedDate && day.date.getTime() === selectedDate.getTime() ? 'bg-primary text-on-primary font-bold shadow-sm hover:bg-primary' : ''
              ]"
            >
              {{ day.isCurrentMonth ? day.date.getDate() : '' }}
            </span>
          </div>
        </div>

        <!-- Time Slots -->
        <div class="flex flex-col gap-sm pt-sm border-t border-outline-variant">
          <span class="font-label-md text-on-surface">Available Times</span>
          <div v-if="!selectedDate" class="text-sm text-on-surface-variant">Please select a date first.</div>
          <div v-else-if="availableTimes.length === 0" class="text-sm text-error">No slots available on this date.</div>
          <div v-else class="grid grid-cols-2 gap-sm max-h-48 overflow-y-auto">
            <button 
              v-for="time in availableTimes" 
              :key="time"
              @click="selectedTime = time"
              :class="['border rounded py-sm font-label-sm transition-colors', selectedTime === time ? 'border-primary bg-primary-container/10 text-primary' : 'border-outline-variant text-on-surface hover:border-primary hover:text-primary']"
            >
              {{ time.substring(0, 5) }}
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
import { ref, computed } from 'vue'
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

// Calendar Logic
const currentDate = ref(new Date())
const selectedDate = ref<Date | null>(null)
const selectedTime = ref('')

const currentMonthName = computed(() => {
  return currentDate.value.toLocaleString('default', { month: 'long', year: 'numeric' })
})

const changeMonth = (delta: number) => {
  const d = new Date(currentDate.value)
  d.setMonth(d.getMonth() + delta)
  currentDate.value = d
}

const calendarDays = computed(() => {
  if (!consultant.value) return []
  
  const days = []
  const start = new Date(currentDate.value.getFullYear(), currentDate.value.getMonth(), 1)
  const end = new Date(currentDate.value.getFullYear(), currentDate.value.getMonth() + 1, 0)
  
  // padding for previous month
  const startDay = start.getDay() // 0 = Sunday
  for (let i = 0; i < startDay; i++) {
    const d = new Date(start)
    d.setDate(d.getDate() - (startDay - i))
    days.push({ date: d, isCurrentMonth: false, disabled: true })
  }
  
  // current month
  for (let i = 1; i <= end.getDate(); i++) {
    const d = new Date(currentDate.value.getFullYear(), currentDate.value.getMonth(), i)
    const today = new Date()
    today.setHours(0, 0, 0, 0)
    
    // JS getDay(): 0 = Sunday, 1 = Monday. PHP day_of_week: 1=Mon, ..., 7=Sun
    let phpDay = d.getDay()
    if (phpDay === 0) phpDay = 7
    
    const wh = consultant.value.working_hours.find((w: any) => w.day_of_week === phpDay)
    const isClosed = !wh || wh.is_closed || d < today
    
    days.push({ 
      date: d, 
      isCurrentMonth: true, 
      disabled: isClosed
    })
  }
  
  return days
})

const selectDate = (date: Date) => {
  selectedDate.value = date
  selectedTime.value = '' // reset time when date changes
}

const availableTimes = computed(() => {
  if (!selectedDate.value || !consultant.value) return []
  
  let phpDay = selectedDate.value.getDay()
  if (phpDay === 0) phpDay = 7
  
  const wh = consultant.value.working_hours.find((w: any) => w.day_of_week === phpDay)
  if (!wh || wh.is_closed || !wh.start_time || !wh.end_time) return []
  
  const slots = []
  const startHour = parseInt(wh.start_time.split(':')[0])
  const endHour = parseInt(wh.end_time.split(':')[0])
  
  for (let i = startHour; i < endHour; i++) {
    const timeStr = `${i.toString().padStart(2, '0')}:00:00`
    slots.push(timeStr)
  }
  
  return slots
})

const proceedToPayment = () => {
  if (!selectedTime.value || !selectedDate.value) return
  // Format YYYY-MM-DD
  const yyyy = selectedDate.value.getFullYear()
  const mm = String(selectedDate.value.getMonth() + 1).padStart(2, '0')
  const dd = String(selectedDate.value.getDate()).padStart(2, '0')
  const dateStr = `${yyyy}-${mm}-${dd}`
  
  router.push(`/checkout?consultant=${slug}&date=${dateStr}&time=${selectedTime.value}`)
}
</script>
