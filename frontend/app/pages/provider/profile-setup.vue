<template>
  <div class="p-margin-mobile md:p-lg xl:p-xl w-full flex-1 mb-2xl">
    <!-- Header Section -->
    <div class="mb-xl flex flex-col gap-xs">
      <h2 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface mb-xs">Profile Setup</h2>
      <p class="font-body-md text-body-md text-on-surface-variant">Configure your consultant profile, services, and availability to start receiving bookings.</p>
    </div>

    <!-- Tab Navigation -->
    <div class="border-b border-outline-variant mb-xl overflow-x-auto hide-scrollbar">
      <ul class="flex space-x-lg w-max min-w-full">
        <li>
          <a class="block py-3 border-b-2 border-primary text-primary font-label-md text-label-md whitespace-nowrap" href="#">Basic Info</a>
        </li>
        <li>
          <a class="block py-3 border-b-2 border-transparent text-on-surface-variant hover:text-primary transition-colors font-label-md text-label-md whitespace-nowrap" href="#">Specialties</a>
        </li>
        <li>
          <a class="block py-3 border-b-2 border-transparent text-on-surface-variant hover:text-primary transition-colors font-label-md text-label-md whitespace-nowrap" href="#">Pricing</a>
        </li>
        <li>
          <a class="block py-3 border-b-2 border-transparent text-on-surface-variant hover:text-primary transition-colors font-label-md text-label-md whitespace-nowrap" href="#">Availability</a>
        </li>
      </ul>
    </div>

    <!-- Bento Grid Layout for Content -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-lg">
      <!-- Left Column: Main Form -->
      <div class="lg:col-span-8 space-y-lg">
        <!-- Basic Info Card -->
        <UiBaseCard class="p-lg">
          <h3 class="font-headline-md text-headline-md text-on-surface mb-md">Personal Details</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-md mb-md">
            <div>
              <label class="block font-label-sm text-label-sm text-on-surface-variant uppercase mb-xs">First Name</label>
              <UiBaseInput placeholder="Jane" />
            </div>
            <div>
              <label class="block font-label-sm text-label-sm text-on-surface-variant uppercase mb-xs">Last Name</label>
              <UiBaseInput placeholder="Doe" />
            </div>
          </div>
          <div class="mb-md">
            <label class="block font-label-sm text-label-sm text-on-surface-variant uppercase mb-xs">Professional Title</label>
            <UiBaseInput placeholder="e.g. Senior Business Strategist" />
          </div>
          <div class="mb-md">
            <label class="block font-label-sm text-label-sm text-on-surface-variant uppercase mb-xs">Bio / Overview</label>
            <textarea class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg p-3 font-body-md text-body-md focus:border-secondary focus:ring-1 focus:ring-secondary outline-none transition-shadow resize-none" rows="4" placeholder="Briefly describe your expertise and how you help clients..."/>
          </div>
        </UiBaseCard>

        <!-- Availability Configurator Widget -->
        <UiBaseCard class="p-lg">
          <div class="flex items-center justify-between mb-md">
            <h3 class="font-headline-md text-headline-md text-on-surface">Default Weekly Availability</h3>
            <span class="material-symbols-outlined text-on-surface-variant">schedule</span>
          </div>
          <p class="font-body-sm text-body-sm text-on-surface-variant mb-lg">Set your standard working hours. You can adjust specific dates later in the Calendar tab.</p>
          
          <div class="space-y-md">
            <!-- Monday -->
            <div class="flex flex-col sm:flex-row sm:items-center gap-md p-md bg-surface border border-outline-variant rounded-lg">
              <div class="w-32 flex items-center gap-sm">
                <input type="checkbox" checked class="rounded text-primary focus:ring-primary h-5 w-5" >
                <span class="font-label-md text-label-md text-on-surface">Monday</span>
              </div>
              <div class="flex-1 grid grid-cols-2 gap-sm">
                <UiBaseInput type="time" model-value="09:00" />
                <UiBaseInput type="time" model-value="17:00" />
              </div>
              <button class="text-on-surface-variant hover:text-error transition-colors">
                <span class="material-symbols-outlined text-sm">delete</span>
              </button>
            </div>
            
            <!-- Tuesday -->
            <div class="flex flex-col sm:flex-row sm:items-center gap-md p-md bg-surface border border-outline-variant rounded-lg">
              <div class="w-32 flex items-center gap-sm">
                <input type="checkbox" checked class="rounded text-primary focus:ring-primary h-5 w-5" >
                <span class="font-label-md text-label-md text-on-surface">Tuesday</span>
              </div>
              <div class="flex-1 grid grid-cols-2 gap-sm">
                <UiBaseInput type="time" model-value="09:00" />
                <UiBaseInput type="time" model-value="17:00" />
              </div>
              <button class="text-on-surface-variant hover:text-error transition-colors">
                <span class="material-symbols-outlined text-sm">delete</span>
              </button>
            </div>

            <!-- Wednesday -->
            <div class="flex flex-col sm:flex-row sm:items-center gap-md p-md bg-surface border border-outline-variant rounded-lg opacity-60">
              <div class="w-32 flex items-center gap-sm">
                <input type="checkbox" class="rounded text-primary focus:ring-primary h-5 w-5" >
                <span class="font-label-md text-label-md text-on-surface line-through">Wednesday</span>
              </div>
              <div class="flex-1 text-on-surface-variant font-body-sm text-body-sm italic">
                Unavailable
              </div>
            </div>
          </div>
        </UiBaseCard>
      </div>

      <!-- Right Column: Profile Preview / Status -->
      <div class="lg:col-span-4 space-y-lg">
        <!-- Profile Photo Upload -->
        <UiBaseCard class="p-lg flex flex-col items-center text-center">
          <div class="w-32 h-32 rounded-full overflow-hidden mb-md border-4 border-surface-container relative group cursor-pointer">
            <img src="https://ui-avatars.com/api/?name=Provider&background=random" class="w-full h-full object-cover" >
            <div class="absolute inset-0 bg-on-surface/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
              <span class="material-symbols-outlined text-on-primary">photo_camera</span>
            </div>
          </div>
          <h4 class="font-label-md text-label-md text-on-surface mb-xs">Profile Photo</h4>
          <p class="font-body-sm text-body-sm text-on-surface-variant mb-md">JPG or PNG, max 5MB</p>
          <UiBaseButton variant="outline">
            Upload New
          </UiBaseButton>
        </UiBaseCard>

        <!-- Profile Completion Stats -->
        <UiBaseCard class="p-lg">
          <h4 class="font-headline-md text-headline-md text-on-surface mb-md">Profile Strength</h4>
          <div class="mb-sm flex justify-between items-end">
            <span class="font-display-lg text-display-lg text-primary">65%</span>
            <span class="font-label-sm text-label-sm text-on-surface-variant uppercase">Intermediate</span>
          </div>
          <div class="w-full bg-surface-container-high rounded-full h-2 mb-md">
            <div class="bg-primary h-2 rounded-full" style="width: 65%"/>
          </div>
          <ul class="space-y-sm">
            <li class="flex items-center gap-xs font-body-sm text-body-sm text-on-surface">
              <span class="material-symbols-outlined text-primary text-sm">check_circle</span>
              Basic Info
            </li>
            <li class="flex items-center gap-xs font-body-sm text-body-sm text-on-surface-variant">
              <span class="material-symbols-outlined text-sm">radio_button_unchecked</span>
              Add 2+ Specialties (+15%)
            </li>
            <li class="flex items-center gap-xs font-body-sm text-body-sm text-on-surface-variant">
              <span class="material-symbols-outlined text-sm">radio_button_unchecked</span>
              Connect Calendar (+20%)
            </li>
          </ul>
        </UiBaseCard>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({
  layout: 'provider'
})
</script>
