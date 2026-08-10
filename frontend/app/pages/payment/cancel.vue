<template>
  <div class="min-h-screen bg-surface-container-lowest flex items-center justify-center p-md font-body-md text-on-surface">
    <UiBaseCard class="max-w-md w-full text-center p-xl">
      <div class="w-20 h-20 bg-error-container text-on-error-container rounded-full flex items-center justify-center mx-auto mb-lg">
        <span class="material-symbols-outlined text-[40px]">cancel</span>
      </div>
      <h1 class="font-headline-lg mb-sm">Payment Cancelled</h1>
      <p class="font-body-md text-on-surface-variant mb-xl">
        You have cancelled the payment process. No charges were made.
      </p>
      
      <div class="space-y-sm">
        <UiBaseButton variant="primary" class="w-full justify-center" @click="goToDashboard">
          Return to Dashboard
        </UiBaseButton>
      </div>
    </UiBaseCard>
  </div>
</template>

<script setup lang="ts">
import { useAuthStore } from '~/stores/auth'

definePageMeta({ layout: false })

const authStore = useAuthStore()

const goToDashboard = () => {
  if (authStore.user?.role === 'client') {
    navigateTo('/client/dashboard')
  } else if (authStore.user?.role === 'provider') {
    navigateTo('/provider/dashboard')
  } else {
    navigateTo('/')
  }
}
</script>
