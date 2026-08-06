<template>
  <div class="bg-background text-on-background min-h-screen flex antialiased font-body-lg">
    <!-- Mobile Overlay -->
    <div v-if="isMobileMenuOpen" class="fixed inset-0 bg-on-surface/20 backdrop-blur-sm z-30 md:hidden transition-opacity" @click="isMobileMenuOpen = false"/>
    
    <!-- SideNavBar -->
    <aside :class="['bg-surface-container-low border-r border-outline-variant flex flex-col h-screen w-64 fixed left-0 top-0 p-md gap-sm z-40 transition-transform duration-300 ease-in-out md:translate-x-0', isMobileMenuOpen ? 'translate-x-0' : '-translate-x-full']">
      <div class="flex items-center justify-between gap-sm mb-lg px-sm">
        <div class="flex items-center gap-sm">
          <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-on-primary font-bold">CF</div>
          <div>
            <h1 class="font-headline-md text-headline-md text-primary">Provider Hub</h1>
            <p class="font-body-sm text-body-sm text-on-surface-variant">Manage Consultations</p>
          </div>
        </div>
      </div>
      <nav class="flex flex-col gap-xs flex-1 overflow-y-auto" @click="isMobileMenuOpen = false">
        <NuxtLink to="/provider/dashboard" class="flex items-center gap-md px-md py-sm rounded-lg transition-all text-on-surface-variant hover:bg-surface-variant font-label-md" exact-active-class="bg-secondary-container text-on-secondary-container font-bold">
          <LayoutDashboard class="w-5 h-5" />
          <span>Dashboard</span>
        </NuxtLink>
        <NuxtLink to="/provider/calendar" class="flex items-center gap-md px-md py-sm text-on-surface-variant hover:bg-surface-variant rounded-lg font-label-md transition-all" exact-active-class="bg-secondary-container text-on-secondary-container font-bold">
          <CalendarDays class="w-5 h-5" />
          <span>Calendar</span>
        </NuxtLink>
        <NuxtLink to="/provider/profile-setup" class="flex items-center gap-md px-md py-sm text-on-surface-variant hover:bg-surface-variant rounded-lg font-label-md transition-all" exact-active-class="bg-secondary-container text-on-secondary-container font-bold">
          <Briefcase class="w-5 h-5" />
          <span>Profile & Services</span>
        </NuxtLink>
        <NuxtLink to="/provider/earnings" class="flex items-center gap-md px-md py-sm text-on-surface-variant hover:bg-surface-variant rounded-lg font-label-md transition-all" exact-active-class="bg-secondary-container text-on-secondary-container font-bold">
          <CircleDollarSign class="w-5 h-5" />
          <span>Earnings</span>
        </NuxtLink>
        
        <div class="mt-md pt-md border-t border-outline-variant flex flex-col gap-xs">
          <span class="px-md font-label-sm text-on-surface-variant uppercase tracking-wider">Admin</span>
          <NuxtLink to="/admin/consultants" class="flex items-center gap-md px-md py-sm text-on-surface-variant hover:bg-surface-variant rounded-lg font-label-md transition-all" exact-active-class="bg-error-container text-error font-bold">
            <Users class="w-5 h-5" />
            <span>Approvals</span>
          </NuxtLink>
          <NuxtLink to="/admin/users" class="flex items-center gap-md px-md py-sm text-on-surface-variant hover:bg-surface-variant rounded-lg font-label-md transition-all" exact-active-class="bg-error-container text-error font-bold">
            <Shield class="w-5 h-5" />
            <span>Users</span>
          </NuxtLink>
          <NuxtLink to="/admin/settings" class="flex items-center gap-md px-md py-sm text-on-surface-variant hover:bg-surface-variant rounded-lg font-label-md transition-all" exact-active-class="bg-error-container text-error font-bold">
            <Settings class="w-5 h-5" />
            <span>Settings</span>
          </NuxtLink>
        </div>
      </nav>
      <div class="mt-auto">
        <UiBaseButton block variant="primary">
          <Plus class="w-5 h-5" />
          New Service
        </UiBaseButton>
      </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 ml-0 md:ml-64 flex flex-col min-h-screen">
      <!-- Top Utility Bar -->
      <header class="bg-surface-container-lowest border-b border-outline-variant sticky top-0 z-30 px-lg py-sm flex justify-between items-center h-16">
        <div class="md:hidden flex items-center gap-sm">
          <button class="p-xs text-on-surface-variant hover:text-primary transition-colors" @click="isMobileMenuOpen = true"><Menu class="w-6 h-6" /></button>
          <span class="font-headline-md text-primary">Provider Hub</span>
        </div>
        <div class="hidden md:flex items-center flex-1">
          <h2 class="font-headline-md text-on-surface">Overview</h2>
        </div>
        <div class="flex items-center gap-md">
          <button class="p-xs text-on-surface-variant hover:text-primary transition-colors relative">
            <Bell class="w-6 h-6" />
            <span class="absolute top-1 right-1 w-2 h-2 bg-error rounded-full"/>
          </button>
          <div class="w-8 h-8 rounded-full bg-surface-variant overflow-hidden border border-outline-variant">
            <img src="https://i.pravatar.cc/150?u=sarah" alt="Provider" >
          </div>
        </div>
      </header>

      <div class="flex-1 p-margin-mobile md:p-gutter bg-background overflow-x-hidden">
        <slot />
      </div>
    </main>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { LayoutDashboard, CalendarDays, Briefcase, CircleDollarSign, Plus, Menu, Bell, Users, Shield, Settings } from 'lucide-vue-next'

const isMobileMenuOpen = ref(false)
</script>
