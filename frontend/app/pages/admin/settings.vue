<template>
  <div class="p-margin-mobile md:p-lg xl:p-xl w-full flex-1 mb-2xl">
    <!-- Header -->
    <header class="flex flex-col gap-xs mb-lg">
      <h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface">Platform Settings</h1>
      <p class="font-body-sm text-body-sm text-on-surface-variant">Configure global parameters, payments, and localization.</p>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-lg">
      <!-- Settings Sidebar Navigation -->
      <nav class="lg:col-span-1 flex flex-col gap-xs bg-surface border border-outline-variant rounded-xl p-md shadow-sm h-fit">
        <a href="#" class="flex items-center gap-md px-md py-sm rounded-lg font-label-md text-label-md bg-secondary-container text-on-secondary-container font-bold transition-all">
          <span class="material-symbols-outlined text-[20px]">tune</span>
          General
        </a>
        <a href="#" class="flex items-center gap-md px-md py-sm rounded-lg font-label-md text-label-md text-on-surface-variant hover:bg-surface-variant transition-all">
          <span class="material-symbols-outlined text-[20px]">payments</span>
          Payments & Fees
        </a>
        <a href="#" class="flex items-center gap-md px-md py-sm rounded-lg font-label-md text-label-md text-on-surface-variant hover:bg-surface-variant transition-all">
          <span class="material-symbols-outlined text-[20px]">mail</span>
          Email Templates
        </a>
        <a href="#" class="flex items-center gap-md px-md py-sm rounded-lg font-label-md text-label-md text-on-surface-variant hover:bg-surface-variant transition-all">
          <span class="material-symbols-outlined text-[20px]">security</span>
          Security
        </a>
        <a href="#" class="flex items-center gap-md px-md py-sm rounded-lg font-label-md text-label-md text-on-surface-variant hover:bg-surface-variant transition-all">
          <span class="material-symbols-outlined text-[20px]">api</span>
          Integrations
        </a>
      </nav>

      <!-- Settings Content Area -->
      <div class="lg:col-span-3 flex flex-col gap-lg">
        
        <!-- General Settings Panel -->
        <!-- General Settings Panel -->
        <UiCard class="p-0">
          <div class="p-md border-b border-outline-variant bg-surface">
            <h2 class="font-headline-md text-headline-md text-on-surface">General Configuration</h2>
          </div>
          <div class="p-lg space-y-md">
            <!-- Site Name -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-md items-start">
              <div class="md:col-span-1">
                <h3 class="font-label-md text-label-md text-on-surface">Platform Name</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Displayed in header and emails.</p>
              </div>
              <div class="md:col-span-2">
                <UiInput model-value="ConsultFlow" />
              </div>
            </div>
            <hr class="border-outline-variant" >
            <!-- Support Email -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-md items-start">
              <div class="md:col-span-1">
                <h3 class="font-label-md text-label-md text-on-surface">Support Email</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Where users send help requests.</p>
              </div>
              <div class="md:col-span-2">
                <UiInput type="email" model-value="support@consultflow.com" />
              </div>
            </div>
            <hr class="border-outline-variant" >
            <!-- Default Timezone -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-md items-start">
              <div class="md:col-span-1">
                <h3 class="font-label-md text-label-md text-on-surface">System Timezone</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Base timezone for cron jobs.</p>
              </div>
              <div class="md:col-span-2">
                <UiSelect
model-value="UTC" :options="[
                  { value: 'UTC', label: 'UTC (Coordinated Universal Time)' },
                  { value: 'America/New_York', label: 'America/New_York (EST)' },
                  { value: 'Asia/Ho_Chi_Minh', label: 'Asia/Ho_Chi_Minh (ICT)' }
                ]" />
              </div>
            </div>
          </div>
          <div class="p-md border-t border-outline-variant bg-surface flex justify-end">
            <UiButton variant="primary">Save Changes</UiButton>
          </div>
        </UiCard>

        <!-- Payments & Fees Panel -->
        <!-- Payments & Fees Panel -->
        <UiCard class="p-0">
          <div class="p-md border-b border-outline-variant bg-surface">
            <h2 class="font-headline-md text-headline-md text-on-surface">Platform Fees</h2>
          </div>
          <div class="p-lg space-y-md">
            <!-- Commission Rate -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-md items-start">
              <div class="md:col-span-1">
                <h3 class="font-label-md text-label-md text-on-surface">Commission Rate (%)</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Amount taken from each successful booking.</p>
              </div>
              <div class="md:col-span-2 relative">
                <UiInput type="number" model-value="15" />
                <span class="absolute right-md top-1/2 -translate-y-1/2 text-on-surface-variant font-bold pointer-events-none">%</span>
              </div>
            </div>
            <hr class="border-outline-variant" >
            <!-- Withdrawal Minimum -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-md items-start">
              <div class="md:col-span-1">
                <h3 class="font-label-md text-label-md text-on-surface">Minimum Withdrawal</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Minimum amount required for consultant payouts.</p>
              </div>
              <div class="md:col-span-2 relative">
                <UiInput type="number" model-value="50.00" class="pl-8" />
                <span class="absolute left-md top-1/2 -translate-y-1/2 text-on-surface-variant font-bold z-10 pointer-events-none">$</span>
              </div>
            </div>
          </div>
          <div class="p-md border-t border-outline-variant bg-surface flex justify-end">
            <UiButton variant="primary">Save Changes</UiButton>
          </div>
        </UiCard>

      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({
  layout: 'admin'
})
</script>
