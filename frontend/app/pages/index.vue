<template>
  <div>
    <!-- Hero Section -->
    <section class="relative pt-3xl pb-2xl px-margin-mobile md:px-gutter overflow-hidden flex flex-col items-center justify-center text-center">
      <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[800px] bg-primary-container/5 rounded-full blur-3xl -z-10 pointer-events-none"/>
      
      <div class="max-w-[800px] mx-auto z-10 flex flex-col items-center">
        <div class="inline-flex items-center gap-sm px-md py-xs bg-surface-container-low border border-outline-variant rounded-full mb-lg">
          <span class="w-2 h-2 rounded-full bg-primary animate-pulse"/>
          <span class="font-label-sm text-on-surface-variant uppercase tracking-wider">New Platform Features Available</span>
        </div>
        
        <h1 class="font-display-lg text-on-surface mb-lg md:text-[56px] md:leading-[64px] md:-tracking-[0.03em]">
          Find the right <span class="text-primary relative inline-block">expertise
            <svg class="absolute w-full h-3 -bottom-1 left-0 text-primary-fixed-dim" preserveAspectRatio="none" viewBox="0 0 100 10">
              <path d="M0 5 Q 50 10 100 5" fill="transparent" stroke="currentColor" stroke-width="4"/>
            </svg>
          </span> to scale your growth.
        </h1>
        
        <p class="font-body-lg text-on-surface-variant max-w-[600px] mb-xl">
          Connect with top-tier consultants and industry leaders instantly. Streamline your workflow, manage bookings, and accelerate your business objectives.
        </p>
        
        <!-- Dynamic Search Bar -->
        <div class="w-full max-w-[640px] bg-surface-container-lowest p-sm rounded-full border border-outline-variant shadow-sm flex items-center focus-within:border-primary focus-within:ring-1 focus-within:ring-primary transition-all">
          <div class="pl-md text-on-surface-variant flex items-center">
            <span class="material-symbols-outlined">search</span>
          </div>
          <input type="text" placeholder="What kind of consultant do you need?" class="flex-grow bg-transparent border-none focus:ring-0 font-body-md text-on-surface px-md placeholder:text-on-surface-variant/60 outline-none" >
          <button class="bg-primary text-on-primary font-label-md px-lg py-sm rounded-full hover:brightness-90 transition-all flex items-center gap-sm shadow-sm whitespace-nowrap" @click="$router.push('/search')">
            Find Experts
            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
          </button>
        </div>
      </div>
      
      <!-- Hero Image Asset -->
      <div class="w-full max-w-container-max mx-auto mt-2xl rounded-2xl overflow-hidden border border-outline-variant shadow-lg relative bg-surface-container-low h-[400px] md:h-[500px]">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&q=80')"/>
        <!-- Floating UI -->
        <div class="absolute bottom-lg right-lg bg-surface-container-lowest/80 backdrop-blur-md border border-outline-variant p-md rounded-xl shadow-sm flex items-center gap-md">
          <div class="w-12 h-12 rounded-full bg-primary-container flex items-center justify-center text-on-primary-container">
            <span class="material-symbols-outlined">trending_up</span>
          </div>
          <div>
            <div class="font-label-sm text-on-surface-variant uppercase">Conversion Rate</div>
            <div class="font-headline-md text-on-surface">+24.8%</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Social Proof & Logos -->
    <section class="py-xl border-y border-outline-variant bg-surface-container-low px-margin-mobile md:px-gutter">
      <div class="max-w-container-max mx-auto">
        <p class="text-center font-label-sm text-on-surface-variant uppercase tracking-wider mb-lg">Trusted by innovative teams worldwide</p>
        <div class="flex flex-wrap justify-center items-center gap-xl md:gap-3xl opacity-60 grayscale hover:grayscale-0 transition-all duration-500">
          <div class="flex items-center gap-xs font-headline-md text-on-surface"><span class="material-symbols-outlined text-[32px]">webhook</span> Globex</div>
          <div class="flex items-center gap-xs font-headline-md text-on-surface"><span class="material-symbols-outlined text-[32px]">hub</span> Initech</div>
          <div class="flex items-center gap-xs font-headline-md text-on-surface"><span class="material-symbols-outlined text-[32px]">architecture</span> Acme Corp</div>
          <div class="flex items-center gap-xs font-headline-md text-on-surface"><span class="material-symbols-outlined text-[32px]">stream</span> Soylent</div>
          <div class="flex items-center gap-xs font-headline-md text-on-surface"><span class="material-symbols-outlined text-[32px]">all_inclusive</span> Massive Dynamic</div>
        </div>
      </div>
    </section>

    <!-- Animated Metrics -->
    <section class="py-3xl px-margin-mobile md:px-gutter max-w-container-max mx-auto">
      <div class="grid grid-cols-1 md:grid-cols-12 gap-lg items-center">
        <div class="md:col-span-5 mb-xl md:mb-0">
          <h2 class="font-headline-lg text-on-surface mb-md">Measurable impact from day one.</h2>
          <p class="font-body-md text-on-surface-variant mb-lg">Our platform isn't just about making connections; it's about delivering tangible results that drive your business forward. Track progress, manage engagements, and watch your metrics climb.</p>
          <NuxtLink to="#" class="inline-flex items-center gap-sm font-label-md text-primary hover:text-primary-container transition-colors">
            Read our case studies
            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
          </NuxtLink>
        </div>
        <div class="md:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-md">
          <!-- Metric Card 1 -->
          <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl p-xl shadow-sm hover:-translate-y-1 transition-transform">
            <div class="w-10 h-10 rounded-lg bg-secondary-container text-on-secondary-container flex items-center justify-center mb-md">
              <span class="material-symbols-outlined">schedule</span>
            </div>
            <div class="font-display-lg text-on-surface mb-xs">85</div>
            <div class="font-label-md text-on-surface-variant">% Faster Bookings</div>
          </div>
          <!-- Metric Card 2 -->
          <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl p-xl shadow-sm hover:-translate-y-1 transition-transform">
            <div class="w-10 h-10 rounded-lg bg-primary-container text-on-primary-container flex items-center justify-center mb-md">
              <span class="material-symbols-outlined">groups</span>
            </div>
            <div class="font-display-lg text-on-surface mb-xs flex items-center">10k+</div>
            <div class="font-label-md text-on-surface-variant">Active Experts</div>
          </div>
          <!-- Metric Card 3 -->
          <div class="sm:col-span-2 bg-surface-container-lowest border border-outline-variant rounded-2xl p-xl shadow-sm hover:-translate-y-1 transition-transform flex flex-col sm:flex-row items-start sm:items-center justify-between">
            <div>
              <div class="font-display-lg text-on-surface mb-xs flex items-center">$50M+</div>
              <div class="font-label-md text-on-surface-variant">Value Generated for Clients</div>
            </div>
            <div class="mt-md sm:mt-0 w-12 h-12 rounded-full border-2 border-primary text-primary flex items-center justify-center">
              <span class="material-symbols-outlined">payments</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- How It Works -->
    <section class="py-3xl px-margin-mobile md:px-gutter bg-surface-bright border-t border-outline-variant">
      <div class="max-w-container-max mx-auto text-center mb-2xl">
        <h2 class="font-headline-lg text-on-surface mb-sm">Streamlined for Success</h2>
        <p class="font-body-md text-on-surface-variant max-w-[500px] mx-auto">Get started in minutes and experience a frictionless workflow designed for modern professionals.</p>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-lg max-w-container-max mx-auto relative">
        <div class="hidden md:block absolute top-1/2 left-[15%] right-[15%] h-[1px] bg-outline-variant border-t border-dashed -translate-y-1/2 z-0"/>
        
        <!-- Step 1 -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl p-xl shadow-sm relative z-10 flex flex-col items-center text-center hover:-translate-y-1 transition-transform">
          <div class="w-16 h-16 rounded-full bg-primary flex items-center justify-center text-on-primary mb-lg shadow-sm">
            <span class="material-symbols-outlined text-[32px]">person_search</span>
          </div>
          <div class="font-label-sm text-primary mb-xs uppercase tracking-wider">Step 1</div>
          <h3 class="font-headline-md text-on-surface mb-sm">Discover</h3>
          <p class="font-body-sm text-on-surface-variant">Use our AI-driven dynamic search to pinpoint the exact expertise required for your unique challenge.</p>
        </div>
        
        <!-- Step 2 -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl p-xl shadow-sm relative z-10 flex flex-col items-center text-center hover:-translate-y-1 transition-transform">
          <div class="w-16 h-16 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary-container mb-lg shadow-sm">
            <span class="material-symbols-outlined text-[32px]">calendar_add_on</span>
          </div>
          <div class="font-label-sm text-secondary mb-xs uppercase tracking-wider">Step 2</div>
          <h3 class="font-headline-md text-on-surface mb-sm">Connect & Book</h3>
          <p class="font-body-sm text-on-surface-variant">Review detailed profiles, check real-time availability, and secure a consultation block instantly.</p>
        </div>
        
        <!-- Step 3 -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl p-xl shadow-sm relative z-10 flex flex-col items-center text-center hover:-translate-y-1 transition-transform">
          <div class="w-16 h-16 rounded-full bg-tertiary-container flex items-center justify-center text-on-tertiary-container mb-lg shadow-sm">
            <span class="material-symbols-outlined text-[32px]">rocket_launch</span>
          </div>
          <div class="font-label-sm text-tertiary mb-xs uppercase tracking-wider">Step 3</div>
          <h3 class="font-headline-md text-on-surface mb-sm">Execute</h3>
          <p class="font-body-sm text-on-surface-variant">Collaborate via our secure video workspace, manage documents, and drive your project to completion.</p>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup lang="ts">
// Page component logic
</script>
