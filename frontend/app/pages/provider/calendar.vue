<template>
  <div class="p-margin-mobile md:p-lg xl:p-xl flex flex-col gap-lg flex-1">
    <!-- Page Header & Controls -->
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-md">
      <div>
        <h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface mb-xs">Calendar Management</h1>
        <p class="font-body-md text-body-md text-on-surface-variant">Review your weekly schedule, manage bookings, and block time slots.</p>
      </div>
      <div class="flex items-center gap-sm">
        <!-- View Toggle -->
        <div class="flex bg-surface-container-low rounded-lg p-xs border border-outline-variant shadow-sm">
          <button class="px-sm py-xs text-on-surface-variant font-label-sm text-label-sm rounded hover:bg-surface-variant transition-colors">Month</button>
          <button class="px-sm py-xs bg-surface-container-lowest text-on-surface font-label-sm text-label-sm rounded shadow-sm">Week</button>
          <button class="px-sm py-xs text-on-surface-variant font-label-sm text-label-sm rounded hover:bg-surface-variant transition-colors">Day</button>
        </div>
        <button class="p-sm text-on-surface-variant border border-outline-variant rounded-lg hover:bg-surface-variant transition-colors shadow-sm flex items-center justify-center bg-surface-container-lowest">
          <span class="material-symbols-outlined text-[20px]">filter_list</span>
        </button>
      </div>
    </header>

    <!-- Interactive Calendar Wrapper -->
    <div class="flex-1 bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm flex flex-col overflow-hidden relative min-h-[600px]">
      <!-- Calendar Toolbar -->
      <div class="flex items-center justify-between p-md border-b border-outline-variant bg-surface-bright">
        <div class="flex items-center gap-md">
          <h2 class="font-headline-md text-headline-md text-on-surface">October 2023</h2>
          <div class="flex gap-xs">
            <button class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-surface-variant text-on-surface-variant transition-colors">
              <span class="material-symbols-outlined">chevron_left</span>
            </button>
            <button class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-surface-variant text-on-surface-variant transition-colors">
              <span class="material-symbols-outlined">chevron_right</span>
            </button>
          </div>
        </div>
        <button class="text-primary font-label-md text-label-md hover:text-primary-container transition-colors">Today</button>
      </div>

      <!-- Calendar Grid Area (Bento-ish structural approach for week view) -->
      <div class="flex-1 flex overflow-auto relative bg-surface-bright">
        <!-- Time Column -->
        <div class="w-16 flex-shrink-0 border-r border-outline-variant bg-surface sticky left-0 z-20 flex flex-col pt-3xl">
          <div v-for="time in ['9 AM', '10 AM', '11 AM', '12 PM', '1 PM', '2 PM', '3 PM']" :key="time" class="h-2xl flex items-start justify-end pr-sm relative group">
            <span class="font-label-sm text-label-sm text-on-surface-variant -mt-2 group-hover:text-primary transition-colors">{{ time }}</span>
          </div>
        </div>

        <!-- Days Grid -->
        <div class="flex-1 min-w-[800px] flex flex-col relative">
          <!-- Day Headers (Sticky) -->
          <div class="flex border-b border-outline-variant sticky top-0 z-10 bg-surface-bright/90 backdrop-blur-sm h-3xl">
            <div v-for="day in [{name: 'Mon', num: 16}, {name: 'Tue', num: 17}]" :key="day.name" class="flex-1 flex flex-col items-center justify-center border-r border-outline-variant/50 p-xs">
              <span class="font-label-sm text-label-sm text-on-surface-variant uppercase">{{ day.name }}</span>
              <span class="font-headline-md text-headline-md text-on-surface">{{ day.num }}</span>
            </div>
            <div class="flex-1 flex flex-col items-center justify-center border-r border-outline-variant/50 p-xs bg-primary/5 rounded-t-lg border-b-2 border-b-primary relative">
              <span class="font-label-sm text-label-sm text-primary uppercase font-bold">Wed</span>
              <span class="font-headline-md text-headline-md text-primary font-bold">18</span>
            </div>
            <div v-for="day in [{name: 'Thu', num: 19}, {name: 'Fri', num: 20}]" :key="day.name" class="flex-1 flex flex-col items-center justify-center border-r border-outline-variant/50 p-xs">
              <span class="font-label-sm text-label-sm text-on-surface-variant uppercase">{{ day.name }}</span>
              <span class="font-headline-md text-headline-md text-on-surface">{{ day.num }}</span>
            </div>
          </div>

          <!-- Grid Columns & Events -->
          <div class="flex-1 flex relative">
            <!-- Background Grid Lines -->
            <div class="absolute inset-0 flex flex-col pointer-events-none">
              <div v-for="i in 7" :key="i" class="h-2xl border-b border-outline-variant/30 w-full"/>
            </div>

            <!-- Day Columns -->
            <div class="flex-1 border-r border-outline-variant/30 relative hover:bg-surface-container-low/30 transition-colors group"/>
            <div class="flex-1 border-r border-outline-variant/30 relative hover:bg-surface-container-low/30 transition-colors group">
              <!-- Confirmed Booking -->
              <div class="absolute top-[48px] left-[4px] right-[4px] h-[92px] bg-secondary-fixed/50 border border-secondary/20 rounded-lg p-sm shadow-sm hover:shadow-md transition-shadow cursor-pointer group/event z-10">
                <div class="flex justify-between items-start mb-1">
                  <h3 class="font-label-md text-label-md text-on-secondary-fixed truncate">Tech Sync</h3>
                  <span class="material-symbols-outlined text-[16px] text-secondary opacity-0 group-hover/event:opacity-100 transition-opacity">more_vert</span>
                </div>
                <p class="font-label-sm text-label-sm text-on-secondary-fixed/80">10:00 AM - 12:00 PM</p>
                <p class="font-body-sm text-[11px] text-on-secondary-fixed/70 truncate mt-1">Acme Corp</p>
              </div>
            </div>
            
            <!-- Today Column -->
            <div class="flex-1 border-r border-outline-variant/30 relative bg-primary/5 hover:bg-primary/10 transition-colors group">
              <!-- Current Time Indicator -->
              <div class="absolute top-[120px] left-0 right-0 h-px bg-error z-20 flex items-center">
                <div class="w-2 h-2 rounded-full bg-error -ml-1"/>
              </div>
              <!-- Blocked Time -->
              <div class="absolute top-0 left-[4px] right-[4px] h-[44px] bg-surface-variant border border-outline-variant border-dashed rounded-lg p-sm flex items-center justify-center opacity-70 hover:opacity-100 transition-opacity cursor-not-allowed z-10">
                <span class="material-symbols-outlined text-on-surface-variant text-[18px] mr-1">block</span>
                <span class="font-label-sm text-label-sm text-on-surface-variant">Blocked</span>
              </div>
              <!-- Conflict Alert Booking -->
              <div class="absolute top-[144px] left-[4px] right-[4px] h-[44px] bg-error-container border border-error/30 rounded-lg p-sm shadow-sm cursor-pointer overflow-hidden group/event z-10">
                <div class="flex items-center gap-xs">
                  <span class="material-symbols-outlined text-error text-[16px]">warning</span>
                  <h3 class="font-label-md text-label-md text-on-error-container truncate">Double Booked</h3>
                </div>
              </div>
            </div>
            
            <div class="flex-1 border-r border-outline-variant/30 relative hover:bg-surface-container-low/30 transition-colors group">
              <!-- Another Booking -->
              <div class="absolute top-[240px] left-[4px] right-[4px] h-[44px] bg-primary-fixed/30 border border-primary/20 rounded-lg p-sm shadow-sm hover:shadow-md transition-shadow cursor-pointer z-10">
                <h3 class="font-label-md text-label-md text-on-primary-fixed-variant truncate">Strategy Review</h3>
                <p class="font-label-sm text-label-sm text-on-primary-fixed-variant/80">2:00 PM - 3:00 PM</p>
              </div>
            </div>
            <div class="flex-1 border-r border-outline-variant/30 relative hover:bg-surface-container-low/30 transition-colors group"/>
          </div>
        </div>
      </div>

      <!-- Floating Quick Action Area -->
      <div class="absolute bottom-md right-md flex gap-sm z-30">
        <button aria-label="Block Time" class="bg-surface-container-lowest text-on-surface border border-outline-variant p-sm rounded-full shadow-sm hover:bg-surface-variant transition-colors flex items-center justify-center">
          <span class="material-symbols-outlined text-[20px]">event_busy</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({
  layout: 'provider'
})
</script>
