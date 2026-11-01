<template>
  <div class="max-w-container-max mx-auto w-full px-margin-mobile md:px-gutter py-lg md:py-xl flex flex-col gap-lg">
    <!-- Header -->
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-md border-b border-outline-variant pb-md">
      <div>
        <h1 class="font-headline-lg-mobile md:font-headline-lg text-on-surface">Notifications</h1>
        <p class="font-body-md text-on-surface-variant mt-xs">
          {{ unreadCount > 0 ? `You have ${unreadCount} unread notification${unreadCount > 1 ? 's' : ''}.` : 'All caught up! No unread notifications.' }}
        </p>
      </div>
      <div class="flex items-center gap-sm">
        <button 
          v-if="unreadCount > 0"
          @click="markAllAsRead"
          :disabled="isMarkingAll"
          class="flex items-center gap-sm px-md py-sm bg-surface-container-lowest border border-outline-variant text-on-surface font-label-md rounded-lg hover:bg-surface-variant transition-colors shadow-sm disabled:opacity-50"
        >
          <span class="material-symbols-outlined text-[18px]">done_all</span>
          {{ isMarkingAll ? 'Marking...' : 'Mark all as read' }}
        </button>
      </div>
    </header>

    <!-- Filters/Tabs -->
    <div class="flex gap-sm overflow-x-auto pb-sm scrollbar-hide">
      <button 
        v-for="tab in tabs" 
        :key="tab.id"
        @click="activeTab = tab.id"
        :class="[
          'whitespace-nowrap px-md py-sm font-label-md rounded-full transition-colors text-sm',
          activeTab === tab.id 
            ? 'bg-primary text-on-primary shadow-sm' 
            : 'bg-surface-container-lowest border border-outline-variant text-on-surface-variant hover:bg-surface-variant'
        ]"
      >
        {{ tab.label }}
      </button>
    </div>

    <!-- Notification Feed -->
    <div v-if="pending" class="flex flex-col gap-md py-xl items-center text-on-surface-variant">
      <span class="material-symbols-outlined animate-spin text-3xl text-primary">progress_activity</span>
      <p class="font-body-sm mt-2">Loading notifications...</p>
    </div>

    <div v-else-if="filteredNotifications.length === 0" class="py-2xl text-center flex flex-col items-center gap-sm bg-surface-container-lowest border border-outline-variant rounded-xl p-xl">
      <span class="material-symbols-outlined text-5xl text-outline-variant">notifications_off</span>
      <h3 class="font-headline-md text-on-surface mt-sm">No notifications</h3>
      <p class="font-body-sm text-on-surface-variant max-w-sm">
        You don't have any notifications in this section right now.
      </p>
    </div>

    <div v-else class="flex flex-col gap-md">
      <div 
        v-for="item in filteredNotifications" 
        :key="item.id"
        :class="[
          'relative flex flex-col md:flex-row gap-md p-md md:p-lg bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant overflow-hidden group hover:shadow-md transition-shadow',
          !item.read_at ? 'bg-primary/5' : ''
        ]"
      >
        <!-- Unread Indicator Line -->
        <div v-if="!item.read_at" class="absolute left-0 top-0 bottom-0 w-1 bg-primary" />

        <!-- Notification Icon / Avatar -->
        <div 
          class="flex-shrink-0 w-12 h-12 rounded-full flex items-center justify-center text-white"
          :class="getCategoryBg(item.data?.category || 'system')"
        >
          <span class="material-symbols-outlined text-[24px]">
            {{ getCategoryIcon(item.data?.category || 'system') }}
          </span>
        </div>

        <!-- Content -->
        <div class="flex-1 flex flex-col gap-xs">
          <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-xs">
            <div>
              <span 
                class="inline-block px-sm py-0.5 font-label-sm text-[11px] rounded uppercase tracking-wider mb-xs"
                :class="getCategoryBadgeClass(item.data?.category || 'system')"
              >
                {{ item.data?.category || 'System' }}
              </span>
              <h3 class="font-label-md font-semibold text-on-surface">
                {{ item.data?.title || 'Notification' }}
              </h3>
            </div>
            
            <div class="flex items-center gap-xs font-label-sm text-xs text-on-surface-variant">
              <span v-if="!item.read_at" class="w-2 h-2 rounded-full bg-primary" />
              <span>{{ formatTime(item.created_at) }}</span>
            </div>
          </div>

          <p class="font-body-sm text-on-surface-variant mt-xs">
            {{ item.data?.message || item.data?.body || '' }}
          </p>

          <!-- Actions -->
          <div class="flex items-center gap-sm mt-sm">
            <NuxtLink 
              v-if="item.data?.action_url"
              :to="item.data.action_url"
              class="px-md py-sm bg-primary text-on-primary font-label-md text-xs rounded-lg hover:bg-primary/90 transition-colors shadow-sm inline-flex items-center gap-1"
            >
              <span>{{ item.data?.action_text || 'View Details' }}</span>
              <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </NuxtLink>

            <button 
              v-if="!item.read_at"
              @click="markAsRead(item.id)"
              class="px-sm py-1 border border-outline-variant text-on-surface font-label-sm text-xs rounded-lg hover:bg-surface-variant transition-colors"
            >
              Mark read
            </button>

            <button 
              @click="deleteNotification(item.id)"
              class="px-sm py-1 text-on-surface-variant hover:text-error font-label-sm text-xs rounded-lg hover:bg-error/10 transition-colors ml-auto"
              title="Delete notification"
            >
              <span class="material-symbols-outlined text-[16px]">delete</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { useApiClient } from '~/utils/api'

