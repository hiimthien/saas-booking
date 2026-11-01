<template>
  <div class="bg-background text-on-background font-body-lg min-h-screen flex antialiased">
    <!-- Mobile Overlay -->
    <div v-if="isSidebarOpen" @click="isSidebarOpen = false" class="fixed inset-0 bg-black/50 z-30 md:hidden transition-opacity"></div>

    <!-- SideNavBar -->
    <aside class="bg-surface-container-low dark:bg-surface-container-highest border-r border-outline-variant flex-col h-screen w-64 fixed left-0 top-0 p-md gap-sm z-40 transition-transform duration-300 ease-in-out md:translate-x-0 flex" :class="isSidebarOpen ? 'translate-x-0' : '-translate-x-full'">
      <div class="flex items-center gap-sm mb-lg px-sm">
        <img v-if="authStore.user?.avatar_url" :src="backendUrl(authStore.user.avatar_url)" class="w-10 h-10 rounded-full object-cover shadow-sm" >
        <div v-else class="w-10 h-10 rounded-full bg-primary text-on-primary flex items-center justify-center font-headline-sm shadow-sm">
          {{ authStore.user?.name?.charAt(0).toUpperCase() }}
        </div>
        <div>
          <h1 class="font-headline-md text-headline-md text-primary truncate max-w-[150px]">{{ authStore.user?.name }}</h1>
          <p class="font-body-sm text-body-sm text-on-surface-variant">Provider Hub</p>
        </div>
      </div>
      <nav class="flex flex-col gap-xs flex-1 overflow-y-auto">
        <NuxtLink to="/provider/dashboard" class="flex items-center gap-md px-md py-sm rounded-lg font-label-md text-label-md transition-all" :class="[ $route.path === '/provider/dashboard' ? 'bg-secondary-container text-on-secondary-container font-bold' : 'text-on-surface-variant hover:bg-surface-variant' ]">
          <span class="material-symbols-outlined">dashboard</span>
          <span>Dashboard</span>
        </NuxtLink>
        <NuxtLink to="/provider/calendar" class="flex items-center gap-md px-md py-sm rounded-lg font-label-md text-label-md transition-all" :class="[ $route.path === '/provider/calendar' ? 'bg-secondary-container text-on-secondary-container font-bold' : 'text-on-surface-variant hover:bg-surface-variant' ]">
          <span class="material-symbols-outlined">calendar_month</span>
          <span>Calendar</span>
        </NuxtLink>
        <NuxtLink to="/provider/bookings" class="flex items-center gap-md px-md py-sm rounded-lg font-label-md text-label-md transition-all" :class="[ $route.path === '/provider/bookings' ? 'bg-secondary-container text-on-secondary-container font-bold' : 'text-on-surface-variant hover:bg-surface-variant' ]">
          <span class="material-symbols-outlined">event_upcoming</span>
          <span>Bookings</span>
        </NuxtLink>
        <NuxtLink to="/provider/profile" class="flex items-center gap-md px-md py-sm rounded-lg font-label-md text-label-md transition-all" :class="[ $route.path === '/provider/profile' ? 'bg-secondary-container text-on-secondary-container font-bold' : 'text-on-surface-variant hover:bg-surface-variant' ]">
          <span class="material-symbols-outlined">badge</span>
          <span>Profile Setup</span>
        </NuxtLink>
        <NuxtLink to="/provider/earnings" class="flex items-center gap-md px-md py-sm rounded-lg font-label-md text-label-md transition-all" :class="[ $route.path === '/provider/earnings' ? 'bg-secondary-container text-on-secondary-container font-bold' : 'text-on-surface-variant hover:bg-surface-variant' ]">
          <span class="material-symbols-outlined">payments</span>
          <span>Earnings</span>
        </NuxtLink>
      </nav>
      <div class="mt-auto flex flex-col gap-sm">
        <button class="w-full bg-primary hover:bg-primary-container text-on-primary hover:text-on-primary-container font-label-md text-label-md py-sm rounded-lg shadow-sm transition-colors flex items-center justify-center gap-sm">
          <span class="material-symbols-outlined">add</span>
          Book New Service
        </button>
        <button @click="handleLogout" class="w-full flex items-center justify-center gap-md px-md py-sm rounded-lg font-label-md text-label-md text-error hover:bg-error-container hover:text-on-error-container transition-colors">
          <span class="material-symbols-outlined">logout</span>
          Logout
        </button>
      </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 ml-0 md:ml-64 flex flex-col min-h-screen w-full">
      <!-- TopAppBar -->
      <header class="sticky top-0 z-30 bg-surface dark:bg-inverse-surface border-b border-outline-variant shadow-sm flex justify-between items-center w-full px-lg py-sm">
        <div class="flex items-center gap-md lg:hidden">
          <button @click="isSidebarOpen = !isSidebarOpen" class="text-on-surface-variant p-sm rounded-full hover:bg-surface-variant transition-colors">
            <span class="material-symbols-outlined">menu</span>
          </button>
          <span class="font-headline-md text-headline-md text-primary font-bold">ConsultFlow</span>
        </div>
        <div class="hidden lg:flex items-center gap-md">
          <div class="relative">
            <span class="material-symbols-outlined absolute left-sm top-1/2 -translate-y-1/2 text-on-surface-variant text-[18px]">search</span>
            <input type="text" class="pl-xl pr-sm py-xs bg-surface-container-low border border-outline-variant rounded-lg text-body-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all w-64" placeholder="Search sessions..." >
          </div>
        </div>
        <div class="flex items-center gap-lg">
          <div class="flex items-center gap-sm hidden sm:flex bg-surface-container-high px-sm py-xs rounded-full">
            <span class="font-label-sm text-label-sm text-on-surface-variant">Availability</span>
            <label class="relative inline-flex items-center cursor-pointer">
              <input type="checkbox" value="" class="sr-only peer" checked>
              <div class="w-9 h-5 bg-outline-variant peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary"/>
            </label>
          </div>
          <div class="flex items-center gap-sm">
            <NuxtLink to="/messages" class="text-on-surface-variant p-xs rounded-full hover:bg-surface-variant transition-colors relative" title="Messages">
              <span class="material-symbols-outlined">chat</span>
            </NuxtLink>
            <NuxtLink to="/notifications" class="text-on-surface-variant p-xs rounded-full hover:bg-surface-variant transition-colors relative" title="Notifications">
              <span class="material-symbols-outlined">notifications</span>
              <span class="absolute top-xs right-xs w-2 h-2 bg-error rounded-full"/>
            </NuxtLink>
            <button class="flex items-center gap-sm p-xs rounded-full hover:bg-surface-variant transition-colors">
              <img v-if="authStore.user?.avatar_url" :src="backendUrl(authStore.user.avatar_url)" class="w-8 h-8 rounded-full object-cover border border-outline-variant" >
              <div v-else class="w-8 h-8 rounded-full bg-primary text-on-primary flex items-center justify-center font-label-md">
                {{ authStore.user?.name?.charAt(0).toUpperCase() }}
              </div>
              <span class="material-symbols-outlined text-on-surface-variant">arrow_drop_down</span>
            </button>
          </div>
        </div>
      </header>

      <!-- Slot Content -->
      <slot />
    </main>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useAuthStore } from '~/stores/auth'
import { useRuntimeConfig } from '#app'
import { useRouter, useRoute } from 'vue-router'

const authStore = useAuthStore()
const config = useRuntimeConfig()
const router = useRouter()
const route = useRoute()

const isSidebarOpen = ref(false)

// Close sidebar on route change (for mobile)
watch(() => route.path, () => {
  isSidebarOpen.value = false
})

const backendUrl = (path: string | undefined) => {
  if (!path) return ''
  if (path.startsWith('http')) return path
  const base = (config.public.apiBase as string).replace('/api', '')
  return `${base}${path}`
}

const handleLogout = async () => {
  await authStore.logout()
  router.push('/login')
}
</script>
