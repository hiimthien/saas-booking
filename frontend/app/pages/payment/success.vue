<template>
  <div class="min-h-screen bg-surface-container-lowest flex items-center justify-center p-md font-body-md text-on-surface">
    <UiBaseCard class="max-w-md w-full text-center p-xl">
      <div class="w-20 h-20 bg-primary-container text-on-primary-container rounded-full flex items-center justify-center mx-auto mb-lg">
        <span class="material-symbols-outlined text-[40px]">check_circle</span>
      </div>
      <h1 class="font-headline-lg mb-sm">Payment Successful!</h1>
      <p class="font-body-md text-on-surface-variant mb-xl">
        Your top-up has been successfully processed. The amount has been credited to your wallet.
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
