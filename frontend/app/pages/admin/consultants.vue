<template>
  <div class="p-margin-mobile md:p-lg xl:p-xl w-full flex-1">
    <!-- Header -->
    <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-md mb-lg">
      <div>
        <h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface">Consultant Approvals</h1>
        <p class="font-body-sm text-body-sm text-on-surface-variant mt-xs">Review and approve new consultant applications to maintain quality.</p>
      </div>
      <div class="flex gap-sm">
        <!-- Status Tabs -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-lg p-1 flex">
          <button class="px-sm py-xs bg-primary-container text-on-primary-container rounded-md font-label-sm text-label-sm font-bold shadow-sm">Pending (12)</button>
          <button class="px-sm py-xs text-on-surface-variant hover:bg-surface-variant rounded-md font-label-sm text-label-sm transition-colors">Approved</button>
          <button class="px-sm py-xs text-on-surface-variant hover:bg-surface-variant rounded-md font-label-sm text-label-sm transition-colors">Rejected</button>
        </div>
      </div>
    </header>

    <!-- Grid of Pending Applications -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-lg">
      
      <!-- Application Card 1 -->
      <UiCard class="p-lg flex flex-col">
        <div class="flex justify-between items-start mb-md">
          <div class="flex gap-md">
            <img src="https://ui-avatars.com/api/?name=Sarah+Jenkins&background=random" class="w-12 h-12 rounded-full object-cover border border-outline-variant" >
            <div>
              <h3 class="font-headline-md text-headline-md text-on-surface font-bold">Sarah Jenkins</h3>
              <p class="font-body-sm text-body-sm text-primary">Senior UX Designer</p>
            </div>
          </div>
          <UiBadge variant="warning">In Review</UiBadge>
        </div>
        
        <div class="space-y-sm mb-md flex-1">
          <div class="flex justify-between items-center text-sm">
            <span class="text-on-surface-variant">Applied Date</span>
            <span class="text-on-surface font-medium">Nov 2, 2023</span>
          </div>
          <div class="flex justify-between items-center text-sm">
            <span class="text-on-surface-variant">Experience</span>
            <span class="text-on-surface font-medium">8+ Years</span>
          </div>
          <div class="flex justify-between items-center text-sm">
            <span class="text-on-surface-variant">LinkedIn</span>
            <a href="#" class="text-primary hover:underline font-medium flex items-center gap-1">Verified <span class="material-symbols-outlined text-[14px]">check_circle</span></a>
          </div>
        </div>
        
        <div class="border-t border-outline-variant pt-md flex gap-sm mt-auto">
          <UiButton variant="outline" class="flex-1 hover:bg-error-container hover:text-on-error-container hover:border-error">Reject</UiButton>
          <UiButton variant="primary" class="flex-1">Approve</UiButton>
        </div>
      </UiCard>

      <!-- Application Card 2 -->
      <UiCard class="p-lg flex flex-col">
        <div class="flex justify-between items-start mb-md">
          <div class="flex gap-md">
            <img src="https://ui-avatars.com/api/?name=Michael+Chang&background=random" class="w-12 h-12 rounded-full object-cover border border-outline-variant" >
            <div>
              <h3 class="font-headline-md text-headline-md text-on-surface font-bold">Michael Chang</h3>
              <p class="font-body-sm text-body-sm text-primary">Financial Advisor</p>
            </div>
          </div>
          <UiBadge variant="warning">In Review</UiBadge>
        </div>
        
        <div class="space-y-sm mb-md flex-1">
          <div class="flex justify-between items-center text-sm">
            <span class="text-on-surface-variant">Applied Date</span>
            <span class="text-on-surface font-medium">Nov 1, 2023</span>
          </div>
          <div class="flex justify-between items-center text-sm">
            <span class="text-on-surface-variant">Experience</span>
            <span class="text-on-surface font-medium">12+ Years</span>
          </div>
          <div class="flex justify-between items-center text-sm">
            <span class="text-on-surface-variant">Credentials</span>
            <span class="text-on-surface font-medium">CFA Pending</span>
          </div>
        </div>
        
        <div class="border-t border-outline-variant pt-md flex gap-sm mt-auto">
          <UiButton variant="outline" class="flex-1 hover:bg-error-container hover:text-on-error-container hover:border-error">Reject</UiButton>
          <UiButton variant="primary" class="flex-1">Approve</UiButton>
        </div>
      </UiCard>

    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({
  layout: 'admin'
})
</script>
