<template>
  <div class="p-margin-mobile md:p-lg xl:p-xl flex-1 w-full max-w-7xl mx-auto">
    <header class="mb-lg flex justify-between items-center">
      <div>
        <h1 class="font-headline-lg text-headline-lg text-on-surface">Consultant Approvals</h1>
        <p class="font-body-md text-on-surface-variant mt-xs">Review and approve new consultant registrations.</p>
      </div>
      <UiBaseButton variant="outline" @click="fetchConsultants">
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
      <h2 class="font-headline-md">Pending & Active Consultants</h2>
    </div>

    <UiBaseTable :columns="columns" :items="consultants" :loading="isFetching" empty-text="No consultants found.">
      <template #cell-consultant="{ item }">
        <div class="flex items-center gap-sm">
          <div class="w-10 h-10 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold">
            {{ item.user?.name?.charAt(0).toUpperCase() || 'C' }}
          </div>
          <div>
            <div class="font-medium text-on-surface">{{ item.user?.name || 'Unknown' }}</div>
            <div class="text-xs text-on-surface-variant">{{ item.user?.email || '' }}</div>
          </div>
        </div>
      </template>
      <template #cell-title_bio="{ item }">
        <div class="font-medium text-on-surface">{{ item.title || 'No Title' }}</div>
        <div class="text-xs text-on-surface-variant truncate max-w-[200px]" :title="item.bio">{{ item.bio || 'No bio provided.' }}</div>
      </template>
      <template #cell-hourly_rate="{ item }">
        <div class="font-medium">${{ item.hourly_rate }}</div>
      </template>
      <template #cell-actions="{ item }">
        <div class="flex items-center justify-end gap-sm">
          <button @click="approve(item.id)" class="px-sm py-xs bg-primary text-on-primary text-xs rounded-lg font-bold hover:bg-primary-container hover:text-on-primary-container transition-colors shadow-sm">
            Approve
          </button>
          <button @click="reject(item.id)" class="px-sm py-xs border border-error text-error text-xs rounded-lg font-bold hover:bg-error-container hover:text-on-error-container transition-colors">
            Reject
          </button>
        </div>
      </template>
    </UiBaseTable>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useAuthStore } from '~/stores/auth'

definePageMeta({ layout: 'admin', middleware: ['auth'] })

const authStore = useAuthStore()

const isFetching = ref(false)
const consultants = ref<any[]>([])
const successMsg = ref('')
const errorMsg = ref('')

const columns = [
  { key: 'consultant', label: 'Consultant' },
  { key: 'title_bio', label: 'Title & Bio' },
  { key: 'hourly_rate', label: 'Hourly Rate' },
  { key: 'actions', label: 'Actions' }
]

const fetchConsultants = async () => {
  isFetching.value = true
  errorMsg.value = ''
  try {
    const res: any = await authStore.apiFetch('/admin/consultants/pending')
    consultants.value = res.data
  } catch (e: any) {
    console.error(e)
    errorMsg.value = e.data?.message || 'Failed to fetch consultants.'
  } finally {
    isFetching.value = false
  }
}

const approve = async (id: number) => {
  errorMsg.value = ''
  successMsg.value = ''
  try {
    const res: any = await authStore.apiFetch(`/admin/consultants/${id}/approve`, { method: 'POST' })
    successMsg.value = res.message
    setTimeout(() => { successMsg.value = '' }, 3000)
    // Conceptually we'd update UI here
  } catch (e: any) {
    console.error(e)
    errorMsg.value = e.data?.message || 'Failed to approve.'
  }
}

const reject = async (id: number) => {
  errorMsg.value = ''
  successMsg.value = ''
  try {
    const res: any = await authStore.apiFetch(`/admin/consultants/${id}/reject`, { method: 'POST' })
    successMsg.value = res.message
    setTimeout(() => { successMsg.value = '' }, 3000)
    // Conceptually we'd update UI here
  } catch (e: any) {
    console.error(e)
    errorMsg.value = e.data?.message || 'Failed to reject.'
  }
}

onMounted(() => {
  fetchConsultants()
})
</script>
