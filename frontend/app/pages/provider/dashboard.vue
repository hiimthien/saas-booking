<template>
  <div class="flex-1 p-md lg:p-lg max-w-container-max mx-auto w-full flex flex-col gap-lg">
    <!-- Page Title -->
    <div class="flex flex-col gap-xs">
      <h2 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface">Dashboard Overview</h2>
      <p class="font-body-md text-body-md text-on-surface-variant">Welcome back. Here's what's happening today.</p>
    </div>

    <!-- KPI Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-md">
      <!-- KPI Card 1 -->
      <UiCard class="p-md flex flex-col gap-sm hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start">
          <span class="font-label-md text-label-md text-on-surface-variant">Total Earnings</span>
          <div class="p-xs bg-surface-container-low rounded-lg text-primary">
            <span class="material-symbols-outlined text-[20px]">account_balance_wallet</span>
          </div>
        </div>
        <div>
          <div class="font-display-lg text-[32px] md:text-display-lg text-on-surface font-bold tracking-tight">$12,450</div>
          <div class="flex items-center gap-xs mt-xs">
            <span class="material-symbols-outlined text-[16px] text-primary">trending_up</span>
            <span class="font-label-sm text-label-sm text-primary">+12% this month</span>
          </div>
        </div>
      </UiCard>
      <!-- KPI Card 2 -->
      <UiCard class="p-md flex flex-col gap-sm hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start">
          <span class="font-label-md text-label-md text-on-surface-variant">Upcoming Sessions</span>
          <div class="p-xs bg-surface-container-low rounded-lg text-secondary">
            <span class="material-symbols-outlined text-[20px]">event</span>
          </div>
        </div>
        <div>
          <div class="font-display-lg text-[32px] md:text-display-lg text-on-surface font-bold tracking-tight">8</div>
          <div class="flex items-center gap-xs mt-xs">
            <span class="font-label-sm text-label-sm text-on-surface-variant">For the next 7 days</span>
          </div>
        </div>
      </UiCard>
      <!-- KPI Card 3 -->
      <UiCard class="p-md flex flex-col gap-sm hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start">
          <span class="font-label-md text-label-md text-on-surface-variant">Completion Rate</span>
          <div class="p-xs bg-surface-container-low rounded-lg text-primary">
            <span class="material-symbols-outlined text-[20px]">task_alt</span>
          </div>
        </div>
        <div>
          <div class="font-display-lg text-[32px] md:text-display-lg text-on-surface font-bold tracking-tight">98%</div>
          <div class="flex items-center gap-xs mt-xs">
            <span class="material-symbols-outlined text-[16px] text-primary">trending_up</span>
            <span class="font-label-sm text-label-sm text-primary">+2% vs last month</span>
          </div>
        </div>
      </UiCard>
      <!-- KPI Card 4 -->
      <UiCard class="p-md flex flex-col gap-sm hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start">
          <span class="font-label-md text-label-md text-on-surface-variant">Pending Requests</span>
          <div class="p-xs bg-surface-container-low rounded-lg text-tertiary">
            <span class="material-symbols-outlined text-[20px]">pending_actions</span>
          </div>
        </div>
        <div>
          <div class="font-display-lg text-[32px] md:text-display-lg text-on-surface font-bold tracking-tight">3</div>
          <div class="flex items-center gap-xs mt-xs">
            <span class="font-label-sm text-label-sm text-on-surface-variant">Requires attention</span>
          </div>
        </div>
      </UiCard>
    </div>

    <!-- Main Content Split -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-lg mt-md">
      <!-- Upcoming Schedule -->
      <UiCard class="xl:col-span-2 flex flex-col">
        <div class="p-md border-b border-outline-variant flex justify-between items-center bg-surface-bright">
          <h3 class="font-headline-md text-headline-md text-on-surface">Upcoming Schedule</h3>
          <button class="font-label-md text-label-md text-primary hover:text-primary-container transition-colors">View Full Calendar</button>
        </div>
        <div class="flex flex-col divide-y divide-outline-variant">
          <!-- Schedule Item 1 -->
          <div class="p-md flex flex-col sm:flex-row gap-md justify-between items-start sm:items-center hover:bg-surface-container-low transition-colors">
            <div class="flex items-start gap-md">
              <img src="https://ui-avatars.com/api/?name=Alex+Rivers&background=random" class="w-12 h-12 rounded-full object-cover border border-outline-variant" >
              <div class="flex flex-col gap-xs">
                <div class="flex items-center gap-sm">
                  <span class="font-label-md text-label-md text-on-surface">Alex Rivers</span>
                  <UiBadge variant="success">Confirmed</UiBadge>
                </div>
                <span class="font-body-sm text-body-sm text-on-surface-variant">1:1 Strategy Session</span>
                <div class="flex items-center gap-xs text-on-surface-variant mt-xs">
                  <span class="material-symbols-outlined text-[14px]">schedule</span>
                  <span class="font-label-sm text-label-sm">Today, 2:00 PM - 3:00 PM EST</span>
                </div>
              </div>
            </div>
            <div class="flex items-center gap-sm w-full sm:w-auto mt-sm sm:mt-0">
              <UiButton variant="primary" class="flex-1 sm:flex-none py-[6px]">
                <span class="material-symbols-outlined text-[18px]">videocam</span>
                Join Call
              </UiButton>
              <UiButton variant="outline" class="!px-sm py-[6px]" title="More options">
                <span class="material-symbols-outlined text-[20px]">more_vert</span>
              </UiButton>
            </div>
          </div>
          <!-- Schedule Item 2 -->
          <div class="p-md flex flex-col sm:flex-row gap-md justify-between items-start sm:items-center hover:bg-surface-container-low transition-colors">
            <div class="flex items-start gap-md">
              <div class="w-12 h-12 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center font-headline-md text-headline-md border border-outline-variant">MG</div>
              <div class="flex flex-col gap-xs">
                <div class="flex items-center gap-sm">
                  <span class="font-label-md text-label-md text-on-surface">Maria Garcia</span>
                  <UiBadge variant="warning">Pending</UiBadge>
                </div>
                <span class="font-body-sm text-body-sm text-on-surface-variant">Tech Architecture Review</span>
                <div class="flex items-center gap-xs text-on-surface-variant mt-xs">
                  <span class="material-symbols-outlined text-[14px]">schedule</span>
                  <span class="font-label-sm text-label-sm">Tomorrow, 10:00 AM - 11:30 AM EST</span>
                </div>
              </div>
            </div>
            <div class="flex items-center gap-sm w-full sm:w-auto mt-sm sm:mt-0">
              <UiButton variant="outline" class="flex-1 sm:flex-none">Reschedule</UiButton>
              <UiButton variant="outline" class="flex-1 sm:flex-none">Accept</UiButton>
            </div>
          </div>
        </div>
      </UiCard>

      <!-- Service Management -->
      <UiCard class="xl:col-span-1 flex flex-col p-0">
        <div class="p-md border-b border-outline-variant flex justify-between items-center bg-surface-bright">
          <h3 class="font-headline-md text-headline-md text-on-surface">Active Services</h3>
          <button class="p-xs text-on-surface-variant hover:bg-surface-variant rounded-full transition-colors">
            <span class="material-symbols-outlined text-[20px]">add</span>
          </button>
        </div>
        <div class="flex flex-col p-sm gap-xs bg-surface">
          <!-- Service 1 -->
          <UiCard class="p-md">
            <div class="flex justify-between items-start">
              <div>
                <h4 class="font-label-md text-label-md text-on-surface">1:1 Strategy Session</h4>
                <p class="font-body-sm text-body-sm text-on-surface-variant mt-xs">60 min • $150</p>
              </div>
              <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" value="" class="sr-only peer" checked>
                <div class="w-9 h-5 bg-outline-variant peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary"/>
              </label>
            </div>
          </UiCard>
          <!-- Service 2 -->
          <UiCard class="p-md">
            <div class="flex justify-between items-start">
              <div>
                <h4 class="font-label-md text-label-md text-on-surface">Tech Architecture Review</h4>
                <p class="font-body-sm text-body-sm text-on-surface-variant mt-xs">90 min • $250</p>
              </div>
              <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" value="" class="sr-only peer" checked>
                <div class="w-9 h-5 bg-outline-variant peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary"/>
              </label>
            </div>
          </UiCard>
        </div>
      </UiCard>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({
  layout: 'provider'
})
</script>
