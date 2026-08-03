<template>
  <div class="bg-background text-on-background font-body-md min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-surface-container-lowest border-b border-outline-variant py-md px-lg flex items-center shadow-sm">
      <NuxtLink to="/consultants/1" class="flex items-center gap-sm text-primary hover:text-primary-container transition-colors">
        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">arrow_back</span>
        <span class="font-label-md text-label-md">Back to booking</span>
      </NuxtLink>
      <div class="mx-auto font-headline-md text-headline-md text-on-surface font-semibold tracking-tight">Secure Checkout</div>
    </header>

    <main class="max-w-container-max mx-auto px-margin-mobile md:px-gutter py-xl md:py-2xl flex-grow w-full">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-lg">
        <!-- Left Column: Payment & Billing -->
        <div class="lg:col-span-7 xl:col-span-8 flex flex-col gap-xl">
          <!-- Payment Method Section -->
          <section class="bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm p-lg md:p-xl">
            <h2 class="font-headline-md text-headline-md text-on-surface mb-md">Payment Method</h2>
            <div class="flex flex-col gap-sm">
              <!-- Credit Card Option (Selected) -->
              <label class="relative flex cursor-pointer rounded-lg border border-primary bg-primary-fixed/10 p-md focus:outline-none">
                <input checked class="peer sr-only" name="payment-method" type="radio" value="credit-card" >
                <span class="flex w-full items-center justify-between">
                  <span class="flex items-center gap-md">
                    <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">credit_card</span>
                    <span class="flex flex-col">
                      <span class="font-label-md text-label-md text-on-surface">Credit or Debit Card</span>
                    </span>
                  </span>
                  <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                </span>
              </label>

              <!-- Expanded Card Form -->
              <div class="pl-md md:pl-2xl pr-md pb-md flex flex-col gap-md">
                <div class="relative">
                  <label class="sr-only" for="card-number">Card Number</label>
                  <input id="card-number" class="block w-full rounded-lg border border-outline-variant py-sm px-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary font-body-md bg-surface placeholder-on-surface-variant outline-none" placeholder="Card number" type="text" >
                </div>
                <div class="grid grid-cols-2 gap-md">
                  <div class="relative">
                    <label class="sr-only" for="expiry-date">Expiration Date</label>
                    <input id="expiry-date" class="block w-full rounded-lg border border-outline-variant py-sm px-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary font-body-md bg-surface placeholder-on-surface-variant outline-none" placeholder="MM / YY" type="text" >
                  </div>
                  <div class="relative">
                    <label class="sr-only" for="cvc">CVC</label>
                    <input id="cvc" class="block w-full rounded-lg border border-outline-variant py-sm px-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary font-body-md bg-surface placeholder-on-surface-variant outline-none" placeholder="CVC" type="text" >
                  </div>
                </div>
                <div class="relative">
                  <label class="sr-only" for="card-name">Name on Card</label>
                  <input id="card-name" class="block w-full rounded-lg border border-outline-variant py-sm px-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary font-body-md bg-surface placeholder-on-surface-variant outline-none" placeholder="Name on card" type="text" >
                </div>
              </div>

              <!-- PayOS Option -->
              <label class="relative flex cursor-pointer rounded-lg border border-outline-variant bg-surface p-md hover:bg-surface-variant transition-colors focus:outline-none">
                <input class="peer sr-only" name="payment-method" type="radio" value="payos" >
                <span class="flex w-full items-center justify-between">
                  <span class="flex items-center gap-md">
                    <span class="material-symbols-outlined text-on-surface-variant" style="font-variation-settings: 'FILL' 0;">account_balance</span>
                    <span class="flex flex-col">
                      <span class="font-label-md text-label-md text-on-surface">PayOS (Bank Transfer)</span>
                    </span>
                  </span>
                </span>
              </label>

              <!-- VNPay Option -->
              <label class="relative flex cursor-pointer rounded-lg border border-outline-variant bg-surface p-md hover:bg-surface-variant transition-colors focus:outline-none">
                <input class="peer sr-only" name="payment-method" type="radio" value="vnpay" >
                <span class="flex w-full items-center justify-between">
                  <span class="flex items-center gap-md">
                    <span class="material-symbols-outlined text-on-surface-variant" style="font-variation-settings: 'FILL' 0;">qr_code_scanner</span>
                    <span class="flex flex-col">
                      <span class="font-label-md text-label-md text-on-surface">VNPay</span>
                    </span>
                  </span>
                </span>
              </label>
            </div>
          </section>

          <!-- Billing Information Section -->
          <section class="bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm p-lg md:p-xl">
            <h2 class="font-headline-md text-headline-md text-on-surface mb-md">Billing Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
              <div class="relative md:col-span-2">
                <label class="block font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider mb-xs" for="billing-email">Email Address</label>
                <input id="billing-email" class="block w-full rounded-lg border border-outline-variant py-sm px-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary font-body-md bg-surface outline-none" type="email" value="alex.client@example.com" >
              </div>
              <div class="relative md:col-span-2">
                <label class="block font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider mb-xs" for="billing-address">Street Address</label>
                <input id="billing-address" class="block w-full rounded-lg border border-outline-variant py-sm px-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary font-body-md bg-surface placeholder-on-surface-variant outline-none" placeholder="123 Financial District Ave" type="text" >
              </div>
              <div class="relative">
                <label class="block font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider mb-xs" for="billing-city">City</label>
                <input id="billing-city" class="block w-full rounded-lg border border-outline-variant py-sm px-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary font-body-md bg-surface placeholder-on-surface-variant outline-none" placeholder="New York" type="text" >
              </div>
              <div class="relative">
                <label class="block font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider mb-xs" for="billing-zip">Postal Code</label>
                <input id="billing-zip" class="block w-full rounded-lg border border-outline-variant py-sm px-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary font-body-md bg-surface placeholder-on-surface-variant outline-none" placeholder="10004" type="text" >
              </div>
            </div>
          </section>
        </div>

        <!-- Right Column: Order Summary (Sticky Sidebar) -->
        <div class="lg:col-span-5 xl:col-span-4">
          <div class="sticky top-xl bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm p-lg flex flex-col gap-md">
            <h2 class="font-headline-md text-headline-md text-on-surface pb-sm border-b border-outline-variant">Booking Summary</h2>
            
            <!-- Consultant Details -->
            <div class="flex items-start gap-md py-sm">
              <img class="w-16 h-16 rounded-full object-cover border border-outline-variant" src="https://ui-avatars.com/api/?name=Sarah+Jenkins&background=random" >
              <div class="flex flex-col">
                <span class="font-label-md text-label-md text-on-surface">Strategic Tax Planning Session</span>
                <span class="font-body-sm text-body-sm text-on-surface-variant">with Sarah Jenkins, CPA</span>
              </div>
            </div>
            
            <!-- Date & Time -->
            <div class="bg-surface-container rounded-lg p-sm flex items-center gap-sm">
              <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 0;">event</span>
              <div class="flex flex-col">
                <span class="font-label-sm text-label-sm text-on-surface">Oct 24, 2024</span>
                <span class="font-body-sm text-body-sm text-on-surface-variant">2:00 PM - 3:00 PM EST</span>
              </div>
            </div>
            
            <div class="border-t border-outline-variant my-xs"/>
            
            <!-- Cost Breakdown -->
            <div class="flex flex-col gap-sm font-body-sm text-body-sm">
              <div class="flex justify-between items-center text-on-surface-variant">
                <span>Consultation Fee (1 hr)</span>
                <span>$250.00</span>
              </div>
              <div class="flex justify-between items-center text-on-surface-variant">
                <span>Platform Fee</span>
                <span>$12.50</span>
              </div>
              <div class="flex justify-between items-center font-label-md text-label-md text-on-surface pt-sm">
                <span>Total Due</span>
                <span class="text-primary font-bold text-lg">$262.50</span>
              </div>
            </div>
            
            <!-- CTA -->
            <button class="mt-md w-full bg-primary hover:brightness-90 text-on-primary font-label-md text-label-md py-md rounded-lg flex items-center justify-center gap-sm transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary shadow-sm" @click="$router.push('/checkout/success')">
              <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">lock</span>
              Confirm &amp; Pay $262.50
            </button>
            
            <!-- Trust Badges -->
            <div class="flex items-center justify-center gap-xs mt-sm text-on-surface-variant font-label-sm text-label-sm">
              <span class="material-symbols-outlined text-[16px]" style="font-variation-settings: 'FILL' 1;">verified_user</span>
              <span>Secure encrypted transaction</span>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup lang="ts">
definePageMeta({
  layout: false
})
</script>
