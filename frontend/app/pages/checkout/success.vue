<template>
  <div class="bg-surface text-on-surface antialiased min-h-screen flex flex-col items-center justify-center p-margin-mobile md:p-lg">
    <!-- Transactional Screen - No Nav Shell -->
    <main class="w-full max-w-2xl bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm overflow-hidden animate-fade-in-up">
      <!-- Hero Status -->
      <div class="bg-primary-container p-xl flex flex-col items-center justify-center text-center">
        <div class="w-20 h-20 bg-on-primary-container rounded-full flex items-center justify-center mb-lg shadow-sm">
          <span class="material-symbols-outlined text-[48px] text-primary" style="font-variation-settings: 'FILL' 1;">check_circle</span>
        </div>
        <h1 class="font-headline-lg text-headline-lg text-on-primary-container mb-sm">Payment Successful</h1>
        <p class="font-body-lg text-body-lg text-on-primary-container/90">Your booking is confirmed.</p>
      </div>
      
      <!-- Details -->
      <div class="p-xl space-y-xl">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center pb-md border-b border-outline-variant gap-sm">
          <div>
            <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider block mb-xs">Booking ID</span>
            <span class="font-body-md text-body-md font-medium">#CF-8924-XQ</span>
          </div>
          <div class="text-left md:text-right">
            <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider block mb-xs">Date</span>
            <span class="font-body-md text-body-md font-medium">October 24, 2023, 10:00 AM PST</span>
          </div>
        </div>
        
        <!-- Transaction Summary -->
        <div class="bg-surface-container-low rounded-lg p-lg border border-outline-variant space-y-md">
          <h2 class="font-label-md text-label-md text-on-surface mb-md pb-xs border-b border-outline-variant">Transaction Summary</h2>
          <div class="flex justify-between items-center">
            <span class="font-body-sm text-body-sm text-on-surface-variant flex items-center gap-xs">
              <span class="material-symbols-outlined text-[16px]">design_services</span>
              UX Strategy Consultation (1 hr)
            </span>
            <span class="font-body-sm text-body-sm font-medium">$150.00</span>
          </div>
          <div class="flex justify-between items-center">
            <span class="font-body-sm text-body-sm text-on-surface-variant flex items-center gap-xs">
              <span class="material-symbols-outlined text-[16px]">receipt_long</span>
              Platform Fee
            </span>
            <span class="font-body-sm text-body-sm font-medium">$5.00</span>
          </div>
          <div class="pt-sm border-t border-outline-variant flex justify-between items-center">
            <span class="font-label-md text-label-md text-on-surface">Total Paid</span>
            <span class="font-headline-md text-headline-md text-primary">$155.00</span>
          </div>
          <div class="flex items-center gap-sm mt-sm pt-sm border-t border-outline-variant text-on-surface-variant">
            <span class="material-symbols-outlined text-[20px]">credit_card</span>
            <span class="font-body-sm text-body-sm">Visa ending in 4242</span>
          </div>
        </div>
        
        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-md pt-md">
          <NuxtLink to="/client/dashboard" class="flex-1 bg-primary text-on-primary font-label-md text-label-md py-sm px-lg rounded-lg hover:bg-surface-tint hover:shadow-md transition-all focus:outline-none focus:ring-2 focus:ring-secondary flex items-center justify-center gap-sm h-[48px]">
            <span class="material-symbols-outlined">calendar_month</span>
            View My Bookings
          </NuxtLink>
          <button class="flex-1 bg-surface-container-lowest text-on-surface border border-outline-variant font-label-md text-label-md py-sm px-lg rounded-lg hover:bg-surface-container-low transition-all focus:outline-none focus:ring-2 focus:ring-secondary flex items-center justify-center gap-sm h-[48px]">
            <span class="material-symbols-outlined">download</span>
            Download Receipt
          </button>
        </div>
      </div>
      
      <!-- Support Footer -->
      <div class="bg-surface-container-low py-md px-xl text-center border-t border-outline-variant">
        <p class="font-body-sm text-body-sm text-on-surface-variant">
          Need help with your booking? 
          <a class="text-primary hover:underline font-medium ml-xs inline-flex items-center gap-xs" href="#">
            Contact Support
            <span class="material-symbols-outlined text-[14px]">open_in_new</span>
          </a>
        </p>
      </div>
    </main>
  </div>
</template>

<script setup lang="ts">
definePageMeta({
  layout: false
})
</script>

<style scoped>
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
.animate-fade-in-up {
  animation: fadeInUp 0.5s ease-out forwards;
}
</style>
