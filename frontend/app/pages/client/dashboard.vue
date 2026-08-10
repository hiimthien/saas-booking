<template>
  <div class="min-h-screen bg-surface-container-lowest font-body-md text-on-surface">
    <!-- Header -->
    <header class="bg-surface-container-lowest border-b border-outline-variant sticky top-0 z-20 shadow-sm">
      <div class="max-w-7xl mx-auto px-lg py-sm flex justify-between items-center">
        <div class="flex items-center gap-md">
          <NuxtLink to="/" class="flex items-center gap-sm">
            <div class="inline-flex items-center justify-center w-10 h-10 bg-primary-container text-on-primary-container rounded-xl">
              <span class="material-symbols-outlined text-[20px]">vpn_key</span>
            </div>
            <span class="font-headline-sm hidden md:block">ConsultFlow</span>
          </NuxtLink>
        </div>
        <div class="flex items-center gap-md">
          <div class="flex items-center gap-sm bg-surface-container px-md py-xs rounded-full">
            <img v-if="authStore.user?.avatar_url" :src="backendUrl(authStore.user.avatar_url)" class="w-8 h-8 rounded-full object-cover" />
            <div v-else class="w-8 h-8 rounded-full bg-primary text-on-primary flex items-center justify-center font-label-md">
              {{ authStore.user?.name?.charAt(0).toUpperCase() }}
            </div>
            <span class="font-label-md hidden md:block">{{ authStore.user?.name }}</span>
          </div>
          <button @click="authStore.logout" class="text-error hover:bg-error-container hover:text-on-error-container p-sm rounded-full transition-colors flex items-center">
            <span class="material-symbols-outlined">logout</span>
          </button>
        </div>
      </div>
    </header>

    <main class="max-w-7xl mx-auto px-lg py-xl flex flex-col md:flex-row gap-xl">
      <!-- Sidebar Navigation -->
      <aside class="md:w-64 flex-shrink-0">
        <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl p-sm shadow-sm sticky top-[100px]">
          <nav class="space-y-xs flex flex-col">
            <UiBaseButton 
              v-for="tab in tabs" :key="tab.id" 
              @click="setActiveTab(tab.id)"
              :variant="activeTab === tab.id ? 'primary' : 'ghost'"
              class="w-full justify-start text-left"
            >
              <template #icon-left>
                <span class="material-symbols-outlined mr-2">{{ tab.icon }}</span>
              </template>
              {{ tab.label }}
            </UiBaseButton>
          </nav>
        </div>
      </aside>

      <!-- Content Area -->
      <div class="flex-1 min-w-0">
        <Transition name="fade" mode="out-in">
          
          <!-- 1. Profile Tab -->
          <div v-if="activeTab === 'profile'" class="bg-surface-container-lowest border border-outline-variant rounded-2xl shadow-sm overflow-hidden">
            <div class="p-lg border-b border-outline-variant bg-surface-container/30">
              <h2 class="font-headline-md">Profile Settings</h2>
              <p class="font-body-sm text-on-surface-variant">Manage your personal information and avatar.</p>
            </div>
            <form @submit.prevent="saveProfile" class="p-lg space-y-xl">
              <!-- Avatar Section -->
              <div class="flex items-center gap-lg">
                <div class="relative group">
                  <div class="w-24 h-24 rounded-full border-4 border-surface-container-lowest shadow-md overflow-hidden bg-surface-container flex items-center justify-center">
                    <img v-if="avatarPreview || authStore.user?.avatar_url" :src="avatarPreview || backendUrl(authStore.user?.avatar_url)" class="w-full h-full object-cover" />
                    <span v-else class="material-symbols-outlined text-[40px] text-on-surface-variant">person</span>
                  </div>
                  <label class="absolute inset-0 bg-black/50 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                    <span class="material-symbols-outlined">upload</span>
                    <input type="file" class="hidden" accept="image/*" @change="handleFileChange">
                  </label>
                </div>
                <div>
                  <h3 class="font-label-lg">Profile Picture</h3>
                  <p class="font-body-sm text-on-surface-variant mb-sm">JPG, GIF or PNG. Max size of 2MB.</p>
                  <button type="button" @click="$el?.querySelector('input[type=file]')?.click()" class="px-md py-xs border border-outline-variant rounded-lg font-label-md hover:bg-surface-container transition-colors">
                    Change Avatar
                  </button>
                </div>
              </div>

              <!-- Form Fields -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-lg">
                <UiBaseInput v-model="profileForm.name" label="Full Name" required />
                <UiBaseInput :modelValue="authStore.user?.email || ''" label="Email Address" disabled />
                <UiBaseInput v-model="profileForm.phone" label="Phone Number" placeholder="+1 (555) 000-0000" />
              </div>
              <div v-if="successMsg" class="p-sm bg-primary-container text-on-primary-container rounded-lg font-body-sm">{{ successMsg }}</div>
              <div v-if="errorMsg" class="p-sm bg-error-container text-error rounded-lg font-body-sm">{{ errorMsg }}</div>
              <div class="flex justify-end pt-md border-t border-outline-variant">
                <UiBaseButton type="submit" :loading="isSaving" :disabled="isSaving">
                  Save Changes
                </UiBaseButton>
              </div>
            </form>
          </div>

          <!-- 2. Bookings Tab -->
          <div v-else-if="activeTab === 'bookings'" class="bg-surface-container-lowest border border-outline-variant rounded-2xl shadow-sm overflow-hidden">
             <div class="p-lg border-b border-outline-variant bg-surface-container/30 flex justify-between items-center">
              <div>
                <h2 class="font-headline-md">My Consultations</h2>
                <p class="font-body-sm text-on-surface-variant">View your upcoming and past bookings.</p>
              </div>
              <button @click="fetchData('bookings')" class="p-sm rounded-full hover:bg-surface-container text-primary transition-colors flex items-center">
                 <span class="material-symbols-outlined" :class="{ 'animate-spin': isFetching }">refresh</span>
              </button>
            </div>
            <div class="p-md space-y-md">
              <SharedBookingList :bookings="bookings" role="client" />
            </div>
          </div>

          <!-- 3. Billing & Wallet Tab -->
          <div v-else-if="activeTab === 'billing'" class="bg-surface-container-lowest border border-outline-variant rounded-2xl shadow-sm overflow-hidden">
             <div class="p-lg border-b border-outline-variant bg-surface-container/30 flex justify-between items-center">
              <div>
                <h2 class="font-headline-md">My Wallet & Transactions</h2>
                <p class="font-body-sm text-on-surface-variant">Top up your wallet and view transaction history.</p>
              </div>
            </div>
            
            <div class="p-lg">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-lg mb-xl">
                <!-- Wallet Balance Card -->
                <SharedWalletCard :balance="walletBalance" />

                <!-- Top-up Card -->
                <div class="bg-surface-container rounded-2xl p-lg border border-outline-variant flex flex-col justify-center">
                  <h3 class="font-headline-sm mb-sm">Top Up Wallet</h3>
                  <form @submit.prevent="topUpWallet" class="flex gap-sm">
                    <UiBaseInput v-model="topupAmount" type="number" placeholder="Amount ($)" class="flex-1" required />
                    <UiBaseButton type="submit" :loading="isToppingUp" :disabled="isToppingUp">
                      Top Up
                    </UiBaseButton>
                  </form>
                  <div v-if="successMsg" class="mt-sm text-primary font-label-sm">{{ successMsg }}</div>
                  <div v-if="errorMsg" class="mt-sm text-error font-label-sm">{{ errorMsg }}</div>
                </div>
              </div>

              <SharedTransactionLedger :transactions="payments" title="Transaction Ledger" />
            </div>
          </div>

          <!-- 4. Reviews Tab -->
          <div v-else-if="activeTab === 'reviews'" class="bg-surface-container-lowest border border-outline-variant rounded-2xl shadow-sm overflow-hidden">
             <div class="p-lg border-b border-outline-variant bg-surface-container/30">
              <h2 class="font-headline-md">My Reviews</h2>
              <p class="font-body-sm text-on-surface-variant">Reviews you have left for consultants.</p>
            </div>
            <div class="p-md space-y-md">
              <div v-if="reviews.length === 0" class="py-2xl flex flex-col items-center justify-center text-on-surface-variant">
                <span class="material-symbols-outlined text-[32px] mb-sm">rate_review</span>
                <p>You haven't reviewed any consultants yet.</p>
              </div>
              <div v-for="review in reviews" :key="review.id" class="p-md border border-outline-variant rounded-xl bg-surface">
                <div class="flex items-center gap-xs mb-sm text-amber-500">
                  <span v-for="i in 5" :key="i" class="material-symbols-outlined text-[18px]">
                    {{ i <= review.rating ? 'star' : 'star_border' }}
                  </span>
                </div>
                <p class="font-body-md italic mb-md">"{{ review.comment }}"</p>
                <div class="font-label-sm text-on-surface-variant text-right">- For {{ review.consultantProfile?.user?.name }}</div>
              </div>
            </div>
          </div>

          <!-- 5. Favorites Tab -->
          <div v-else-if="activeTab === 'favorites'" class="bg-surface-container-lowest border border-outline-variant rounded-2xl shadow-sm overflow-hidden">
             <div class="p-lg border-b border-outline-variant bg-surface-container/30">
              <h2 class="font-headline-md">Saved Consultants</h2>
              <p class="font-body-sm text-on-surface-variant">Your favorite consultants for quick booking.</p>
            </div>
            <div class="p-md">
              <div v-if="favorites.length === 0" class="py-2xl flex flex-col items-center justify-center text-on-surface-variant">
                <span class="material-symbols-outlined text-[32px] mb-sm">favorite_border</span>
                <p>No saved consultants.</p>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                <div v-for="fav in favorites" :key="fav.id" class="p-md border border-outline-variant rounded-xl flex items-center gap-md">
                  <div class="w-12 h-12 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary-container">
                    {{ fav.user?.name?.charAt(0) }}
                  </div>
                  <div class="flex-1">
                    <h4 class="font-label-lg">{{ fav.user?.name }}</h4>
                    <p class="font-body-sm text-on-surface-variant">{{ fav.title }}</p>
                  </div>
                  <button class="text-error hover:bg-error-container p-sm rounded-full transition-colors flex items-center" title="Remove">
                    <span class="material-symbols-outlined">heart_broken</span>
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- 6. Notifications Tab -->
          <div v-else-if="activeTab === 'notifications'" class="bg-surface-container-lowest border border-outline-variant rounded-2xl shadow-sm overflow-hidden">
             <div class="p-lg border-b border-outline-variant bg-surface-container/30">
              <h2 class="font-headline-md">Notification Settings</h2>
              <p class="font-body-sm text-on-surface-variant">Manage how you receive alerts and updates.</p>
            </div>
            <form @submit.prevent="saveNotificationSettings" class="p-lg space-y-md">
              <label class="flex items-center justify-between p-md border border-outline-variant rounded-xl hover:bg-surface cursor-pointer">
                <div>
                  <h4 class="font-label-md">Email Reminders</h4>
                  <p class="font-body-sm text-on-surface-variant">Receive email reminders 24h before a consultation.</p>
                </div>
                <input type="checkbox" v-model="notificationSettings.email_reminders" class="w-5 h-5 text-primary focus:ring-primary rounded border-outline-variant">
              </label>
              
              <label class="flex items-center justify-between p-md border border-outline-variant rounded-xl hover:bg-surface cursor-pointer">
                <div>
                  <h4 class="font-label-md">Marketing & Promotions</h4>
                  <p class="font-body-sm text-on-surface-variant">Receive discount codes and special offers.</p>
                </div>
                <input type="checkbox" v-model="notificationSettings.marketing" class="w-5 h-5 text-primary focus:ring-primary rounded border-outline-variant">
              </label>
              
              <div v-if="successMsg" class="p-sm bg-primary-container text-on-primary-container rounded-lg font-body-sm mt-md">{{ successMsg }}</div>
              <div v-if="errorMsg" class="p-sm bg-error-container text-error rounded-lg font-body-sm mt-md">{{ errorMsg }}</div>
              
              <div class="flex justify-end pt-md">
                <button type="submit" class="px-xl py-sm bg-primary text-on-primary rounded-xl font-label-md hover:bg-surface-tint transition-all shadow-sm">
                  Save Preferences
                </button>
              </div>
            </form>
          </div>

        </Transition>
      </div>
    </main>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useAuthStore } from '~/stores/auth'
