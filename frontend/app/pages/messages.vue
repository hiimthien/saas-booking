<template>
  <div class="h-screen flex flex-col overflow-hidden bg-background">
    <!-- TopNavBar -->
    <Header />

    <div class="flex flex-1 overflow-hidden">
      <!-- SideNavBar (Left Column) -->
      <aside class="hidden md:flex flex-col w-80 bg-surface-container-low border-r border-outline-variant h-full flex-shrink-0">
        <!-- Header/Search in Sidebar -->
        <div class="p-md border-b border-outline-variant bg-surface-container-lowest">
          <div class="relative">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">search</span>
            <input type="text" placeholder="Search messages..." class="w-full pl-10 pr-sm py-sm rounded-lg border border-outline-variant bg-surface text-on-surface font-body-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-shadow" >
          </div>
        </div>

        <!-- Chat List -->
        <div class="flex-1 overflow-y-auto custom-scrollbar p-sm">
          <!-- Chat Item 1 (Active) -->
          <div class="flex items-center gap-md p-sm rounded-lg bg-secondary-container text-on-secondary-container cursor-pointer transition-colors mb-xs">
            <div class="relative">
              <img src="https://ui-avatars.com/api/?name=Sarah+Jenkins&background=random" alt="Sarah Jenkins" class="w-12 h-12 rounded-full object-cover border border-outline-variant" >
              <div class="absolute bottom-0 right-0 w-3 h-3 bg-primary rounded-full border-2 border-secondary-container"/>
            </div>
            <div class="flex-1 min-w-0">
              <div class="flex justify-between items-baseline mb-xs">
                <h3 class="font-label-md font-bold truncate">Sarah Jenkins</h3>
                <span class="font-label-sm opacity-80">10:42 AM</span>
              </div>
              <p class="font-body-sm truncate opacity-90">Yes, the Q3 projections look solid. Let's discuss tomorrow.</p>
            </div>
          </div>

          <!-- Chat Item 2 (Unread) -->
          <div class="flex items-center gap-md p-sm rounded-lg hover:bg-surface-variant cursor-pointer transition-colors mb-xs group">
            <div class="relative">
              <img src="https://ui-avatars.com/api/?name=Marcus+Chen&background=random" alt="Marcus Chen" class="w-12 h-12 rounded-full object-cover border border-outline-variant group-hover:border-outline transition-colors" >
              <div class="absolute bottom-0 right-0 w-3 h-3 bg-primary rounded-full border-2 border-surface-container-low group-hover:border-surface-variant"/>
            </div>
            <div class="flex-1 min-w-0">
              <div class="flex justify-between items-baseline mb-xs">
                <h3 class="font-label-md font-semibold text-on-surface truncate">Marcus Chen</h3>
                <span class="font-label-sm text-primary font-bold">09:15 AM</span>
              </div>
              <p class="font-body-sm text-on-surface-variant font-medium truncate">I've uploaded the new API documentation for your review.</p>
            </div>
            <div class="w-5 h-5 rounded-full bg-primary flex items-center justify-center">
              <span class="font-label-sm text-[10px] text-on-primary font-bold leading-none">2</span>
            </div>
          </div>
        </div>
      </aside>

      <!-- Main Chat Window (Right Column) -->
      <main class="flex-1 flex flex-col bg-surface-container-lowest h-full relative">
        <!-- Chat Header -->
        <div class="flex items-center justify-between p-md border-b border-outline-variant bg-surface-container-lowest sticky top-0 z-10 shadow-sm">
          <div class="flex items-center gap-md">
            <button class="md:hidden p-xs text-on-surface-variant hover:text-primary transition-colors">
              <span class="material-symbols-outlined">arrow_back</span>
            </button>
            <div class="relative">
              <img src="https://ui-avatars.com/api/?name=Sarah+Jenkins&background=random" alt="Sarah Jenkins" class="w-10 h-10 rounded-full object-cover border border-outline-variant" >
              <div class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-primary rounded-full border border-surface-container-lowest"/>
            </div>
            <div>
              <h2 class="font-label-md font-bold text-on-surface">Sarah Jenkins</h2>
              <p class="font-label-sm text-primary">Financial Advisor • Online</p>
            </div>
          </div>
          <div class="flex items-center gap-sm">
            <button class="p-sm text-on-surface-variant hover:text-primary hover:bg-surface-variant rounded-full transition-colors">
              <span class="material-symbols-outlined">call</span>
            </button>
            <button class="p-sm text-on-surface-variant hover:text-primary hover:bg-surface-variant rounded-full transition-colors">
              <span class="material-symbols-outlined">videocam</span>
            </button>
            <button class="p-sm text-on-surface-variant hover:text-primary hover:bg-surface-variant rounded-full transition-colors">
              <span class="material-symbols-outlined">more_vert</span>
            </button>
          </div>
        </div>

        <!-- Chat Messages Area -->
        <div class="flex-1 overflow-y-auto custom-scrollbar p-lg flex flex-col gap-md bg-surface-bright">
          <div class="flex justify-center my-sm">
            <span class="px-sm py-xs bg-surface-container-highest text-on-surface-variant font-label-sm rounded-full">Today</span>
          </div>

          <!-- Message Received -->
          <div class="flex items-end gap-sm max-w-[85%] md:max-w-[70%]">
            <img src="https://ui-avatars.com/api/?name=Sarah+Jenkins&background=random" alt="Sarah Jenkins" class="w-8 h-8 rounded-full object-cover border border-outline-variant mb-1" >
            <div class="flex flex-col gap-xs">
              <span class="font-label-sm text-on-surface-variant ml-1">Sarah Jenkins • 10:30 AM</span>
              <div class="bg-surface-container p-sm rounded-xl rounded-bl-sm text-on-surface font-body-md shadow-sm border border-outline-variant">
                Hi there! I've reviewed the preliminary Q3 figures you sent over.
              </div>
            </div>
          </div>

          <!-- Message Sent -->
          <div class="flex items-end justify-end gap-sm max-w-[85%] md:max-w-[70%] self-end mt-sm">
            <div class="flex flex-col gap-xs items-end w-full">
              <span class="font-label-sm text-on-surface-variant mr-1">You • 10:35 AM</span>
              <div class="bg-primary text-on-primary p-sm rounded-xl rounded-br-sm font-body-md shadow-sm">
                That's great to hear! Did you notice any areas of concern?
              </div>
            </div>
          </div>
        </div>

        <!-- Chat Input Area -->
        <div class="p-md bg-surface-container-lowest border-t border-outline-variant">
          <div class="flex items-end gap-sm bg-surface rounded-xl border border-outline-variant focus-within:border-primary focus-within:ring-1 focus-within:ring-primary p-xs transition-shadow">
            <button class="p-sm text-outline hover:text-primary transition-colors flex-shrink-0 mb-1">
              <span class="material-symbols-outlined">attach_file</span>
            </button>
            <textarea class="flex-1 max-h-32 min-h-[44px] py-sm bg-transparent border-none focus:ring-0 resize-none font-body-md text-on-surface placeholder:text-outline-variant custom-scrollbar outline-none" placeholder="Type a message..." rows="1"/>
            <div class="flex items-center gap-xs flex-shrink-0 mb-1">
              <button class="p-sm bg-primary text-on-primary rounded-lg hover:bg-primary-container hover:text-on-primary-container transition-colors shadow-sm flex items-center justify-center">
                <span class="material-symbols-outlined">send</span>
              </button>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: false })
</script>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background-color: #bccac0;
    border-radius: 20px;
}
</style>
