<template>
  <div class="p-margin-mobile md:p-lg xl:p-xl flex-1 w-full max-w-7xl mx-auto">
    <header class="mb-lg flex justify-between items-center">
      <div>
        <h1 class="font-headline-lg text-headline-lg text-on-surface">Financial Ledger</h1>
        <p class="font-body-md text-on-surface-variant mt-xs">Monitor all platform transactions and manage payouts.</p>
      </div>
      <UiBaseButton variant="outline" @click="fetchTransactions">
        <span class="material-symbols-outlined mr-2" :class="{ 'animate-spin': isFetching }">refresh</span>
        Refresh
      </UiBaseButton>
    </header>

    <div v-if="successMsg" class="mb-lg p-sm bg-primary-container text-on-primary-container rounded-lg font-body-sm flex items-center gap-sm">
      <span class="material-symbols-outlined">check_circle</span>
      {{ successMsg }}
    </div>
    <div v-if="errorMsg" class="mb-lg p-sm bg-error-container text-on-error-container rounded-lg font-body-sm flex items-center gap-sm">
      <span class="material-symbols-outlined">error</span>
      {{ errorMsg }}
    </div>

    <div class="mb-lg p-md border-b border-outline-variant bg-surface-container/30 rounded-t-2xl">
      <h2 class="font-headline-md">All Transactions</h2>
    </div>

    <UiBaseTable :columns="columns" :items="transactions" :loading="isFetching" empty-text="No transactions found.">
      <template #cell-created_at="{ item }">
        <span class="font-medium text-on-surface whitespace-nowrap">
          {{ new Date(item.created_at).toLocaleString() }}
        </span>
      </template>
      <template #cell-user="{ item }">
        <div class="font-medium text-on-surface">{{ item.wallet?.user?.name || 'Unknown User' }}</div>
        <div class="text-xs text-on-surface-variant">{{ item.wallet?.user?.email || 'Unknown Email' }}</div>
      </template>
      <template #cell-type_desc="{ item }">
        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase mb-1 inline-block"
          :class="{
            'bg-primary/20 text-primary': item.type === 'earning',
            'bg-error/20 text-error': item.type === 'withdrawal',
            'bg-secondary/20 text-secondary': item.type === 'payment',
            'bg-tertiary/20 text-tertiary': item.type === 'platform_fee',
          }">
          {{ item.type }}
        </span>
        <div class="text-sm text-on-surface">{{ item.description }}</div>
      </template>
      <template #cell-amount="{ item }">
        <div class="text-right font-medium" :class="item.amount > 0 ? 'text-primary' : (item.amount < 0 ? 'text-error' : '')">
          {{ item.amount > 0 ? '+' : '' }}${{ Math.abs(item.amount).toFixed(2) }}
        </div>
      </template>
      <template #cell-status="{ item }">
        <div class="text-center">
          <span v-if="item.status === 'completed'" class="px-2 py-1 bg-primary-container text-on-primary-container text-xs rounded-full font-bold">Completed</span>
          <span v-else-if="item.status === 'pending'" class="px-2 py-1 bg-surface-variant text-on-surface-variant text-xs rounded-full font-bold">Pending</span>
          <span v-else class="px-2 py-1 bg-error-container text-on-error-container text-xs rounded-full font-bold">Failed</span>
        </div>
      </template>
      <template #cell-actions="{ item }">
        <div class="text-right">
          <button v-if="item.type === 'withdrawal' && item.status === 'pending'" @click="confirmPayout(item)" class="px-sm py-xs bg-primary text-on-primary text-xs rounded-lg font-bold hover:bg-primary-container hover:text-on-primary-container transition-colors shadow-sm whitespace-nowrap">
            Mark as Paid
          </button>
        </div>
      </template>
    </UiBaseTable>

    <!-- Payout Confirmation Modal -->
    <UiBaseModal :isOpen="isPayoutModalOpen" title="Confirm Payout" @close="closePayoutModal">
      <p class="font-body-md text-on-surface mb-md">
        Are you sure you have manually transferred <strong class="text-error">${{ Math.abs(txToApprove?.amount || 0).toFixed(2) }}</strong> to this provider?
      </p>
      <p class="font-body-sm text-on-surface-variant mb-lg">
        Marking this as paid cannot be undone.
      </p>
      <template #footer>
        <UiBaseButton variant="outline" @click="closePayoutModal">Cancel</UiBaseButton>
        <UiBaseButton variant="primary" @click="approvePayout">
          Confirm Payment
        </UiBaseButton>
      </template>
    </UiBaseModal>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useAuthStore } from '~/stores/auth'

definePageMeta({ layout: 'admin', middleware: ['auth'] })

const authStore = useAuthStore()

const isFetching = ref(false)
const transactions = ref<any[]>([])
const successMsg = ref('')
const errorMsg = ref('')

const columns = [
  { key: 'created_at', label: 'Date' },
  { key: 'user', label: 'User / Wallet' },
  { key: 'type_desc', label: 'Type & Description' },
  { key: 'amount', label: 'Amount' },
  { key: 'status', label: 'Status' },
  { key: 'actions', label: 'Action' }
]

const fetchTransactions = async () => {
  isFetching.value = true
  errorMsg.value = ''
  try {
    const res: any = await authStore.apiFetch('/admin/transactions')
    transactions.value = res.data
  } catch (e: any) {
    console.error(e)
    errorMsg.value = e.data?.message || 'Failed to fetch transactions.'
  } finally {
    isFetching.value = false
  }
}

const isPayoutModalOpen = ref(false)
const txToApprove = ref<any>(null)

const confirmPayout = (tx: any) => {
  txToApprove.value = tx
  isPayoutModalOpen.value = true
}

const closePayoutModal = () => {
  isPayoutModalOpen.value = false
  txToApprove.value = null
}

const approvePayout = async () => {
  if (!txToApprove.value) return
  errorMsg.value = ''
  successMsg.value = ''
  try {
    const res: any = await authStore.apiFetch(`/admin/transactions/${txToApprove.value.id}/approve`, { method: 'POST' })
    successMsg.value = res.message
    await fetchTransactions()
    setTimeout(() => { successMsg.value = '' }, 3000)
    closePayoutModal()
  } catch (e: any) {
    console.error(e)
    errorMsg.value = e.data?.message || 'Failed to approve payout.'
    closePayoutModal()
  }
}

onMounted(() => {
  fetchTransactions()
})
</script>
