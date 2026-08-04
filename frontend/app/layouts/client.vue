<template>
  <div class="flex h-screen overflow-hidden bg-background">
    <!-- Mobile Overlay -->
    <div v-if="isMobileMenuOpen" class="fixed inset-0 bg-on-surface/20 backdrop-blur-sm z-30 md:hidden transition-opacity" @click="isMobileMenuOpen = false"/>

    <!-- SideNavBar -->
    <nav :class="['bg-surface-container-low border-r border-outline-variant w-64 flex flex-col h-full p-md gap-sm fixed md:relative z-40 transition-transform duration-300 ease-in-out md:translate-x-0', isMobileMenuOpen ? 'translate-x-0' : '-translate-x-full']">
      <div class="flex items-center justify-between mb-lg px-sm">
        <div class="flex items-center gap-sm">
          <span class="material-symbols-outlined text-primary text-headline-md">dataset</span>
          <div>
            <h2 class="font-headline-md text-primary font-bold">ConsultFlow</h2>
            <p class="font-body-sm text-on-surface-variant">Client Portal</p>
          </div>
        </div>
      </div>
      
      <nav class="flex flex-col gap-xs flex-1" @click="isMobileMenuOpen = false">
        <NuxtLink to="/client/dashboard" class="flex items-center gap-sm px-sm py-sm text-on-surface-variant hover:bg-surface-variant rounded-lg transition-all font-label-md" exact-active-class="bg-secondary-container text-on-secondary-container font-bold">
          <span class="material-symbols-outlined">dashboard</span>
          My Bookings
        </NuxtLink>
        <NuxtLink to="/client/favorites" class="flex items-center gap-sm px-sm py-sm text-on-surface-variant hover:bg-surface-variant rounded-lg transition-all font-label-md" active-class="bg-secondary-container text-on-secondary-container font-bold">
          <span class="material-symbols-outlined">bookmarks</span>
          Favorites
        </NuxtLink>
        <NuxtLink to="/client/profile" class="flex items-center gap-sm px-sm py-sm text-on-surface-variant hover:bg-surface-variant rounded-lg transition-all font-label-md" active-class="bg-secondary-container text-on-secondary-container font-bold">
          <span class="material-symbols-outlined">settings</span>
          Profile & Billing
        </NuxtLink>
      </nav>
      
      <div class="mt-auto pt-md flex flex-col gap-sm">
        <UiButton to="/" block variant="primary">
          <span class="material-symbols-outlined text-sm">search</span>
          Find Experts
        </UiButton>
        <button @click="handleLogout" class="flex items-center justify-center gap-sm px-sm py-sm text-error hover:bg-error-container hover:text-on-error-container rounded-lg transition-all font-label-md w-full">
          <span class="material-symbols-outlined">logout</span>
          Logout
        </button>
      </div>
    </nav>

    <!-- Main Content Canvas -->
    <main class="flex-1 overflow-y-auto bg-surface-bright flex flex-col min-h-screen">
      <!-- Mobile Top Bar -->
      <header class="md:hidden bg-surface-container-lowest border-b border-outline-variant sticky top-0 z-20 px-lg py-sm flex items-center gap-sm h-16">
        <button class="p-xs text-on-surface-variant hover:text-primary transition-colors" @click="isMobileMenuOpen = true">
          <span class="material-symbols-outlined">menu</span>
        </button>
        <span class="font-headline-md text-primary">ConsultFlow</span>
      </header>

      <div class="max-w-container-max mx-auto w-full flex-1 p-lg md:p-xl">
        <slot />
      </div>
    </main>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useAuthStore } from '~/stores/auth'

const isMobileMenuOpen = ref(false)
const authStore = useAuthStore()

const handleLogout = async () => {
  await authStore.logout()
}
</script>
