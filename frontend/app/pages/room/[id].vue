<template>
  <div class="bg-slate-900 text-on-surface h-screen w-screen overflow-hidden flex flex-col font-body-md dark">
    <!-- Header -->
    <header class="bg-slate-900 border-b border-slate-800 flex justify-between items-center px-lg py-sm z-50 shrink-0">
      <div class="flex items-center gap-md">
        <NuxtLink to="/client/dashboard" class="flex items-center gap-xs font-headline-md font-bold text-white tracking-tight hover:text-primary transition-colors">
          <span class="material-symbols-outlined text-primary">arrow_back</span>
          <span>ConsultFlow</span>
        </NuxtLink>
        <div class="h-4 w-px bg-slate-700"/>
        <span class="text-slate-300 font-body-md truncate max-w-xs md:max-w-md">
          Live Session: {{ bookingTitle || `Booking #${bookingId}` }}
        </span>
      </div>
      <div class="flex items-center gap-md">
        <div class="bg-slate-800 px-md py-sm rounded-lg flex items-center gap-sm border border-slate-700 shadow-sm">
          <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"/>
          <span class="text-white font-label-md tracking-wider">LIVE</span>
        </div>
        <button 
          class="px-md py-sm bg-red-600 hover:bg-red-700 text-white rounded-lg font-label-md flex items-center gap-xs shadow-md transition-all"
          @click="handleEndCall"
        >
          <span class="material-symbols-outlined text-[18px]">call_end</span>
          <span>End Session</span>
        </button>
      </div>
    </header>

    <!-- Main Video Workspace -->
    <main class="flex-1 flex overflow-hidden relative bg-black">
      <!-- Jitsi Video Call Iframe -->
      <iframe
        v-if="jitsiRoomUrl"
        :src="jitsiRoomUrl"
        class="w-full h-full border-0"
        allow="camera; microphone; fullscreen; display-capture; autoplay; clipboard-write"
      />
      <div v-else class="flex flex-col items-center justify-center w-full h-full text-slate-400 gap-md">
        <span class="material-symbols-outlined animate-spin text-[48px] text-primary">progress_activity</span>
        <p>Connecting to secure consultation room...</p>
      </div>
    </main>

    <!-- Post-Call Review Modal -->
    <SharedReviewModal
      :is-open="showReviewModal"
      :booking-id="bookingId"
      :consultant-name="consultantName"
      @close="onReviewClosed"
      @reviewed="onReviewCompleted"
    />
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useAuthStore } from '~/stores/auth'
import SharedReviewModal from '~/components/shared/ReviewModal.vue'

definePageMeta({ layout: false, middleware: ['auth'] })

const route = useRoute()
const router = useRouter()
const authStore = useAuthStore()

const bookingId = route.params.id as string
const bookingTitle = ref('')
const consultantName = ref('')
const showReviewModal = ref(false)
const rawMeetingLink = ref('')

const jitsiRoomUrl = computed(() => {
  if (rawMeetingLink.value) {
    return rawMeetingLink.value
  }
  // Fallback to room name based on ULID or ID
  return `https://meet.jit.si/saas-booking-${bookingId}#config.prejoinPageEnabled=false`
})

const fetchBooking = async () => {
  try {
    const res: any = await authStore.apiFetch(`/bookings/${bookingId}`)
    if (res?.data) {
      const b = res.data
      bookingTitle.value = b.notes || (b.consultantProfile?.title ? `Session with ${b.consultantProfile?.user?.name}` : '')
      consultantName.value = b.consultantProfile?.user?.name || ''
      if (b.meeting_link) {
        rawMeetingLink.value = b.meeting_link
      }
    }
  } catch (e) {
    console.warn('Could not fetch booking details directly, using room fallback', e)
  }
}

const handleEndCall = () => {
  // If user is a customer/client, prompt review modal
  if (authStore.user?.role !== 'consultant') {
    showReviewModal.value = true
  } else {
    router.push('/provider/dashboard')
  }
}

const onReviewClosed = () => {
  showReviewModal.value = false
  router.push('/client/dashboard')
}

const onReviewCompleted = () => {
  showReviewModal.value = false
  router.push('/client/dashboard')
}

onMounted(() => {
  fetchBooking()
})
</script>
