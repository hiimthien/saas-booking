<template>
  <div class="p-margin-mobile md:p-lg xl:p-xl flex-1 w-full max-w-7xl mx-auto">
    <!-- Header -->
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-md mb-lg">
      <div>
        <h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface">Earnings & Payouts</h1>
        <p class="font-body-sm text-body-sm text-on-surface-variant mt-xs">Track your revenue and manage withdrawals.</p>
      </div>
      <div class="flex items-center gap-md">
        <UiBaseButton variant="outline" @click="fetchEarnings">
          <span class="material-symbols-outlined mr-2" :class="{ 'animate-spin': isFetching }">refresh</span>
          Refresh
        </UiBaseButton>
        <UiBaseButton variant="primary" @click="scrollToRequestPayout">
          <span class="material-symbols-outlined text-[18px] mr-2">account_balance</span>
          Request Payout
        </UiBaseButton>
      </div>
    </header>

    <div v-if="errorMsg" class="mb-lg p-sm bg-error-container text-on-error-container rounded-lg font-body-sm flex items-center gap-sm">
      <span class="material-symbols-outlined">error</span>
      {{ errorMsg }}
    </div>

    <!-- Bento Grid Layout -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-lg mb-lg">
      <!-- Key Metrics Cards -->
      <div class="md:col-span-12 grid grid-cols-1 md:grid-cols-3 gap-lg">
        <!-- Available Balance -->
        <UiBaseCard class="p-lg relative overflow-hidden group hover:border-primary transition-colors flex flex-col justify-between">
          <div class="absolute top-0 right-0 -mr-4 -mt-4 w-24 h-24 bg-primary/5 rounded-full blur-xl group-hover:bg-primary/10 transition-colors"/>
          <div>
            <div class="flex justify-between items-start mb-md">
              <h3 class="font-label-md text-label-md text-on-surface-variant">Available Balance</h3>
              <span class="material-symbols-outlined text-primary bg-primary-container/20 p-sm rounded-full">account_balance_wallet</span>
            </div>
            <div class="font-display-lg text-display-lg text-on-surface">${{ metrics.available_balance.toFixed(2) }}</div>
          </div>
          <p class="font-body-sm text-body-sm text-primary flex items-center gap-xs mt-md">
             Ready to withdraw
          </p>
        </UiBaseCard>

        <!-- Pending Earnings -->
        <UiBaseCard class="p-lg relative overflow-hidden group hover:border-secondary transition-colors flex flex-col justify-between">
          <div class="absolute top-0 right-0 -mr-4 -mt-4 w-24 h-24 bg-secondary/5 rounded-full blur-xl group-hover:bg-secondary/10 transition-colors"/>
          <div>
            <div class="flex justify-between items-start mb-md">
              <h3 class="font-label-md text-label-md text-on-surface-variant">Pending Clearing</h3>
              <span class="material-symbols-outlined text-secondary bg-secondary-container/20 p-sm rounded-full">hourglass_empty</span>
            </div>
            <div class="font-headline-lg text-headline-lg text-on-surface">${{ metrics.pending_clearing.toFixed(2) }}</div>
          </div>
          <p class="font-body-sm text-body-sm text-on-surface-variant mt-md">From upcoming consultations</p>
        </UiBaseCard>

        <!-- Total Withdrawn -->
        <UiBaseCard class="p-lg relative overflow-hidden group hover:border-tertiary transition-colors flex flex-col justify-between">
          <div>
            <div class="flex justify-between items-start mb-md">
              <h3 class="font-label-md text-label-md text-on-surface-variant">Total Withdrawn</h3>
              <span class="material-symbols-outlined text-tertiary bg-tertiary-container/20 p-sm rounded-full">paid</span>
            </div>
            <div class="font-headline-lg text-headline-lg text-on-surface">${{ metrics.total_withdrawn.toFixed(2) }}</div>
          </div>
          <p class="font-body-sm text-body-sm text-on-surface-variant mt-md">All time</p>
        </UiBaseCard>
      </div>

      <!-- Payout History Table -->
      <div class="md:col-span-12">
        <SharedTransactionLedger :transactions="transactions" title="Recent Transactions" />
      </div>
    </div>

    <!-- Payout Request Modal -->
    <UiBaseModal :isOpen="isPayoutModalOpen" title="Request Payout" @close="closePayoutModal">
      <div v-if="payoutSuccessMsg" class="mb-md p-sm bg-primary-container text-on-primary-container rounded-lg font-body-sm flex items-center gap-sm">
        <span class="material-symbols-outlined">check_circle</span>
        {{ payoutSuccessMsg }}
      </div>
      <div v-if="payoutErrorMsg" class="mb-md p-sm bg-error-container text-on-error-container rounded-lg font-body-sm flex items-center gap-sm">
        <span class="material-symbols-outlined">error</span>
        {{ payoutErrorMsg }}
      </div>

      <div class="bg-surface-container-low rounded-lg p-md mb-md">
        <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider mb-sm">Amount Available</p>
        <p class="font-headline-lg text-headline-lg text-primary mb-md">${{ metrics.available_balance.toFixed(2) }}</p>
        <div class="space-y-md">
          <div>
            <label class="block font-label-sm text-label-sm text-on-surface-variant mb-xs">Transfer to</label>
            <UiBaseInput v-model="payoutForm.bank_account" placeholder="e.g. Chase Bank (**** 1234)" required />
          </div>
          <div>
            <label class="block font-label-sm text-label-sm text-on-surface-variant mb-xs">Amount ($)</label>
            <UiBaseInput v-model="payoutForm.amount" type="number" step="0.01" min="1" :max="metrics.available_balance" placeholder="0.00" required />
          </div>
        </div>
      </div>
      <template #footer>
        <UiBaseButton variant="outline" @click="closePayoutModal">Cancel</UiBaseButton>
        <UiBaseButton variant="primary" @click="submitPayout" :disabled="isSubmitting || metrics.available_balance <= 0">
          <span v-if="isSubmitting" class="material-symbols-outlined animate-spin text-[18px] mr-2">progress_activity</span>
          Confirm Transfer
        </UiBaseButton>
      </template>
    </UiBaseModal>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useAuthStore } from '~/stores/auth'