import { useRuntimeConfig } from '#app'
import SharedWalletCard from '~/components/shared/WalletCard.vue'
import SharedTransactionLedger from '~/components/shared/TransactionLedger.vue'
import SharedBookingList from '~/components/shared/BookingList.vue'

definePageMeta({ layout: false, middleware: ['auth'] })

const authStore = useAuthStore()
const config = useRuntimeConfig()

const tabs = [
  { id: 'profile', label: 'Profile Settings', icon: 'person' },
  { id: 'bookings', label: 'My Bookings', icon: 'calendar_month' },
  { id: 'billing', label: 'Wallet & Billing', icon: 'account_balance_wallet' },
  { id: 'reviews', label: 'My Reviews', icon: 'rate_review' },
  { id: 'favorites', label: 'Saved Consultants', icon: 'favorite' },
  { id: 'notifications', label: 'Notification Settings', icon: 'notifications' }
]

const activeTab = ref('profile')
const isSaving = ref(false)
const successMsg = ref('')
const errorMsg = ref('')
const isFetching = ref(false)

const profileForm = ref({
  name: authStore.user?.name || '',
  phone: (authStore.user as any)?.phone || ''
})
const selectedFile = ref<File | null>(null)
const avatarPreview = ref<string | null>(null)

const notificationSettings = ref({
  email_reminders: (authStore.user as any)?.notification_settings?.email_reminders ?? true,
  marketing: (authStore.user as any)?.notification_settings?.marketing ?? false,
})

