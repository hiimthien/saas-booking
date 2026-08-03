<template>
  <header class="bg-surface dark:bg-inverse-surface border-b border-outline-variant dark:border-outline shadow-sm dark:shadow-none sticky top-0 z-50 flex justify-between items-center w-full px-lg py-sm max-w-container-max mx-auto">
    <div class="flex items-center gap-lg">
      <NuxtLink to="/" class="text-headline-md font-headline-md font-bold text-primary dark:text-primary-fixed">ConsultFlow</NuxtLink>
      <nav class="hidden md:flex gap-lg">
        <NuxtLink to="/search" class="text-primary dark:text-primary-fixed border-b-2 border-primary dark:border-primary-fixed pb-1 font-label-md text-label-md hover:text-primary dark:hover:text-primary-fixed transition-colors active:scale-95 duration-100">Explore</NuxtLink>
        <NuxtLink to="/search" class="text-on-surface-variant dark:text-surface-variant font-body-md font-label-md text-label-md hover:text-primary dark:hover:text-primary-fixed transition-colors active:scale-95 duration-100">How it works</NuxtLink>
      </nav>
    </div>
    <div class="flex items-center gap-md">
      <NuxtLink to="/login" class="hidden md:block border border-outline-variant rounded px-md py-sm font-label-md text-label-md text-on-surface hover:bg-surface-variant transition-colors">Login</NuxtLink>
      <NuxtLink to="/register" class="bg-primary text-on-primary rounded px-md py-sm font-label-md text-label-md hover:bg-primary-container hover:text-on-primary-container transition-colors">Sign Up</NuxtLink>
      <button class="p-xs text-on-surface-variant hover:text-primary transition-colors">
        <Component :is="Bell" class="w-6 h-6" />
      </button>
      <NuxtLink to="/provider/dashboard">
        <img alt="User profile" class="w-8 h-8 rounded-full object-cover border border-outline-variant ml-sm hover:ring-2 hover:ring-primary transition-all" src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=150&q=80" >
      </NuxtLink>
    </div>
  </header>
</template>

<script setup lang="ts">
import { Bell } from 'lucide-vue-next'
</script>
