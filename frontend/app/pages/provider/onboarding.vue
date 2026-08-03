<template>
  <div class="bg-surface-container-low text-on-background min-h-screen flex items-center justify-center p-margin-mobile md:p-gutter antialiased">
    <!-- Main Container -->
    <main class="w-full max-w-3xl bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant overflow-hidden flex flex-col">
      <!-- Header -->
      <header class="p-lg md:p-xl border-b border-surface-variant flex items-center justify-between bg-surface-container-lowest sticky top-0 z-10">
        <div class="flex items-center gap-sm">
          <span class="material-symbols-outlined text-primary font-headline-md" style="font-variation-settings: 'FILL' 1;">dataset</span>
          <span class="font-headline-md text-on-surface">ConsultFlow</span>
        </div>
        <div class="font-label-md text-on-surface-variant bg-surface-variant px-sm py-xs rounded-full">
          Step 1 of 4
        </div>
      </header>

      <!-- Progress Stepper -->
      <div class="px-lg md:px-xl pt-lg">
        <div class="flex justify-between items-center relative">
          <!-- Progress Line Background -->
          <div class="absolute top-1/2 left-0 w-full h-[2px] bg-surface-variant -z-10 -translate-y-1/2"/>
          <!-- Active Progress Line -->
          <div class="absolute top-1/2 left-0 w-1/4 h-[2px] bg-primary -z-10 -translate-y-1/2 transition-all duration-500"/>
          
          <!-- Steps -->
          <div class="flex flex-col items-center gap-sm bg-surface-container-lowest px-sm">
            <div class="w-8 h-8 rounded-full bg-primary text-on-primary flex items-center justify-center font-label-md ring-4 ring-surface-container-lowest">1</div>
            <span class="font-label-sm text-primary hidden md:block text-center whitespace-nowrap">Verify Identity</span>
          </div>
          
          <div class="flex flex-col items-center gap-sm bg-surface-container-lowest px-sm">
            <div class="w-8 h-8 rounded-full bg-surface-variant text-on-surface-variant flex items-center justify-center font-label-md ring-4 ring-surface-container-lowest">2</div>
            <span class="font-label-sm text-on-surface-variant hidden md:block text-center whitespace-nowrap">Connect Calendar</span>
          </div>
          
          <div class="flex flex-col items-center gap-sm bg-surface-container-lowest px-sm">
            <div class="w-8 h-8 rounded-full bg-surface-variant text-on-surface-variant flex items-center justify-center font-label-md ring-4 ring-surface-container-lowest">3</div>
            <span class="font-label-sm text-on-surface-variant hidden md:block text-center whitespace-nowrap">Set Default Pricing</span>
          </div>
          
          <div class="flex flex-col items-center gap-sm bg-surface-container-lowest px-sm">
            <div class="w-8 h-8 rounded-full bg-surface-variant text-on-surface-variant flex items-center justify-center font-label-md ring-4 ring-surface-container-lowest">4</div>
            <span class="font-label-sm text-on-surface-variant hidden md:block text-center whitespace-nowrap">Connect Bank</span>
          </div>
        </div>
      </div>

      <!-- Content Area -->
      <div class="p-lg md:p-xl flex-grow flex flex-col gap-lg">
        <div>
          <h1 class="font-headline-lg text-on-surface mb-xs">Verify your identity</h1>
          <p class="font-body-md text-on-surface-variant">To ensure trust on our platform, we need to verify your professional credentials before you can start accepting consultations.</p>
        </div>
        
        <form class="flex flex-col gap-md">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
            <div class="flex flex-col gap-xs">
              <label class="font-label-sm text-on-surface">Legal First Name</label>
              <input type="text" placeholder="e.g. Jane" class="px-md py-sm bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md focus:border-secondary focus:ring-1 focus:ring-secondary transition-colors w-full" >
            </div>
            <div class="flex flex-col gap-xs">
              <label class="font-label-sm text-on-surface">Legal Last Name</label>
              <input type="text" placeholder="e.g. Doe" class="px-md py-sm bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md focus:border-secondary focus:ring-1 focus:ring-secondary transition-colors w-full" >
            </div>
          </div>
          
          <div class="flex flex-col gap-xs">
            <label class="font-label-sm text-on-surface">Professional Title</label>
            <input type="text" placeholder="e.g. Senior Business Consultant" class="px-md py-sm bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md focus:border-secondary focus:ring-1 focus:ring-secondary transition-colors w-full" >
          </div>
          
          <div class="flex flex-col gap-xs mt-sm">
            <label class="font-label-sm text-on-surface">Upload Government ID</label>
            <div class="border-2 border-dashed border-outline-variant rounded-xl p-lg flex flex-col items-center justify-center gap-sm bg-surface-bright hover:bg-surface-variant transition-colors cursor-pointer group">
              <div class="w-12 h-12 rounded-full bg-surface-container-lowest flex items-center justify-center text-outline group-hover:text-primary transition-colors shadow-sm">
                <span class="material-symbols-outlined">cloud_upload</span>
              </div>
              <div class="text-center">
                <p class="font-label-md text-on-surface mb-xs"><span class="text-primary font-bold">Click to upload</span> or drag and drop</p>
                <p class="font-body-sm text-on-surface-variant">SVG, PNG, JPG or PDF (max. 10MB)</p>
              </div>
            </div>
          </div>
        </form>
      </div>

      <!-- Footer Actions -->
      <footer class="p-lg md:p-xl border-t border-surface-variant bg-surface-container-lowest flex justify-end gap-sm mt-auto">
        <button type="button" class="px-lg py-sm rounded-lg font-label-md text-on-surface border border-outline-variant hover:bg-surface-variant transition-colors">
          Save for later
        </button>
        <button type="button" class="px-lg py-sm rounded-lg font-label-md text-on-primary bg-primary hover:bg-primary-container hover:text-on-primary-container transition-colors shadow-sm flex items-center gap-xs" @click="$router.push('/provider/dashboard')">
          Continue to Calendar
          <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
        </button>
      </footer>
    </main>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: false })
</script>
