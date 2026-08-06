<template>
  <div class="flex flex-col gap-3xl">
    <!-- Header Section -->
    <div class="flex flex-col gap-sm">
      <h1 class="font-display-lg text-on-background">Your network, curated.</h1>
      <p class="font-body-lg text-on-surface-variant max-w-2xl">Access your saved consultants and discover new experts tailored to your recent projects and booking history.</p>
    </div>

    <!-- Recommended Carousel -->
    <section class="flex flex-col gap-lg">
      <div class="flex justify-between items-end">
        <div class="flex flex-col gap-xs">
          <h2 class="font-headline-md text-on-background flex items-center gap-sm">
            <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">auto_awesome</span>
            Recommended for you
          </h2>
          <p class="font-body-sm text-on-surface-variant">Based on your recent strategy bookings</p>
        </div>
        <div class="flex gap-sm">
          <button class="w-10 h-10 rounded-full bg-surface-container border border-outline-variant flex items-center justify-center text-on-surface-variant hover:bg-surface-variant transition-colors">
            <span class="material-symbols-outlined">chevron_left</span>
          </button>
          <button class="w-10 h-10 rounded-full bg-surface-container border border-outline-variant flex items-center justify-center text-on-surface-variant hover:bg-surface-variant transition-colors">
            <span class="material-symbols-outlined">chevron_right</span>
          </button>
        </div>
      </div>

      <!-- Carousel Container -->
      <div class="flex gap-lg overflow-x-auto hide-scrollbar pb-sm snap-x snap-mandatory">
        <!-- Recommendation Card 1 -->
        <UiBaseCard class="snap-start shrink-0 w-80 relative overflow-hidden group p-0">
          <div class="h-24 bg-tertiary-fixed w-full absolute top-0 left-0 -z-10 group-hover:bg-tertiary-fixed-dim transition-colors"/>
          <div class="p-md pt-xl flex flex-col items-center text-center gap-sm mt-md relative">
            <button class="absolute top-md right-md text-on-surface-variant hover:text-primary transition-colors">
              <span class="material-symbols-outlined">bookmark_add</span>
            </button>
            <div class="w-20 h-20 rounded-full border-4 border-surface-container-lowest overflow-hidden shadow-sm">
              <img src="https://ui-avatars.com/api/?name=Wei+Chen&background=random" alt="Dr. Wei Chen" class="w-full h-full object-cover" >
            </div>
            <div>
              <h3 class="font-headline-sm text-headline-md text-on-surface">Dr. Wei Chen</h3>
              <p class="font-body-sm text-primary font-medium">Enterprise Architect</p>
            </div>
            <div class="flex gap-sm justify-center flex-wrap mt-xs">
              <UiStatusBadge variant="neutral">Cloud</UiStatusBadge>
              <UiStatusBadge variant="neutral">Security</UiStatusBadge>
            </div>
            <div class="w-full flex justify-between items-center mt-md pt-md border-t border-outline-variant">
              <div class="flex items-center gap-xs text-on-surface-variant">
                <span class="material-symbols-outlined text-sm">star</span>
                <span class="font-label-sm">4.9 (120)</span>
              </div>
              <button class="font-label-md text-primary hover:text-primary-container transition-colors">View Profile</button>
            </div>
          </div>
        </UiBaseCard>

        <!-- Recommendation Card 2 -->
        <UiBaseCard class="snap-start shrink-0 w-80 relative overflow-hidden group p-0">
          <div class="h-24 bg-secondary-fixed w-full absolute top-0 left-0 -z-10 group-hover:bg-secondary-fixed-dim transition-colors"/>
          <div class="p-md pt-xl flex flex-col items-center text-center gap-sm mt-md relative">
            <button class="absolute top-md right-md text-on-surface-variant hover:text-primary transition-colors">
              <span class="material-symbols-outlined">bookmark_add</span>
            </button>
            <div class="w-20 h-20 rounded-full border-4 border-surface-container-lowest overflow-hidden shadow-sm">
              <img src="https://ui-avatars.com/api/?name=Sarah+Jenkins&background=random" alt="Sarah Jenkins" class="w-full h-full object-cover" >
            </div>
            <div>
              <h3 class="font-headline-sm text-headline-md text-on-surface">Sarah Jenkins</h3>
              <p class="font-body-sm text-secondary font-medium">Growth Strategist</p>
            </div>
            <div class="flex gap-sm justify-center flex-wrap mt-xs">
              <UiStatusBadge variant="neutral">B2B</UiStatusBadge>
              <UiStatusBadge variant="neutral">SaaS</UiStatusBadge>
            </div>
            <div class="w-full flex justify-between items-center mt-md pt-md border-t border-outline-variant">
              <div class="flex items-center gap-xs text-on-surface-variant">
                <span class="material-symbols-outlined text-sm">star</span>
                <span class="font-label-sm">5.0 (85)</span>
              </div>
              <button class="font-label-md text-primary hover:text-primary-container transition-colors">View Profile</button>
            </div>
          </div>
        </UiBaseCard>
      </div>
    </section>

    <!-- Saved Consultants Grid -->
    <section class="flex flex-col gap-lg pb-xl">
      <div class="flex justify-between items-end border-b border-outline-variant pb-sm">
        <div class="flex flex-col gap-xs">
          <h2 class="font-headline-md text-on-background flex items-center gap-sm">
            <span class="material-symbols-outlined text-tertiary" style="font-variation-settings: 'FILL' 1;">bookmarks</span>
            Saved Consultants
          </h2>
          <p class="font-body-sm text-on-surface-variant">Your bookmarked experts for quick access.</p>
        </div>
        <div class="flex gap-sm">
          <UiBaseButton variant="outline">
            <span class="material-symbols-outlined text-[18px]">filter_list</span>
            Filter
          </UiBaseButton>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-lg">
        <!-- Saved Card 1 -->
        <UiBaseCard class="p-lg flex flex-col gap-md hover:border-primary transition-colors group">
          <div class="flex justify-between items-start">
            <div class="flex gap-md items-center">
              <div class="w-16 h-16 rounded-full overflow-hidden border border-outline-variant">
                <img src="https://ui-avatars.com/api/?name=Elena+Rodriguez&background=random" alt="Elena Rodriguez" class="w-full h-full object-cover" >
              </div>
              <div>
                <h3 class="font-headline-sm text-headline-md text-on-surface group-hover:text-primary transition-colors">Elena Rodriguez</h3>
                <p class="font-body-sm text-on-surface-variant">UX Research Lead</p>
              </div>
            </div>
            <button class="text-primary p-xs hover:bg-primary-fixed rounded-full transition-colors">
              <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">bookmark</span>
            </button>
          </div>
          <p class="font-body-sm text-on-surface line-clamp-2">Specializing in generative user research and qualitative analysis for early-stage B2B SaaS startups.</p>
          <div class="mt-auto pt-md flex justify-between items-center">
            <div class="font-label-sm text-on-surface-variant flex items-center gap-xs">
              <span class="material-symbols-outlined" style="font-size: 16px;">schedule</span>
              Available next week
            </div>
            <UiBaseButton variant="outline">Book Now</UiBaseButton>
          </div>
        </UiBaseCard>
        
        <!-- Saved Card 2 -->
        <UiBaseCard class="p-lg flex flex-col gap-md hover:border-primary transition-colors group">
          <div class="flex justify-between items-start">
            <div class="flex gap-md items-center">
              <div class="w-16 h-16 rounded-full overflow-hidden border border-outline-variant">
                <img src="https://ui-avatars.com/api/?name=Rajiv+Patel&background=random" alt="Rajiv Patel" class="w-full h-full object-cover" >
              </div>
              <div>
                <h3 class="font-headline-sm text-headline-md text-on-surface group-hover:text-primary transition-colors">Rajiv Patel</h3>
                <p class="font-body-sm text-on-surface-variant">Supply Chain Analyst</p>
              </div>
            </div>
            <button class="text-primary p-xs hover:bg-primary-fixed rounded-full transition-colors">
              <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">bookmark</span>
            </button>
          </div>
          <p class="font-body-sm text-on-surface line-clamp-2">Optimizing global logistics and reducing operational overhead for manufacturing enterprises.</p>
          <div class="mt-auto pt-md flex justify-between items-center">
            <div class="font-label-sm text-on-surface-variant flex items-center gap-xs">
              <span class="material-symbols-outlined" style="font-size: 16px;">schedule</span>
              Available tmrw
            </div>
            <UiBaseButton variant="outline">Book Now</UiBaseButton>
          </div>
        </UiBaseCard>
      </div>
    </section>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'client' })
</script>
