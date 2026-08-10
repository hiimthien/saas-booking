<template>
  <div class="p-margin-mobile md:p-lg xl:p-xl flex-1 w-full max-w-4xl mx-auto">
    <!-- Header -->
    <header class="mb-lg">
      <h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface">Professional Profile</h1>
      <p class="font-body-md text-on-surface-variant mt-xs">Update your consultant details that clients will see on your public page.</p>
    </header>

    <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl shadow-sm overflow-hidden">
      <form @submit.prevent="saveProfile" class="p-lg space-y-xl">
        <div class="grid grid-cols-1 gap-lg">
          <div class="space-y-xs">
            <label class="font-label-md text-on-surface">Professional Title</label>
            <input v-model="profileForm.title" type="text" placeholder="e.g. Senior Software Engineer" class="w-full px-md py-sm rounded-lg border border-outline-variant bg-surface-container-lowest focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-shadow text-on-surface" required>
          </div>
          
          <div class="space-y-xs">
            <label class="font-label-md text-on-surface">Hourly Rate ($)</label>
            <input v-model="profileForm.hourly_rate" type="number" min="0" step="0.01" placeholder="50.00" class="w-full px-md py-sm rounded-lg border border-outline-variant bg-surface-container-lowest focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-shadow text-on-surface" required>
          </div>

          <div class="space-y-xs">
            <label class="font-label-md text-on-surface">Professional Bio</label>
            <textarea v-model="profileForm.bio" rows="6" placeholder="Tell clients about your experience and how you can help them..." class="w-full px-md py-sm rounded-lg border border-outline-variant bg-surface-container-lowest focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-shadow text-on-surface"></textarea>
          </div>
        </div>

        <div v-if="successMsg" class="p-sm bg-primary-container text-on-primary-container rounded-lg font-body-sm flex items-center gap-sm">
          <span class="material-symbols-outlined">check_circle</span>
          {{ successMsg }}
        </div>
        <div v-if="errorMsg" class="p-sm bg-error-container text-on-error-container rounded-lg font-body-sm flex items-center gap-sm">
          <span class="material-symbols-outlined">error</span>
          {{ errorMsg }}
        </div>
        
        <div class="flex justify-end pt-md border-t border-outline-variant">
          <button type="submit" :disabled="isSaving" class="px-xl py-sm bg-primary text-on-primary rounded-xl font-label-md hover:bg-surface-tint transition-all shadow-sm disabled:opacity-50 flex items-center gap-sm">
            <span v-if="isSaving" class="material-symbols-outlined animate-spin text-[18px]">progress_activity</span>
            Save Changes
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useAuthStore } from '~/stores/auth'

definePageMeta({ layout: 'provider', middleware: ['auth'] })

const authStore = useAuthStore()

const isSaving = ref(false)
const isFetching = ref(false)
const successMsg = ref('')
const errorMsg = ref('')

const profileForm = ref({
  title: '',
  hourly_rate: 50,
  bio: ''
})

const fetchProfile = async () => {
  isFetching.value = true
  try {
    // In our system, the profile data comes from authStore.user or we can fetch it explicitly.
    // If we had a GET /profile/consultant, we'd call it here. For now we populate from authStore.
    if (authStore.user?.consultant_profile) {
       profileForm.value.title = authStore.user.consultant_profile.title || ''
       profileForm.value.hourly_rate = authStore.user.consultant_profile.hourly_rate || 50
       profileForm.value.bio = authStore.user.consultant_profile.bio || ''
    }
  } catch (e: any) {
    console.error(e)
  } finally {
    isFetching.value = false
  }
}

const saveProfile = async () => {
  isSaving.value = true
  successMsg.value = ''
  errorMsg.value = ''
  try {
    await authStore.apiFetch('/profile/consultant', { method: 'POST', body: profileForm.value })
    successMsg.value = 'Professional profile updated successfully!'
    
    // Refresh auth store to get updated profile
    await authStore.fetchUser()
    
    setTimeout(() => successMsg.value = '', 4000)
  } catch (e: any) {
    console.error(e)
    errorMsg.value = e.data?.message || 'An error occurred while saving the profile.'
  } finally {
    isSaving.value = false
  }
}

onMounted(() => {
  fetchProfile()
})
</script>