const bookings = ref<any[]>([])
const payments = ref<any[]>([])
const reviews = ref<any[]>([])
const favorites = ref<any[]>([])

const walletBalance = ref('0')
const topupAmount = ref<number | null>(null)
const isToppingUp = ref(false)

const backendUrl = (path: string | undefined) => {
  if (!path) return ''
  if (path.startsWith('http')) return path
  const base = (config.public.apiBase as string).replace('/api', '')
  return `${base}${path}`
}

const setActiveTab = (tabId: string) => {
  activeTab.value = tabId
  fetchData(tabId)
}

const handleFileChange = (e: Event) => {
  const target = e.target as HTMLInputElement
  if (target.files && target.files[0]) {
    selectedFile.value = target.files[0]
    avatarPreview.value = URL.createObjectURL(target.files[0])
  }
}

const saveProfile = async () => {
  isSaving.value = true
  successMsg.value = ''
  
  const formData = new FormData()
  formData.append('name', profileForm.value.name)
  if (profileForm.value.phone) formData.append('phone', profileForm.value.phone)
  if (selectedFile.value) formData.append('avatar', selectedFile.value)

  try {
    await authStore.apiFetch('/profile/client', { method: 'POST', body: formData })
    await authStore.fetchUser()
    successMsg.value = 'Profile updated successfully!'
    setTimeout(() => successMsg.value = '', 3000)
  } catch (e: any) {
    errorMsg.value = e.response?._data?.message || 'Update failed'
  } finally {
    isSaving.value = false
  }
}

