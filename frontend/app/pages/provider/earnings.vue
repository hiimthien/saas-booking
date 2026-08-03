<template>
  <div class="p-margin-mobile md:p-lg xl:p-xl w-full flex-1">
    <!-- Header -->
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-md mb-lg">
      <div>
        <h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface">Earnings &amp; Payouts</h1>
        <p class="font-body-sm text-body-sm text-on-surface-variant mt-xs">Track your revenue and manage withdrawals.</p>
      </div>
      <div class="flex items-center gap-md">
        <div class="bg-surface-container rounded-xl p-xs flex items-center shadow-sm border border-outline-variant">
          <UiSelect :options="[{value:'Last 30 Days',label:'Last 30 Days'},{value:'This Quarter',label:'This Quarter'},{value:'This Year',label:'This Year'},{value:'All Time',label:'All Time'}]" model-value="Last 30 Days" class="bg-transparent border-none [&>select]:py-xs [&>select]:pl-sm [&>select]:pr-lg [&>select]:bg-transparent [&>select]:border-none" />
        </div>
        <UiButton variant="primary">
          <span class="material-symbols-outlined text-[18px]">account_balance</span>
          Request Payout
        </UiButton>
      </div>
    </header>

    <!-- Bento Grid Layout -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-lg mb-lg">
      <!-- Key Metrics Cards -->
      <div class="md:col-span-12 grid grid-cols-1 md:grid-cols-3 gap-lg">
        <!-- Available Balance -->
        <UiCard class="p-lg relative overflow-hidden group hover:border-primary transition-colors">
          <div class="absolute top-0 right-0 -mr-4 -mt-4 w-24 h-24 bg-primary/5 rounded-full blur-xl group-hover:bg-primary/10 transition-colors"/>
          <div class="flex justify-between items-start mb-md">
            <h3 class="font-label-md text-label-md text-on-surface-variant">Available Balance</h3>
            <span class="material-symbols-outlined text-primary bg-primary-container/20 p-sm rounded-full">account_balance_wallet</span>
          </div>
          <div class="font-display-lg text-display-lg text-on-surface">$4,250.00</div>
          <p class="font-body-sm text-body-sm text-primary flex items-center gap-xs mt-sm">
            <span class="material-symbols-outlined text-[16px]">trending_up</span>
            +12% vs last month
          </p>
        </UiCard>
        <!-- Pending Earnings -->
        <UiCard class="p-lg relative overflow-hidden group hover:border-secondary transition-colors">
          <div class="absolute top-0 right-0 -mr-4 -mt-4 w-24 h-24 bg-secondary/5 rounded-full blur-xl group-hover:bg-secondary/10 transition-colors"/>
          <div class="flex justify-between items-start mb-md">
            <h3 class="font-label-md text-label-md text-on-surface-variant">Pending Clearing</h3>
            <span class="material-symbols-outlined text-secondary bg-secondary-container/20 p-sm rounded-full">hourglass_empty</span>
          </div>
          <div class="font-headline-lg text-headline-lg text-on-surface">$850.00</div>
          <p class="font-body-sm text-body-sm text-on-surface-variant mt-sm">Clearing in 2-3 business days</p>
        </UiCard>
        <!-- Total Withdrawn -->
        <UiCard class="p-lg relative overflow-hidden group hover:border-tertiary transition-colors">
          <div class="flex justify-between items-start mb-md">
            <h3 class="font-label-md text-label-md text-on-surface-variant">Total Withdrawn</h3>
            <span class="material-symbols-outlined text-tertiary bg-tertiary-container/20 p-sm rounded-full">paid</span>
          </div>
          <div class="font-headline-lg text-headline-lg text-on-surface">$28,450.00</div>
          <p class="font-body-sm text-body-sm text-on-surface-variant mt-sm">Year to date</p>
        </UiCard>
      </div>

      <!-- Quick Action / Payout Request -->
      <UiCard class="md:col-span-12 lg:col-span-6 p-lg flex flex-col">
        <h2 class="font-headline-md text-headline-md text-on-surface mb-md">Request Payout</h2>
        <div class="bg-surface-container-low rounded-lg p-md mb-md flex-1">
          <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider mb-sm">Amount Available</p>
          <p class="font-headline-lg text-headline-lg text-primary mb-md">$4,250.00</p>
          <div class="space-y-md">
            <div>
              <label class="block font-label-sm text-label-sm text-on-surface-variant mb-xs">Transfer to</label>
              <UiSelect :options="[{value:'Chase Checking (**** 1234)', label:'Chase Checking (**** 1234)'},{value:'Wells Fargo (**** 5678)', label:'Wells Fargo (**** 5678)'},{value:'Add new bank account...', label:'Add new bank account...'}]" model-value="Chase Checking (**** 1234)" />
            </div>
            <div>
              <label class="block font-label-sm text-label-sm text-on-surface-variant mb-xs">Amount</label>
              <UiInput type="number" model-value="4250.00">
                <template #icon>
                  <span class="text-on-surface-variant material-symbols-outlined text-[18px]">attach_money</span>
                </template>
              </UiInput>
            </div>
          </div>
        </div>
        <UiButton block variant="primary">
          Confirm Transfer
        </UiButton>
      </UiCard>

      <!-- Payout History Table -->
      <UiCard class="md:col-span-12 lg:col-span-6 p-0 overflow-hidden flex flex-col">
        <div class="p-lg border-b border-outline-variant flex justify-between items-center">
          <h2 class="font-headline-md text-headline-md text-on-surface">Recent Transactions</h2>
          <button class="text-primary font-label-md text-label-md hover:underline flex items-center gap-xs">
            View All <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
          </button>
        </div>
        <div class="overflow-x-auto flex-1">
          <table class="w-full text-left border-collapse">
            <thead>
              <tr class="bg-surface-container-low border-b border-outline-variant">
                <th class="py-sm px-lg font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Date</th>
                <th class="py-sm px-lg font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Description</th>
                <th class="py-sm px-lg font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider text-right">Amount</th>
                <th class="py-sm px-lg font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider text-center">Status</th>
              </tr>
            </thead>
            <tbody class="font-body-sm text-body-sm text-on-surface divide-y divide-outline-variant">
              <tr class="hover:bg-surface-container-low/50 transition-colors">
                <td class="py-md px-lg">Oct 24, 2023</td>
                <td class="py-md px-lg font-medium">Payout to Bank</td>
                <td class="py-md px-lg text-right font-medium">-$1,500.00</td>
                <td class="py-md px-lg text-center">
                  <UiBadge variant="neutral">Processing</UiBadge>
                </td>
              </tr>
              <tr class="hover:bg-surface-container-low/50 transition-colors">
                <td class="py-md px-lg">Oct 21, 2023</td>
                <td class="py-md px-lg font-medium">Consultation: Strategy Sync</td>
                <td class="py-md px-lg text-right font-medium text-primary">+$250.00</td>
                <td class="py-md px-lg text-center">
                  <UiBadge variant="success">Cleared</UiBadge>
                </td>
              </tr>
              <tr class="hover:bg-surface-container-low/50 transition-colors">
                <td class="py-md px-lg">Oct 18, 2023</td>
                <td class="py-md px-lg font-medium">Payout to Bank</td>
                <td class="py-md px-lg text-right font-medium">-$2,000.00</td>
                <td class="py-md px-lg text-center">
                  <UiBadge variant="success">Completed</UiBadge>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </UiCard>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({
  layout: 'provider'
})
</script>
