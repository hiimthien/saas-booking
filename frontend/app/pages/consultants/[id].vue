<template>
  <div class="w-full max-w-container-max mx-auto px-margin-mobile md:px-gutter py-lg md:py-xl grid grid-cols-1 lg:grid-cols-12 gap-lg relative">
    <!-- Main Content -->
    <div class="lg:col-span-8 flex flex-col gap-xl">
      <!-- Consultant Profile Bento -->
      <section class="bg-surface-container-lowest border border-outline-variant rounded-xl p-lg shadow-sm flex flex-col md:flex-row gap-lg items-start">
        <img src="https://ui-avatars.com/api/?name=Sarah+Jenkins&background=random" alt="Sarah Jenkins" class="w-32 h-32 md:w-48 md:h-48 rounded-xl object-cover border-4 border-surface-container" >
        
        <div class="flex flex-col gap-sm flex-grow">
          <div class="flex justify-between items-start w-full">
            <div>
              <h1 class="font-headline-lg text-on-surface">Sarah Jenkins</h1>
              <p class="font-body-lg text-on-surface-variant">Senior UX Strategy Consultant</p>
            </div>
            <div class="flex gap-xs">
              <span class="bg-secondary-container text-on-secondary-container px-sm py-xs rounded font-label-sm flex items-center gap-xs">
                <span class="material-symbols-outlined text-[16px]" style="font-variation-settings: 'FILL' 1;">verified</span> Top Rated
              </span>
              <span class="bg-surface-variant text-on-surface-variant px-sm py-xs rounded font-label-sm flex items-center gap-xs">
                <span class="material-symbols-outlined text-[16px]" style="font-variation-settings: 'FILL' 1;">award_star</span> Expert
              </span>
            </div>
          </div>
          
          <div class="mt-md text-on-surface font-body-md flex flex-col gap-sm">
            <p>With over 12 years of experience helping SaaS startups and enterprise clients optimize their digital workflows, I specialize in actionable UX strategies that drive retention and user satisfaction.</p>
            <div class="flex items-center gap-sm text-on-surface-variant font-body-sm mt-sm">
              <span class="flex items-center gap-xs"><span class="material-symbols-outlined text-[18px]">location_on</span> San Francisco, CA (Remote)</span>
              <span>•</span>
              <span class="flex items-center gap-xs"><span class="material-symbols-outlined text-[18px]">translate</span> English, Spanish</span>
            </div>
          </div>
        </div>
      </section>

      <!-- Service Offerings -->
      <section class="flex flex-col gap-md">
        <h2 class="font-headline-md text-on-surface">Service Offerings</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
          <div class="bg-surface-container-lowest border border-outline-variant rounded-lg p-md hover:border-secondary transition-colors cursor-pointer flex flex-col gap-sm">
            <div class="flex items-center justify-between">
              <span class="material-symbols-outlined text-secondary">architecture</span>
              <span class="font-label-sm text-on-surface-variant">60 mins</span>
            </div>
            <h3 class="font-label-md text-on-surface">UX Strategy Audit</h3>
            <p class="font-body-sm text-on-surface-variant">Comprehensive review of your core user flows identifying friction points and conversion opportunities.</p>
          </div>
          
          <div class="bg-surface-container-lowest border border-outline-variant rounded-lg p-md hover:border-secondary transition-colors cursor-pointer flex flex-col gap-sm">
            <div class="flex items-center justify-between">
              <span class="material-symbols-outlined text-secondary">group</span>
              <span class="font-label-sm text-on-surface-variant">90 mins</span>
            </div>
            <h3 class="font-label-md text-on-surface">Team Workshop</h3>
            <p class="font-body-sm text-on-surface-variant">Interactive session with your product team to align on design system adoption and best practices.</p>
          </div>
        </div>
      </section>

      <!-- Rich Description -->
      <section class="flex flex-col gap-md bg-surface-container-low p-lg rounded-xl">
        <h2 class="font-headline-md text-on-surface">About the Consultation</h2>
        <div class="font-body-md text-on-surface space-y-md">
          <p>My approach is deeply analytical yet heavily focused on human-centric outcomes. When you book a session with me, expect a structured deep dive into your current challenges.</p>
          <ul class="list-disc pl-lg space-y-sm text-on-surface-variant">
            <li><strong>Pre-session review:</strong> I analyze materials you provide 48 hours in advance.</li>
            <li><strong>Actionable insights:</strong> Every session ends with a concrete list of next steps.</li>
            <li><strong>Follow-up support:</strong> Brief email support included for 7 days post-session.</li>
          </ul>
        </div>
      </section>

      <!-- Reviews -->
      <section class="flex flex-col gap-lg border-t border-outline-variant pt-lg">
        <div class="flex items-center justify-between">
          <h2 class="font-headline-md text-on-surface">Customer Reviews</h2>
          <div class="flex items-center gap-sm">
            <span class="font-headline-md text-on-surface">4.9</span>
            <div class="flex text-amber-500">
              <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
              <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
              <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
              <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
              <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star_half</span>
            </div>
            <span class="font-body-sm text-on-surface-variant">(128 reviews)</span>
          </div>
        </div>
        
        <div class="flex flex-col gap-md">
          <div class="bg-surface-container-lowest p-md rounded-lg border border-outline-variant flex flex-col gap-sm">
            <div class="flex justify-between items-start">
              <div class="flex items-center gap-sm">
                <div class="w-8 h-8 rounded-full bg-tertiary-container flex items-center justify-center text-on-tertiary font-label-sm">JD</div>
                <div>
                  <div class="font-label-md text-on-surface">James D.</div>
                  <div class="font-body-sm text-on-surface-variant">Oct 12, 2023</div>
                </div>
              </div>
              <div class="flex text-amber-500 text-[16px]">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
              </div>
            </div>
            <p class="font-body-sm text-on-surface">Sarah provided incredible clarity on our onboarding flow. Highly recommended!</p>
          </div>
        </div>
      </section>
    </div>

    <!-- Sticky Sidebar -->
    <aside class="lg:col-span-4 relative">
      <div class="sticky top-[100px] bg-surface-container-lowest border border-outline-variant rounded-xl p-lg shadow-sm flex flex-col gap-lg">
        <!-- Pricing Header -->
        <div class="flex justify-between items-end border-b border-outline-variant pb-md">
          <div class="flex flex-col">
            <span class="font-label-sm text-on-surface-variant uppercase tracking-wider">Consultation Rate</span>
            <span class="font-headline-lg text-on-surface">$150<span class="font-body-md text-on-surface-variant">/hr</span></span>
          </div>
        </div>

        <!-- Calendar Picker Mockup -->
        <div class="flex flex-col gap-sm">
          <div class="flex justify-between items-center">
            <button class="p-xs hover:bg-surface-variant rounded transition-colors"><span class="material-symbols-outlined">chevron_left</span></button>
            <span class="font-label-md text-on-surface">November 2023</span>
            <button class="p-xs hover:bg-surface-variant rounded transition-colors"><span class="material-symbols-outlined">chevron_right</span></button>
          </div>
          <div class="grid grid-cols-7 gap-xs text-center font-label-sm text-on-surface-variant mb-xs">
            <span>Su</span><span>Mo</span><span>Tu</span><span>We</span><span>Th</span><span>Fr</span><span>Sa</span>
          </div>
          <div class="grid grid-cols-7 gap-xs text-center font-body-sm">
            <span class="text-on-surface-variant/30 py-sm">29</span><span class="text-on-surface-variant/30 py-sm">30</span><span class="text-on-surface-variant/30 py-sm">31</span>
            <span class="py-sm hover:bg-surface-variant rounded cursor-pointer">1</span>
            <span class="py-sm hover:bg-surface-variant rounded cursor-pointer">2</span>
            <span class="py-sm bg-primary text-on-primary rounded font-bold cursor-pointer shadow-sm">3</span>
            <span class="py-sm hover:bg-surface-variant rounded cursor-pointer">4</span>
            <span class="py-sm hover:bg-surface-variant rounded cursor-pointer">5</span>
            <span class="py-sm hover:bg-surface-variant rounded cursor-pointer">6</span>
            <span class="py-sm hover:bg-surface-variant rounded cursor-pointer">7</span>
          </div>
        </div>

        <!-- Time Slots -->
        <div class="flex flex-col gap-sm pt-sm border-t border-outline-variant">
          <span class="font-label-md text-on-surface">Available Times for Nov 3</span>
          <div class="grid grid-cols-2 gap-sm">
            <button class="border border-outline-variant rounded py-sm font-label-sm text-on-surface hover:border-primary hover:text-primary transition-colors">09:00 AM</button>
            <button class="border border-primary bg-primary-container/10 rounded py-sm font-label-sm text-primary transition-colors">10:30 AM</button>
            <button class="border border-outline-variant/30 bg-surface-container-low rounded py-sm font-label-sm text-on-surface-variant/50 cursor-not-allowed" disabled>01:00 PM</button>
            <button class="border border-outline-variant rounded py-sm font-label-sm text-on-surface hover:border-primary hover:text-primary transition-colors">02:30 PM</button>
          </div>
        </div>

        <!-- CTA & Badges -->
        <div class="flex flex-col gap-md pt-sm">
          <button class="w-full bg-primary text-on-primary font-label-md py-md rounded-lg hover:bg-primary-container hover:text-on-primary-container transition-colors shadow-sm focus:ring-2 focus:ring-secondary focus:outline-none" @click="$router.push('/checkout')">
            Proceed to Payment
          </button>
          <div class="flex justify-center gap-lg text-on-surface-variant font-label-sm">
            <span class="flex items-center gap-xs"><span class="material-symbols-outlined text-[16px]">lock</span> Secure Payment</span>
            <span class="flex items-center gap-xs"><span class="material-symbols-outlined text-[16px]">verified_user</span> Verified Expert</span>
          </div>
        </div>
      </div>
    </aside>
  </div>
</template>

<script setup lang="ts">
// Logic for consultant details
</script>
