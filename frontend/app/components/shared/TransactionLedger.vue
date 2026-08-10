<template>
  <div>
    <h3 class="font-headline-sm mb-md">{{ title }}</h3>
    <UiBaseTable :columns="columns" :items="transactions" empty-text="No transactions found.">
      <template #cell-created_at="{ item }">
        <span class="font-body-sm">{{ new Date(item.created_at).toLocaleString() }}</span>
      </template>
      <template #cell-type="{ item }">
        <span class="inline-flex items-center px-2 py-1 rounded-sm text-xs font-medium uppercase" :class="getTypeClass(item.type)">
          {{ item.type }}
        </span>
      </template>
      <template #cell-description="{ item }">
        <span class="font-body-sm text-on-surface-variant">{{ item.description }}</span>
      </template>
      <template #cell-amount="{ item }">
        <span class="font-body-sm font-bold block" :class="parseFloat(item.amount) > 0 ? 'text-primary' : 'text-error'">
          {{ parseFloat(item.amount) > 0 ? '+' : '' }}${{ Math.abs(parseFloat(item.amount)).toFixed(2) }}
        </span>
      </template>
    </UiBaseTable>
  </div>
</template>

<script setup lang="ts">
const columns = [
  { key: 'created_at', label: 'Date' },
  { key: 'type', label: 'Type' },
  { key: 'description', label: 'Description' },
  { key: 'amount', label: 'Amount' }
]
defineProps({
  transactions: {
    type: Array as PropType<any[]>,
    default: () => []
  },
  title: {
    type: String,
    default: 'Transaction Ledger'
  }
})

const getTypeClass = (type: string) => {
  if (type === 'earning' || type === 'top_up' || type === 'platform_fee') {
    return 'bg-primary/10 text-primary'
  }
  if (type === 'payment' || type === 'withdrawal') {
    return 'bg-error/10 text-error'
  }
  return 'bg-surface-variant text-on-surface-variant'
}
</script>