const saveNotificationSettings = async () => {
  successMsg.value = ''
  try {
    await authStore.apiFetch('/client/notifications/settings', {
      method: 'POST',
      body: { settings: notificationSettings.value }
    })
    await authStore.fetchUser()
    successMsg.value = 'Preferences saved successfully!'
    setTimeout(() => successMsg.value = '', 3000)
  } catch (e) {
    console.error(e)
  }
}

const fetchData = async (tab: string) => {
  isFetching.value = true
  try {
    if (tab === 'bookings') {
      const res: any = await authStore.apiFetch('/bookings')
      bookings.value = res.data
    } else if (tab === 'billing') {
      const balanceRes: any = await authStore.apiFetch('/wallet/balance')
      walletBalance.value = balanceRes.data.balance

      const txRes: any = await authStore.apiFetch('/wallet/transactions')
      payments.value = txRes.data.data
    } else if (tab === 'reviews') {
      const res: any = await authStore.apiFetch('/client/reviews')
      reviews.value = res.data
    } else if (tab === 'favorites') {
      const res: any = await authStore.apiFetch('/client/favorites')
      favorites.value = res.data
    }
  } catch (e) {
    console.error(e)
  } finally {
    isFetching.value = false
  }
}

const topUpWallet = async () => {
  if (!topupAmount.value || topupAmount.value <= 0) return
  isToppingUp.value = true
  successMsg.value = ''
  try {
    const res: any = await authStore.apiFetch('/wallet/topup', { method: 'POST', body: { amount: topupAmount.value } })
    
    // If Stripe is configured, it will return a checkout_url
    if (res.checkout_url) {
      window.location.href = res.checkout_url
      return
    }

    // Fallback for mocked top up
    successMsg.value = res.message || `Successfully topped up $${topupAmount.value}!`
    topupAmount.value = null
    fetchData('billing')
    setTimeout(() => successMsg.value = '', 3000)
  } catch (e: any) {
    errorMsg.value = e.response?._data?.message || 'Top-up failed'
  } finally {
    isToppingUp.value = false
  }
}

onMounted(() => {
  fetchData('profile')
})
</script>
