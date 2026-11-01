<template>
  <div v-if="isOpen" class="fixed inset-0 z-50 bg-on-surface/50 backdrop-blur-sm flex items-center justify-center p-md animate-[fadeIn_0.2s_ease-out]">
    <div class="bg-surface-container-lowest w-full max-w-lg rounded-2xl shadow-xl border border-outline-variant overflow-hidden flex flex-col">
      <!-- Header -->
      <div class="px-lg pt-lg pb-md flex justify-between items-start border-b border-surface-container-highest">
        <div>
          <h2 class="font-headline-md text-headline-md text-on-surface">Rate Your Session</h2>
          <p class="font-body-sm text-on-surface-variant mt-xs">
            How was your consultation with {{ consultantName || 'your expert' }}?
          </p>
        </div>
        <button 
          @click="closeModal" 
          class="text-on-surface-variant hover:text-on-surface transition-colors p-sm rounded-full hover:bg-surface-container-low"
        >
          <span class="material-symbols-outlined">close</span>
        </button>
      </div>

      <!-- Body -->
      <div class="p-lg flex flex-col gap-lg">
        <!-- Success Alert -->
        <div v-if="successMsg" class="p-md bg-primary-container text-on-primary-container rounded-xl font-body-sm flex items-center gap-sm">
          <span class="material-symbols-outlined">check_circle</span>
          {{ successMsg }}
        </div>

        <!-- Error Alert -->
        <div v-if="errorMsg" class="p-md bg-error-container text-on-error-container rounded-xl font-body-sm flex items-center gap-sm">
          <span class="material-symbols-outlined">error</span>
          {{ errorMsg }}
        </div>

        <!-- Star Rating -->
        <div class="flex flex-col items-center justify-center py-sm">
          <div class="flex gap-sm text-surface-dim">
            <button
              v-for="star in 5"
              :key="star"
              type="button"
              @click="setRating(star)"
              @mouseenter="hoverRating = star"
              @mouseleave="hoverRating = 0"
              class="focus:outline-none transition-transform hover:scale-125 duration-150"
            >
              <span 
                class="material-symbols-outlined text-[44px]"
                :class="star <= (hoverRating || currentRating) ? 'text-amber-500' : 'text-outline-variant/60'"
                :style="star <= (hoverRating || currentRating) ? 'font-variation-settings: \'FILL\' 1;' : ''"
              >
                star
              </span>
            </button>
          </div>
          <span class="font-label-md text-primary mt-sm h-5 font-semibold">
            {{ ratingLabel }}
          </span>
        </div>

        <!-- Chips / Quick Tags -->
        <div>
          <p class="font-label-sm text-on-surface-variant uppercase mb-sm tracking-wider">What went well?</p>
          <div class="flex flex-wrap gap-sm">
            <button
              v-for="chip in quickChips"
              :key="chip"
              type="button"
              @click="toggleChip(chip)"
              :class="[
                'inline-flex items-center gap-xs px-md py-sm rounded-full border text-body-sm transition-all select-none',
                selectedChips.includes(chip)
                  ? 'border-primary bg-primary/10 text-primary font-medium'
                  : 'border-outline-variant bg-surface-container-lowest text-on-surface hover:bg-surface-container-low'
              ]"
            >
              <span v-if="selectedChips.includes(chip)" class="material-symbols-outlined text-[16px]">check</span>
              {{ chip }}
            </button>
          </div>
        </div>

        <!-- Feedback Textarea -->
        <div class="flex flex-col gap-xs">
          <label class="font-label-sm text-on-surface-variant uppercase tracking-wider" for="feedback">
            Additional Comments (Optional)
          </label>
          <textarea
            id="feedback"
            v-model="comment"
            class="w-full rounded-xl border border-outline-variant bg-surface-container-lowest font-body-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none resize-none p-md placeholder:text-on-surface-variant/50"
            placeholder="Share more details about your experience..."
            rows="3"
          />
        </div>
      </div>

      <!-- Footer Actions -->
      <div class="px-lg py-md bg-surface-container-low flex justify-end gap-sm border-t border-surface-container-highest">
        <UiBaseButton variant="outline" @click="closeModal" :disabled="isSubmitting">
          Skip
        </UiBaseButton>
        <UiBaseButton 
          variant="primary" 
          @click="submitReview" 
          :disabled="currentRating === 0 || isSubmitting"
          :loading="isSubmitting"
        >
          Submit Review
        </UiBaseButton>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { useAuthStore } from '~/stores/auth'

const props = defineProps({
  isOpen: {
    type: Boolean,
    default: false
  },
  bookingId: {
    type: [Number, String],
    required: true
  },
  consultantName: {
    type: String,
    default: ''
  }
})

const emit = defineEmits(['close', 'reviewed'])

const authStore = useAuthStore()

const currentRating = ref(5)
const hoverRating = ref(0)
const comment = ref('')
const selectedChips = ref<string[]>([])
const isSubmitting = ref(false)
const errorMsg = ref('')
const successMsg = ref('')

const ratingTexts = ['Poor', 'Fair', 'Good', 'Very Good', 'Excellent']

const quickChips = [
  'Great Insights',
  'Very Professional',
  'Clear Communication',
  'Actionable Advice'
]

const ratingLabel = computed(() => {
  const r = hoverRating.value || currentRating.value
  return r > 0 ? ratingTexts[r - 1] : ''
})

const setRating = (rating: number) => {
  currentRating.value = rating
}

const toggleChip = (chip: string) => {
  if (selectedChips.value.includes(chip)) {
    selectedChips.value = selectedChips.value.filter(c => c !== chip)
  } else {
    selectedChips.value.push(chip)
  }
}

const closeModal = () => {
  errorMsg.value = ''
  successMsg.value = ''
  emit('close')
}

const submitReview = async () => {
  if (currentRating.value === 0) {
    errorMsg.value = 'Please select a star rating.'
    return
  }

  isSubmitting.value = true
  errorMsg.value = ''
  successMsg.value = ''

  try {
    // Combine chips and custom comment if any
    let fullComment = comment.value.trim()
    if (selectedChips.value.length > 0) {
      const chipsText = selectedChips.value.join(', ')
      fullComment = fullComment ? `[${chipsText}] ${fullComment}` : chipsText
    }

    await authStore.apiFetch(`/bookings/${props.bookingId}/reviews`, {
      method: 'POST',
      body: {
        rating: currentRating.value,
        comment: fullComment || null
      }
    })

    successMsg.value = 'Thank you! Your review has been submitted successfully.'
    setTimeout(() => {
      emit('reviewed')
      closeModal()
    }, 1200)

  } catch (err: any) {
    console.error('Failed to submit review:', err)
    errorMsg.value = err.data?.message || err.message || 'Failed to submit review. Please try again.'
  } finally {
    isSubmitting.value = false
  }
}
</script>

