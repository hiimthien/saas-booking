<template>
  <div class="bg-surface text-on-surface font-body-md min-h-screen flex antialiased">
    <!-- Admin Sidebar -->
    <aside class="hidden md:flex bg-surface-container-low dark:bg-surface-container-highest border-r border-outline-variant flex-col h-screen w-64 fixed left-0 top-0 p-md gap-sm z-40 transition-transform duration-200 ease-in-out">
      <div class="flex items-center gap-sm mb-lg px-sm">
        <div class="w-10 h-10 rounded-lg bg-primary text-on-primary flex items-center justify-center font-bold text-headline-md shadow-sm">
          A
        </div>
        <div>
          <h1 class="font-headline-md text-headline-md text-on-surface">Admin Portal</h1>
          <p class="font-body-sm text-body-sm text-on-surface-variant">Platform Management</p>
        </div>
      </div>
      <nav class="flex flex-col gap-xs flex-1 overflow-y-auto">
        <NuxtLink to="/admin/dashboard" class="flex items-center gap-md px-md py-sm rounded-lg font-label-md text-label-md transition-all text-on-surface-variant hover:bg-surface-variant">
          <span class="material-symbols-outlined">dashboard</span>
          <span>Overview</span>
        </NuxtLink>
        <NuxtLink to="/admin/users" class="flex items-center gap-md px-md py-sm rounded-lg font-label-md text-label-md transition-all" :class="[ $route.path === '/admin/users' ? 'bg-primary-container text-on-primary-container font-bold' : 'text-on-surface-variant hover:bg-surface-variant' ]">
          <span class="material-symbols-outlined">group</span>
          <span>Users</span>
        </NuxtLink>
        <NuxtLink to="/admin/consultants" class="flex items-center gap-md px-md py-sm rounded-lg font-label-md text-label-md transition-all" :class="[ $route.path === '/admin/consultants' ? 'bg-primary-container text-on-primary-container font-bold' : 'text-on-surface-variant hover:bg-surface-variant' ]">
          <span class="material-symbols-outlined">badge</span>
          <span>Consultants</span>
        </NuxtLink>
        <NuxtLink to="/admin/settings" class="flex items-center gap-md px-md py-sm rounded-lg font-label-md text-label-md transition-all" :class="[ $route.path === '/admin/settings' ? 'bg-primary-container text-on-primary-container font-bold' : 'text-on-surface-variant hover:bg-surface-variant' ]">
          <span class="material-symbols-outlined">settings</span>
          <span>Settings</span>
        </NuxtLink>
      </nav>
      <div class="mt-auto pt-md border-t border-outline-variant">
        <button class="w-full flex items-center gap-md px-md py-sm rounded-lg font-label-md text-label-md text-on-surface-variant hover:bg-error-container hover:text-on-error-container transition-colors">
          <span class="material-symbols-outlined">logout</span>
          Logout
        </button>
      </div>
    </aside>

    <!-- Admin Main Content -->
    <main class="flex-1 ml-0 md:ml-64 flex flex-col min-h-screen w-full bg-surface-container-lowest">
      <!-- Admin TopBar -->
      <header class="sticky top-0 z-30 bg-surface/90 backdrop-blur-md border-b border-outline-variant shadow-sm flex justify-between items-center w-full px-lg py-sm">
        <div class="flex items-center gap-md lg:hidden">
          <button class="text-on-surface-variant p-sm rounded-full hover:bg-surface-variant transition-colors">
            <span class="material-symbols-outlined">menu</span>
          </button>
          <span class="font-headline-md text-headline-md text-primary font-bold">Admin</span>
        </div>
        <div class="hidden lg:flex items-center gap-md">
          <div class="relative">
            <span class="material-symbols-outlined absolute left-sm top-1/2 -translate-y-1/2 text-on-surface-variant text-[18px]">search</span>
            <input type="text" class="pl-xl pr-sm py-xs bg-surface-container-low border border-outline-variant rounded-lg text-body-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all w-80" placeholder="Search users, consultants, or settings..." >
          </div>
        </div>
        <div class="flex items-center gap-lg">
          <button class="text-on-surface-variant p-xs rounded-full hover:bg-surface-variant transition-colors relative">
            <span class="material-symbols-outlined">notifications</span>
            <span class="absolute top-xs right-xs w-2 h-2 bg-error rounded-full"/>
          </button>
          <button class="flex items-center gap-sm p-xs rounded-full hover:bg-surface-variant transition-colors">
            <img src="https://ui-avatars.com/api/?name=Admin&background=random" alt="Admin" class="w-8 h-8 rounded-full object-cover border border-outline-variant" >
            <span class="material-symbols-outlined text-on-surface-variant">arrow_drop_down</span>
          </button>
        </div>
      </header>

      <!-- Slot -->
      <slot />
    </main>
  </div>
</template>

<script setup lang="ts">
// Admin Layout
</script>
