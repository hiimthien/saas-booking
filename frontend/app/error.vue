<template>
  <div class="min-h-screen bg-surface flex flex-col items-center justify-center p-md">
    <div class="max-w-md w-full bg-surface-container-lowest border border-outline-variant rounded-2xl shadow-lg p-xl flex flex-col items-center text-center">
      
      <!-- Error Illustration / Icon -->
      <div class="w-24 h-24 bg-error-container text-on-error-container rounded-full flex items-center justify-center mb-lg shadow-sm">
        <span v-if="error?.statusCode === 404" class="material-symbols-outlined text-[48px]">location_off</span>
        <span v-else class="material-symbols-outlined text-[48px]">error</span>
      </div>

      <!-- Error Content -->
      <h1 class="font-display-md text-display-md text-on-surface font-bold mb-xs">
        {{ error?.statusCode === 404 ? 'Page Not Found' : 'Something went wrong' }}
      </h1>
      
      <p class="font-body-md text-body-md text-on-surface-variant mb-lg">
        {{ error?.message || 'We apologize, but an unexpected error has occurred. Our team has been notified.' }}
      </p>

      <!-- Action Buttons -->
      <div class="w-full flex flex-col sm:flex-row gap-sm">
        <button class="flex-1 bg-primary text-on-primary hover:bg-primary-container hover:text-on-primary-container px-lg py-sm rounded-xl font-label-lg text-label-lg shadow-sm transition-colors flex justify-center items-center gap-sm" @click="handleError">
          <span class="material-symbols-outlined text-[20px]">home</span>
          Back to Home
        </button>
        <button class="flex-1 bg-surface-container border border-outline-variant text-on-surface hover:bg-surface-variant px-lg py-sm rounded-xl font-label-lg text-label-lg transition-colors flex justify-center items-center gap-sm">
          <span class="material-symbols-outlined text-[20px]">refresh</span>
          Try Again
        </button>
      </div>

      <!-- Technical Details (Optional/Collapsible) -->
      <div v-if="error?.stack" class="w-full mt-lg pt-lg border-t border-outline-variant text-left">
        <details class="group cursor-pointer">
          <summary class="font-label-sm text-label-sm text-on-surface-variant list-none flex items-center gap-xs hover:text-primary transition-colors">
            <span class="material-symbols-outlined text-[16px] group-open:rotate-90 transition-transform">chevron_right</span>
            Technical Details
          </summary>
          <div class="mt-sm p-sm bg-surface-container-low rounded-lg overflow-x-auto">
            <code class="font-body-sm text-[12px] text-error">{{ error.stack }}</code>
          </div>
        </details>
      </div>

    </div>
  </div>
</template>

<script setup lang="ts">
import type { NuxtError } from '#app'

defineProps({
  error: {
    type: Object as () => NuxtError,
    default: null
  }
})

const handleError = () => clearError({ redirect: '/' })
</script>
