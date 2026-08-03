<template>
  <div class="bg-background text-on-background min-h-screen flex flex-col font-body-md">
    <Header />
    <main class="flex-grow">
      <slot />
    </main>
    <!-- Mega Footer -->
    <footer class="bg-inverse-surface text-inverse-on-surface pt-3xl pb-xl px-margin-mobile md:px-gutter mt-auto">
      <div class="max-w-container-max mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-xl mb-2xl">
          <!-- Brand Column -->
          <div class="lg:col-span-2">
            <NuxtLink to="/" class="font-headline-md font-bold text-inverse-primary flex items-center gap-sm mb-md">
              <span class="material-symbols-outlined">dataset</span>
              ConsultFlow
            </NuxtLink>
            <p class="font-body-sm text-surface-dim max-w-[300px] mb-lg">
              The modern operating system for professional expertise. Built for high-performing teams and independent consultants alike.
            </p>
            <!-- Language Selector -->
            <div class="inline-flex items-center gap-xs px-sm py-xs bg-on-surface/10 rounded-lg cursor-pointer hover:bg-on-surface/20 transition-colors">
              <span class="material-symbols-outlined text-[18px]">language</span>
              <span class="font-label-md">English (US)</span>
              <span class="material-symbols-outlined text-[18px]">expand_more</span>
            </div>
          </div>
          
          <!-- Links Columns -->
          <div>
            <h4 class="font-label-md text-surface-container-highest uppercase tracking-wider mb-md">Product</h4>
            <ul class="flex flex-col gap-sm">
              <li><NuxtLink to="#" class="font-body-sm text-surface-dim hover:text-inverse-primary transition-colors">Features</NuxtLink></li>
              <li><NuxtLink to="#" class="font-body-sm text-surface-dim hover:text-inverse-primary transition-colors">Pricing</NuxtLink></li>
              <li><NuxtLink to="#" class="font-body-sm text-surface-dim hover:text-inverse-primary transition-colors">Enterprise</NuxtLink></li>
              <li><NuxtLink to="#" class="font-body-sm text-surface-dim hover:text-inverse-primary transition-colors">Security</NuxtLink></li>
            </ul>
          </div>
          <div>
            <h4 class="font-label-md text-surface-container-highest uppercase tracking-wider mb-md">Resources</h4>
            <ul class="flex flex-col gap-sm">
              <li><NuxtLink to="#" class="font-body-sm text-surface-dim hover:text-inverse-primary transition-colors">Documentation</NuxtLink></li>
              <li><NuxtLink to="#" class="font-body-sm text-surface-dim hover:text-inverse-primary transition-colors">API Reference</NuxtLink></li>
              <li><NuxtLink to="#" class="font-body-sm text-surface-dim hover:text-inverse-primary transition-colors">Blog</NuxtLink></li>
              <li><NuxtLink to="#" class="font-body-sm text-surface-dim hover:text-inverse-primary transition-colors">Community</NuxtLink></li>
            </ul>
          </div>
          <div>
            <h4 class="font-label-md text-surface-container-highest uppercase tracking-wider mb-md">Company</h4>
            <ul class="flex flex-col gap-sm">
              <li><NuxtLink to="#" class="font-body-sm text-surface-dim hover:text-inverse-primary transition-colors">About Us</NuxtLink></li>
              <li><NuxtLink to="#" class="font-body-sm text-surface-dim hover:text-inverse-primary transition-colors">Careers</NuxtLink></li>
              <li><NuxtLink to="#" class="font-body-sm text-surface-dim hover:text-inverse-primary transition-colors">Contact</NuxtLink></li>
              <li><NuxtLink to="#" class="font-body-sm text-surface-dim hover:text-inverse-primary transition-colors">Partners</NuxtLink></li>
            </ul>
          </div>
        </div>
        
        <!-- Bottom Bar -->
        <div class="pt-lg border-t border-outline/30 flex flex-col md:flex-row justify-between items-center gap-md">
          <p class="font-body-sm text-surface-dim">© 2024 ConsultFlow Inc. All rights reserved.</p>
          <div class="flex items-center gap-lg">
            <NuxtLink to="#" class="font-body-sm text-surface-dim hover:text-inverse-primary transition-colors">Privacy Policy</NuxtLink>
            <NuxtLink to="#" class="font-body-sm text-surface-dim hover:text-inverse-primary transition-colors">Terms of Service</NuxtLink>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup lang="ts">
import Header from '~/components/Header.vue'
</script>
