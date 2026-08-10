<template>
  <div class="p-margin-mobile md:p-lg xl:p-xl flex-1 w-full max-w-7xl mx-auto">
    <header class="mb-lg flex justify-between items-center">
      <div>
        <h1 class="font-headline-lg text-headline-lg text-on-surface">User Management</h1>
        <p class="font-body-md text-on-surface-variant mt-xs">View and manage all registered users.</p>
      </div>
      <UiBaseButton variant="outline" @click="fetchUsers">
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

    <UiBaseTable :columns="columns" :items="users" :loading="isFetching" empty-text="No users found.">
      <template #cell-name="{ item }">
        <span class="font-medium text-on-surface">{{ item.name }}</span>
      </template>
      <template #cell-role="{ item }">
        <span class="px-2 py-1 rounded-full text-xs font-bold uppercase"
          :class="{
            'bg-primary-container text-on-primary-container': item.role === 'admin',
            'bg-secondary-container text-on-secondary-container': item.role === 'provider',
            'bg-tertiary-container text-on-tertiary-container': item.role === 'client'
          }">
          {{ item.role }}
        </span>
      </template>
      <template #cell-status="{ item }">
        <span class="px-2 py-1 bg-primary-container text-on-primary-container text-xs rounded-full font-bold">Active</span>
      </template>
      <template #cell-actions="{ item }">
        <button v-if="item.id !== authStore.user?.id" @click="confirmBan(item)" class="text-error hover:bg-error-container hover:text-on-error-container p-sm rounded-full transition-colors flex items-center justify-center ml-auto" title="Suspend User">
          <span class="material-symbols-outlined text-[20px]">block</span>
        </button>
      </template>
    </UiBaseTable>

    <!-- Ban Confirmation Modal -->
    <UiBaseModal :isOpen="isBanModalOpen" title="Confirm Suspension" @close="closeBanModal">
      <p class="font-body-md text-on-surface mb-lg">Are you sure you want to suspend the user <strong>{{ userToBan?.name }}</strong>?</p>
      <template #footer>
        <UiBaseButton variant="outline" @click="closeBanModal">Cancel</UiBaseButton>
        <UiBaseButton variant="primary" class="!bg-error !text-on-error !border-error hover:!bg-error/90" @click="toggleBan">
          Suspend User
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
const users = ref<any[]>([])
const successMsg = ref('')
const errorMsg = ref('')

const columns = [
  { key: 'name', label: 'Name' },
  { key: 'email', label: 'Email' },
  { key: 'role', label: 'Role' },
  { key: 'status', label: 'Status' },
  { key: 'actions', label: 'Actions' }
]

const fetchUsers = async () => {
  isFetching.value = true
  errorMsg.value = ''
  try {
    const res: any = await authStore.apiFetch('/admin/users')
    users.value = res.data
  } catch (e: any) {
    console.error(e)
    errorMsg.value = e.data?.message || 'Failed to fetch users.'
  } finally {
    isFetching.value = false
  }
}

const isBanModalOpen = ref(false)
const userToBan = ref<any>(null)

const confirmBan = (user: any) => {
  userToBan.value = user
  isBanModalOpen.value = true
}

const closeBanModal = () => {
  isBanModalOpen.value = false
  userToBan.value = null
}

const toggleBan = async () => {
  if (!userToBan.value) return
  errorMsg.value = ''
  successMsg.value = ''
  try {
    const res: any = await authStore.apiFetch(`/admin/users/${userToBan.value.id}/toggle-ban`, { method: 'POST' })
    successMsg.value = res.message
    setTimeout(() => { successMsg.value = '' }, 3000)
    closeBanModal()
  } catch (e: any) {
    console.error(e)
    errorMsg.value = e.data?.message || 'Failed to ban user.'
    closeBanModal()
  }
}

onMounted(() => {
  fetchUsers()
})
</script>
