<template>
  <div class="max-w-container-max mx-auto w-full px-margin-mobile md:px-gutter py-lg md:py-xl flex flex-col md:flex-row gap-lg">
    <!-- Mobile Filter Toggle -->
    <div class="md:hidden mb-4 flex justify-between items-center w-full">
      <h1 class="font-headline-lg-mobile text-on-surface">Explore Consultants</h1>
      <button class="flex items-center gap-xs text-primary font-label-md px-3 py-2 border border-outline-variant rounded-lg bg-surface-container-low">
        <span class="material-symbols-outlined text-sm">tune</span>
        Filters
      </button>
    </div>

    <!-- Sidebar Filters -->
    <aside class="hidden md:block w-full md:w-64 lg:w-72 flex-shrink-0">
      <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-md shadow-sm sticky top-24">
        <div class="flex justify-between items-center mb-md border-b border-outline-variant pb-sm">
          <h2 class="font-headline-md text-on-surface">Filters</h2>
          <button class="text-body-sm text-primary hover:underline">Clear all</button>
        </div>

        <!-- Availability Filter -->
        <div class="mb-lg border-b border-outline-variant pb-md">
          <h3 class="font-label-md text-on-surface mb-sm">Availability</h3>
          <div class="space-y-2">
            <label class="flex items-center gap-sm cursor-pointer group">
              <input type="checkbox" class="rounded border-outline-variant text-primary focus:ring-primary w-4 h-4" >
              <span class="font-body-sm text-on-surface-variant group-hover:text-on-surface">Available Today</span>
            </label>
            <label class="flex items-center gap-sm cursor-pointer group">
              <input type="checkbox" class="rounded border-outline-variant text-primary focus:ring-primary w-4 h-4" >
              <span class="font-body-sm text-on-surface-variant group-hover:text-on-surface">This Week</span>
            </label>
            <label class="flex items-center gap-sm cursor-pointer group">
              <input type="checkbox" class="rounded border-outline-variant text-primary focus:ring-primary w-4 h-4" >
              <span class="font-body-sm text-on-surface-variant group-hover:text-on-surface">Weekends</span>
            </label>
          </div>
        </div>

        <!-- Price Range Filter -->
        <div class="mb-lg border-b border-outline-variant pb-md">
          <h3 class="font-label-md text-on-surface mb-sm">Hourly Rate</h3>
          <div class="flex items-center gap-sm mt-4">
            <div class="flex-1 relative">
              <span class="absolute left-2 top-1/2 -translate-y-1/2 text-on-surface-variant text-body-sm">$</span>
              <input type="number" placeholder="Min" class="w-full pl-6 pr-2 py-1.5 bg-surface-container-low border border-outline-variant rounded-lg text-body-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary" >
            </div>
            <span class="text-on-surface-variant">-</span>
            <div class="flex-1 relative">
              <span class="absolute left-2 top-1/2 -translate-y-1/2 text-on-surface-variant text-body-sm">$</span>
              <input type="number" placeholder="Max" class="w-full pl-6 pr-2 py-1.5 bg-surface-container-low border border-outline-variant rounded-lg text-body-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary" >
            </div>
          </div>
        </div>

        <!-- Rating Filter -->
        <div class="mb-md">
          <h3 class="font-label-md text-on-surface mb-sm">Minimum Rating</h3>
          <div class="space-y-2">
            <label class="flex items-center justify-between cursor-pointer group">
              <div class="flex items-center gap-sm">
                <input type="radio" name="rating" class="border-outline-variant text-primary focus:ring-primary w-4 h-4" >
                <div class="flex text-amber-500">
                  <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                  <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                  <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                  <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                  <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                </div>
              </div>
              <span class="font-body-sm text-on-surface-variant">5.0</span>
            </label>
            <label class="flex items-center justify-between cursor-pointer group">
              <div class="flex items-center gap-sm">
                <input type="radio" name="rating" checked class="border-outline-variant text-primary focus:ring-primary w-4 h-4" >
                <div class="flex text-amber-500">
                  <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                  <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                  <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                  <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                  <span class="material-symbols-outlined text-sm text-outline-variant">star_border</span>
                </div>
              </div>
              <span class="font-body-sm text-on-surface-variant">4.0 & Up</span>
            </label>
          </div>
        </div>
      </div>
    </aside>

    <!-- Search Results & Sorting -->
    <div class="flex-1 flex flex-col">
      <!-- Results Header & Sort -->
      <div class="hidden md:flex justify-between items-end mb-lg">
        <div>
          <h1 class="font-headline-lg text-on-surface">Explore Consultants</h1>
          <p class="font-body-sm text-on-surface-variant mt-1">Showing 142 results for "Marketing Strategy"</p>
        </div>
        <div class="flex items-center gap-sm">
          <span class="font-label-sm text-on-surface-variant uppercase tracking-wider">Sort by:</span>
          <select class="bg-surface-container-lowest border border-outline-variant rounded-lg text-body-sm text-on-surface py-1.5 pl-3 pr-8 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary cursor-pointer">
            <option>Recommended</option>
            <option>Highest Rated</option>
            <option>Price: Low to High</option>
            <option>Price: High to Low</option>
          </select>
        </div>
      </div>

      <!-- Mobile Results Header -->
      <p class="md:hidden font-body-sm text-on-surface-variant mb-4">142 results for "Marketing Strategy"</p>

      <!-- Results Grid -->
      <div class="grid grid-cols-1 xl:grid-cols-2 gap-md md:gap-lg mb-xl">
        <!-- Consultant Card 1 -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-md shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between group">
          <div class="flex gap-md mb-md">
            <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-surface-container flex-shrink-0">
              <img src="https://ui-avatars.com/api/?name=Sarah+Jenkins&background=random" alt="Sarah Jenkins" class="w-full h-full object-cover" >
            </div>
            <div class="flex-1 min-w-0">
              <div class="flex justify-between items-start">
                <div>
                  <NuxtLink to="/consultants/1" class="font-headline-md text-on-surface truncate group-hover:text-primary transition-colors">Sarah Jenkins</NuxtLink>
                  <p class="font-body-sm text-on-surface-variant truncate">Growth Marketing Specialist</p>
                </div>
                <div class="text-right flex-shrink-0">
                  <p class="font-headline-md text-on-surface">$150<span class="font-body-sm text-on-surface-variant font-normal">/hr</span></p>
                </div>
              </div>
              <div class="flex items-center gap-xs mt-1">
                <span class="material-symbols-outlined text-amber-500 text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                <span class="font-label-sm text-on-surface">4.9</span>
                <span class="font-body-sm text-on-surface-variant">(124 reviews)</span>
              </div>
            </div>
          </div>
          <div class="mb-md">
            <div class="flex flex-wrap gap-xs">
              <span class="bg-surface-container-low text-on-surface-variant font-label-sm px-2 py-1 rounded-full">B2B SaaS</span>
              <span class="bg-surface-container-low text-on-surface-variant font-label-sm px-2 py-1 rounded-full">User Acquisition</span>
              <span class="bg-surface-container-low text-on-surface-variant font-label-sm px-2 py-1 rounded-full">SEO</span>
            </div>
          </div>
          <div class="flex gap-sm mt-auto pt-sm border-t border-outline-variant">
            <NuxtLink to="/consultants/1" class="flex-1 text-center font-label-md text-on-surface bg-surface-container-lowest border border-outline-variant py-2 rounded-lg hover:bg-surface-variant transition-colors">View Profile</NuxtLink>
            <NuxtLink to="/checkout" class="flex-1 text-center font-label-md text-on-primary bg-primary py-2 rounded-lg hover:bg-surface-tint hover:shadow-md transition-all">Quick Book</NuxtLink>
          </div>
        </div>

        <!-- Consultant Card 2 -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-md shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between group">
          <div class="flex gap-md mb-md">
            <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-surface-container flex-shrink-0">
              <img src="https://ui-avatars.com/api/?name=David+Chen&background=random" alt="David Chen" class="w-full h-full object-cover" >
            </div>
            <div class="flex-1 min-w-0">
              <div class="flex justify-between items-start">
                <div>
                  <NuxtLink to="/consultants/2" class="font-headline-md text-on-surface truncate group-hover:text-primary transition-colors">David Chen</NuxtLink>
                  <p class="font-body-sm text-on-surface-variant truncate">Brand Strategy Director</p>
                </div>
                <div class="text-right flex-shrink-0">
                  <p class="font-headline-md text-on-surface">$200<span class="font-body-sm text-on-surface-variant font-normal">/hr</span></p>
                </div>
              </div>
              <div class="flex items-center gap-xs mt-1">
                <span class="material-symbols-outlined text-amber-500 text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                <span class="font-label-sm text-on-surface">5.0</span>
                <span class="font-body-sm text-on-surface-variant">(89 reviews)</span>
              </div>
            </div>
          </div>
          <div class="mb-md">
            <div class="flex flex-wrap gap-xs">
              <span class="bg-surface-container-low text-on-surface-variant font-label-sm px-2 py-1 rounded-full">Rebranding</span>
              <span class="bg-surface-container-low text-on-surface-variant font-label-sm px-2 py-1 rounded-full">Positioning</span>
              <span class="bg-surface-container-low text-on-surface-variant font-label-sm px-2 py-1 rounded-full">Market Entry</span>
            </div>
          </div>
          <div class="flex gap-sm mt-auto pt-sm border-t border-outline-variant">
            <NuxtLink to="/consultants/2" class="flex-1 text-center font-label-md text-on-surface bg-surface-container-lowest border border-outline-variant py-2 rounded-lg hover:bg-surface-variant transition-colors">View Profile</NuxtLink>
            <NuxtLink to="/checkout" class="flex-1 text-center font-label-md text-on-primary bg-primary py-2 rounded-lg hover:bg-surface-tint hover:shadow-md transition-all">Quick Book</NuxtLink>
          </div>
        </div>
      </div>

      <!-- Pagination -->
      <div class="flex justify-center items-center gap-sm mt-auto">
        <button class="w-8 h-8 flex items-center justify-center rounded-lg text-on-surface-variant hover:bg-surface-variant border border-transparent disabled:opacity-50" disabled>
          <span class="material-symbols-outlined text-sm">chevron_left</span>
        </button>
        <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-primary text-on-primary font-label-sm">1</button>
        <button class="w-8 h-8 flex items-center justify-center rounded-lg text-on-surface hover:bg-surface-variant border border-outline-variant font-label-sm">2</button>
        <button class="w-8 h-8 flex items-center justify-center rounded-lg text-on-surface hover:bg-surface-variant border border-outline-variant font-label-sm">3</button>
        <span class="text-on-surface-variant">...</span>
        <button class="w-8 h-8 flex items-center justify-center rounded-lg text-on-surface hover:bg-surface-variant border border-outline-variant font-label-sm">12</button>
        <button class="w-8 h-8 flex items-center justify-center rounded-lg text-on-surface-variant hover:bg-surface-variant border border-transparent">
          <span class="material-symbols-outlined text-sm">chevron_right</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
// Page logic
</script>