import SharedTransactionLedger from '~/components/shared/TransactionLedger.vue'

definePageMeta({ layout: 'provider', middleware: ['auth'] })

const authStore = useAuthStore()

const isFetching = ref(false)
const errorMsg = ref('')

const isSubmitting = ref(false)
const payoutSuccessMsg = ref('')
const payoutErrorMsg = ref('')

const metrics = ref({
  total_earnings: 0,
  total_withdrawn: 0,
  pending_clearing: 0,
  available_balance: 0
})
const transactions = ref<any[]>([])

const payoutForm = ref({
  amount: null as number | null,
  bank_account: ''
})

const fetchEarnings = async () => {
  isFetching.value = true
  errorMsg.value = ''
  try {
    const res: any = await authStore.apiFetch('/provider/earnings')
    if (res.data) {
      metrics.value = {
        total_earnings: parseFloat(res.data.total_earnings) || 0,
        total_withdrawn: parseFloat(res.data.total_withdrawn) || 0,
        pending_clearing: parseFloat(res.data.pending_clearing) || 0,
        available_balance: parseFloat(res.data.available_balance) || 0
      }
      transactions.value = res.data.transactions || []
    }
  } catch (e: any) {
    console.error(e)
    errorMsg.value = e.data?.message || 'Failed to fetch earnings data.'
  } finally {
    isFetching.value = false
  }
}

const submitPayout = async () => {
  isSubmitting.value = true
  payoutSuccessMsg.value = ''
  payoutErrorMsg.value = ''
  try {
    const res: any = await authStore.apiFetch('/wallet/withdraw', {
      method: 'POST',
      body: payoutForm.value
    })
    
    payoutSuccessMsg.value = res.message || 'Withdrawal request submitted successfully.'
    payoutForm.value.amount = null
    
    // Refresh the data to show updated balance and new transaction
    await fetchEarnings()
    
    setTimeout(() => { payoutSuccessMsg.value = '' }, 4000)
  } catch (e: any) {
    console.error(e)
    payoutErrorMsg.value = e.data?.message || 'Failed to submit withdrawal request.'
  } finally {
    isSubmitting.value = false
  }
}

const isPayoutModalOpen = ref(false)

const openPayoutModal = () => {
  isPayoutModalOpen.value = true
}

const closePayoutModal = () => {
  isPayoutModalOpen.value = false
}

const scrollToRequestPayout = () => {
  openPayoutModal()
}

onMounted(() => {
  fetchEarnings()
})
</script>