useHead({
  title: 'Notification Center | ConsultFlow'
})

interface NotificationItem {
  id: string
  type: string
  data: {
    title?: string
    message?: string
    body?: string
    category?: 'booking' | 'payment' | 'system'
    action_url?: string
    action_text?: string
  }
  read_at: string | null
  created_at: string
}

const api = useApiClient()
const activeTab = ref('all')
const isMarkingAll = ref(false)

const tabs = [
  { id: 'all', label: 'All Activity' },
  { id: 'booking', label: 'Booking Updates' },
  { id: 'payment', label: 'Payments' },
  { id: 'system', label: 'System' }
]

const { data: response, pending, refresh } = await useAsyncData('notifications', () => 
  api<{ data: NotificationItem[], unread_count: number }>('/notifications')
)

const notifications = computed(() => response.value?.data || [])
const unreadCount = computed(() => response.value?.unread_count || 0)

const filteredNotifications = computed(() => {
  if (activeTab.value === 'all') {
    return notifications.value
  }
  return notifications.value.filter(n => n.data?.category === activeTab.value)
})

const getCategoryBg = (cat: string) => {
  switch (cat) {
    case 'booking': return 'bg-secondary-container'
    case 'payment': return 'bg-primary'
    default: return 'bg-tertiary-container'
  }
}

const getCategoryIcon = (cat: string) => {
  switch (cat) {
    case 'booking': return 'calendar_month'
    case 'payment': return 'payments'
    default: return 'notifications'
  }
}

const getCategoryBadgeClass = (cat: string) => {
  switch (cat) {
    case 'booking': return 'bg-secondary-container text-on-secondary-container'
    case 'payment': return 'bg-primary/20 text-primary font-medium'
    default: return 'bg-surface-variant text-on-surface-variant'
  }
}

const formatTime = (iso: string) => {
  if (!iso) return ''
  const date = new Date(iso)
  const now = new Date()
  const diffMs = now.getTime() - date.getTime()
  const diffMins = Math.floor(diffMs / 60000)
  const diffHours = Math.floor(diffMins / 60)
  const diffDays = Math.floor(diffHours / 24)

  if (diffMins < 1) return 'Just now'
  if (diffMins < 60) return `${diffMins}m ago`
  if (diffHours < 24) return `${diffHours}h ago`
  return `${diffDays}d ago`
}

const markAsRead = async (id: string) => {
  try {
    await api(`/notifications/${id}/read`, { method: 'POST' })
    const target = notifications.value.find(n => n.id === id)
    if (target) {
      target.read_at = new Date().toISOString()
    }
    if (response.value && response.value.unread_count > 0) {
      response.value.unread_count--
    }
  } catch (err) {
    console.error('Failed to mark notification as read:', err)
  }
}

const markAllAsRead = async () => {
  try {
    isMarkingAll.value = true
    await api('/notifications/read-all', { method: 'POST' })
    notifications.value.forEach(n => {
      n.read_at = new Date().toISOString()
    })
    if (response.value) {
      response.value.unread_count = 0
    }
  } catch (err) {
    console.error('Failed to mark all as read:', err)
  } finally {
    isMarkingAll.value = false
  }
}

const deleteNotification = async (id: string) => {
  try {
    await api(`/notifications/${id}`, { method: 'DELETE' })
    if (response.value) {
      response.value.data = response.value.data.filter(n => n.id !== id)
    }
  } catch (err) {
    console.error('Failed to delete notification:', err)
  }
}
</script>

