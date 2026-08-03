<template>
  <div>
    <header class="mb-xl flex flex-col md:flex-row md:items-end justify-between gap-md">
      <div>
        <h1 class="font-display-lg text-on-surface mb-xs">My Bookings</h1>
        <p class="font-body-md text-on-surface-variant">Manage your upcoming consultations and review past sessions.</p>
      </div>
      <!-- Tabs -->
      <div class="flex bg-surface-container-low rounded-lg p-xs border border-outline-variant/30">
        <button class="px-md py-sm rounded-md bg-surface text-primary shadow-sm font-label-md transition-all">Upcoming</button>
        <button class="px-md py-sm rounded-md text-on-surface-variant hover:text-on-surface font-label-md transition-all">Past</button>
        <button class="px-md py-sm rounded-md text-on-surface-variant hover:text-on-surface font-label-md transition-all">Canceled</button>
      </div>
    </header>

    <!-- Bookings Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-md md:gap-lg">
      <!-- Booking Card 1 -->
      <UiCard class="p-md flex flex-col gap-md shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
        <div class="absolute top-0 left-0 w-1 h-full bg-primary"/>
        <div class="flex justify-between items-start">
          <div class="flex items-center gap-sm">
            <div class="w-12 h-12 rounded-full overflow-hidden border border-outline-variant/50">
              <img src="https://ui-avatars.com/api/?name=Marcus+Chen&background=0D8ABC&color=fff" alt="Consultant avatar" class="w-full h-full object-cover" >
            </div>
            <div>
              <h3 class="font-label-md text-on-surface">Dr. Marcus Chen</h3>
              <p class="font-body-sm text-on-surface-variant">Financial Strategy</p>
            </div>
          </div>
          <UiBadge variant="primary">Confirmed</UiBadge>
        </div>
        <div class="flex flex-col gap-xs py-sm border-y border-outline-variant/30">
          <div class="flex items-center gap-sm text-on-surface">
            <span class="material-symbols-outlined text-on-surface-variant text-[20px]">event</span>
            <span class="font-body-sm">Oct 24, 2023 • 10:00 AM EST</span>
          </div>
          <div class="flex items-center gap-sm text-on-surface">
            <span class="material-symbols-outlined text-on-surface-variant text-[20px]">videocam</span>
            <span class="font-body-sm">Zoom Video Call</span>
          </div>
          <div class="flex items-center gap-sm text-on-surface">
            <span class="material-symbols-outlined text-on-surface-variant text-[20px]">timer</span>
            <span class="font-body-sm">45 Minutes</span>
          </div>
        </div>
        <div class="flex gap-sm mt-auto pt-xs">
          <UiButton class="flex-1 py-[6px]">
            <span class="material-symbols-outlined text-[18px]">video_call</span>
            Join Call
          </UiButton>
          <UiButton variant="outline" class="!px-sm py-[6px]" title="Reschedule">
            <span class="material-symbols-outlined">edit_calendar</span>
          </UiButton>
          <UiButton variant="outline" class="!px-sm py-[6px] hover:text-error hover:bg-error-container hover:border-error" title="Cancel">
            <span class="material-symbols-outlined">close</span>
          </UiButton>
        </div>
      </UiCard>

      <!-- Booking Card 2 -->
      <UiCard class="p-md flex flex-col gap-md shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
        <div class="absolute top-0 left-0 w-1 h-full bg-secondary"/>
        <div class="flex justify-between items-start">
          <div class="flex items-center gap-sm">
            <div class="w-12 h-12 rounded-full overflow-hidden border border-outline-variant/50">
               <img src="https://ui-avatars.com/api/?name=Sarah+Jenkins&background=random" alt="Consultant avatar" class="w-full h-full object-cover" >
            </div>
            <div>
              <h3 class="font-label-md text-on-surface">Sarah Jenkins</h3>
              <p class="font-body-sm text-on-surface-variant">UX Portfolio Review</p>
            </div>
          </div>
          <UiBadge variant="warning">Pending</UiBadge>
        </div>
        <div class="flex flex-col gap-xs py-sm border-y border-outline-variant/30">
          <div class="flex items-center gap-sm text-on-surface">
            <span class="material-symbols-outlined text-on-surface-variant text-[20px]">event</span>
            <span class="font-body-sm">Oct 26, 2023 • 2:30 PM EST</span>
          </div>
          <div class="flex items-center gap-sm text-on-surface">
            <span class="material-symbols-outlined text-on-surface-variant text-[20px]">link</span>
            <span class="font-body-sm">Google Meet</span>
          </div>
          <div class="flex items-center gap-sm text-on-surface">
            <span class="material-symbols-outlined text-on-surface-variant text-[20px]">timer</span>
            <span class="font-body-sm">60 Minutes</span>
          </div>
        </div>
        <div class="flex gap-sm mt-auto pt-xs">
          <UiButton class="flex-1 py-[6px] bg-surface-container-highest text-on-surface" disabled>
            <span class="material-symbols-outlined text-[18px]">schedule</span>
            Awaiting Confirmation
          </UiButton>
          <UiButton variant="outline" class="!px-sm py-[6px]" title="Reschedule">
            <span class="material-symbols-outlined">edit_calendar</span>
          </UiButton>
        </div>
      </UiCard>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'client' })
</script>
