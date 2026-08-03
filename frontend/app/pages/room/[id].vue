<template>
  <div class="bg-slate-900 text-on-surface h-screen w-screen overflow-hidden flex flex-col font-body-md dark">
    <!-- Header -->
    <header class="bg-slate-900 border-b border-slate-800 flex justify-between items-center px-lg py-sm z-50 shrink-0">
      <div class="flex items-center gap-md">
        <span class="font-headline-md font-bold text-white tracking-tight">ConsultFlow</span>
        <div class="h-4 w-px bg-slate-700"/>
        <span class="text-slate-300 font-body-md">Strategy Session with Dr. Mercer</span>
      </div>
      <div class="flex items-center gap-md">
        <div class="bg-slate-800 px-md py-sm rounded-lg flex items-center gap-sm border border-slate-700 shadow-sm">
          <span class="material-symbols-outlined text-slate-400 text-[18px]">timer</span>
          <span class="text-white font-label-md tracking-wider">42:15</span>
        </div>
        <button class="p-sm text-slate-300 hover:text-white hover:bg-slate-800 rounded-lg transition-colors flex items-center justify-center" @click="isSidebarOpen = !isSidebarOpen">
          <span class="material-symbols-outlined">chat</span>
        </button>
      </div>
    </header>

    <!-- Main Workspace -->
    <main class="flex-1 flex overflow-hidden relative">
      <!-- Video Area -->
      <div class="flex-1 relative bg-black flex items-center justify-center">
        <!-- Main Video Feed -->
        <div class="w-full h-full relative">
          <img class="w-full h-full object-cover opacity-90" src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&q=80" alt="Consultant Video" >
          <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent pointer-events-none"/>
          <div class="absolute bottom-6 left-6 bg-slate-900/60 backdrop-blur-md px-md py-sm rounded-lg border border-slate-700/50 flex items-center gap-sm">
            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"/>
            <span class="text-white font-label-md">Dr. Sarah Mercer (Host)</span>
          </div>
        </div>

        <!-- PIP Video (User) -->
        <div class="absolute top-6 right-6 w-48 aspect-video bg-slate-800 rounded-xl overflow-hidden border-2 border-slate-700 shadow-xl z-20">
          <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&q=80" alt="Your Video" >
          <div class="absolute bottom-2 left-2 bg-slate-900/70 px-2 py-1 rounded text-white font-label-sm text-[10px]">You</div>
        </div>

        <!-- Floating Control Bar -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 bg-slate-800/90 backdrop-blur-lg px-lg py-sm rounded-full border border-slate-700 shadow-2xl flex items-center gap-md z-30">
          <button class="w-12 h-12 rounded-full bg-slate-700 hover:bg-slate-600 flex items-center justify-center text-white transition-all group relative">
            <span class="material-symbols-outlined group-hover:scale-110 transition-transform">mic</span>
          </button>
          <button class="w-12 h-12 rounded-full bg-slate-700 hover:bg-slate-600 flex items-center justify-center text-white transition-all group relative">
            <span class="material-symbols-outlined group-hover:scale-110 transition-transform">videocam</span>
          </button>
          <div class="w-px h-8 bg-slate-600 mx-sm"/>
          <button class="w-12 h-12 rounded-full bg-slate-700 hover:bg-slate-600 flex items-center justify-center text-white transition-all group relative">
            <span class="material-symbols-outlined group-hover:scale-110 transition-transform">present_to_all</span>
          </button>
          <div class="w-px h-8 bg-slate-600 mx-sm"/>
          <button class="w-16 h-12 rounded-full bg-red-600 hover:bg-red-700 flex items-center justify-center text-white transition-all shadow-lg shadow-red-900/20 border border-red-500 hover:scale-105" @click="$router.push('/client/dashboard')">
            <span class="material-symbols-outlined font-bold">call_end</span>
          </button>
        </div>
      </div>

      <!-- Collapsible Sidebar -->
      <aside :class="['bg-slate-900 border-l border-slate-800 flex flex-col transition-all duration-300 ease-in-out shrink-0 overflow-hidden', isSidebarOpen ? 'w-80 opacity-100' : 'w-0 opacity-0 border-l-0']">
        <div class="flex border-b border-slate-800 p-sm gap-sm">
          <button class="flex-1 py-sm px-md rounded-md bg-slate-800 text-white font-label-md flex justify-center items-center gap-xs">
            <span class="material-symbols-outlined text-[18px]">forum</span> Chat
          </button>
          <button class="flex-1 py-sm px-md rounded-md text-slate-400 hover:text-white hover:bg-slate-800 font-label-md flex justify-center items-center gap-xs transition-colors">
            <span class="material-symbols-outlined text-[18px]">description</span> Files
          </button>
        </div>
        
        <div class="flex-1 overflow-y-auto p-md flex flex-col gap-md">
          <div class="text-center">
            <span class="bg-slate-800 text-slate-400 font-label-sm text-[10px] uppercase tracking-wider px-2 py-1 rounded-full border border-slate-700">Recording Started</span>
          </div>

          <div class="flex gap-sm items-start">
            <div class="w-8 h-8 rounded-full bg-slate-700 flex-shrink-0 overflow-hidden">
              <img src="https://ui-avatars.com/api/?name=Mercer" class="w-full h-full object-cover" >
            </div>
            <div>
              <div class="flex items-baseline gap-2 mb-1">
                <span class="text-white font-label-sm">Dr. Mercer</span>
                <span class="text-slate-500 text-[10px]">10:05 AM</span>
              </div>
              <div class="bg-slate-800 text-slate-200 p-sm rounded-lg rounded-tl-none font-body-sm border border-slate-700">
                Let's review the Q3 projections first before we dive into the restructuring plan.
              </div>
            </div>
          </div>
        </div>

        <div class="p-sm border-t border-slate-800 bg-slate-900/50">
          <div class="relative flex items-center">
            <button class="absolute left-2 text-slate-400 hover:text-white p-1 rounded transition-colors">
              <span class="material-symbols-outlined text-[20px]">attach_file</span>
            </button>
            <input type="text" class="w-full bg-slate-800 border border-slate-700 text-white text-body-sm rounded-lg pl-10 pr-10 py-2 focus:ring-1 focus:ring-primary focus:border-primary outline-none" placeholder="Type a message..." >
            <button class="absolute right-2 text-primary hover:text-primary-container p-1 rounded transition-colors">
              <span class="material-symbols-outlined text-[20px]">send</span>
            </button>
          </div>
        </div>
      </aside>
    </main>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

definePageMeta({ layout: false })

const isSidebarOpen = ref(true)
</script>
