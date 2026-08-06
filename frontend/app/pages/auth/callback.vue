<template>
  <div class="h-screen bg-background flex flex-col items-center justify-center">
    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary mb-4"></div>
    <h2 class="font-headline-md text-on-background">Authenticating...</h2>
    <p class="font-body-md text-on-surface-variant mt-2">Please wait while we log you in.</p>
  </div>
</template>

<script setup lang="ts">
import { onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useAuthStore } from '~/stores/auth'

definePageMeta({ layout: false })

const route = useRoute()
const router = useRouter()
const authStore = useAuthStore()

onMounted(async () => {
  const token = route.query.token as string
  if (token) {
    authStore.token = token
    // Fetch current user using new token
    try {
      const userRes = await authStore.apiFetch('/user')
      authStore.user = userRes as any
      
      if (authStore.user?.role === 'admin') {
        router.push('/admin/dashboard')
      } else if (authStore.user?.role === 'consultant') {
        router.push('/provider/dashboard')
      } else {
        router.push('/client/dashboard')
      }
    } catch (e) {
      console.error('Failed to fetch user profile:', e)
      router.push('/login?error=google_auth_failed')
    }
  } else {
    router.push('/login?error=missing_token')
  }
})
</script>
