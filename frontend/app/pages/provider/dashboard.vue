<template>
  <div class="p-margin-mobile md:p-lg xl:p-xl flex-1 w-full max-w-7xl mx-auto">
    <!-- Header -->
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-md mb-lg">
      <div>
        <h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface">Welcome back, {{ authStore.user?.name }}!</h1>
        <p class="font-body-md text-on-surface-variant mt-xs">Here is what's happening with your consultations today.</p>
      </div>
      <div class="flex items-center gap-sm">
        <UiBaseButton variant="outline" @click="fetchDashboardData">
          <span class="material-symbols-outlined mr-2" :class="{ 'animate-spin': isFetching }">refresh</span>
          Refresh
        </UiBaseButton>
        <NuxtLink to="/provider/calendar">
          <UiBaseButton variant="primary">
            <span class="material-symbols-outlined mr-2">calendar_month</span>
            Manage Schedule
          </UiBaseButton>
        </NuxtLink>
      </div>
    </header>

    <div v-if="errorMsg" class="mb-lg p-sm bg-error-container text-on-error-container rounded-lg font-body-sm">{{ errorMsg }}</div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-lg mb-lg">
      <!-- High-level stats -->
      <UiBaseCard class="p-lg col-span-1 lg:col-span-1 flex flex-col justify-between">
        <div>
          <div class="flex justify-between items-start mb-md">
            <h3 class="font-label-md text-on-surface-variant">Available Balance</h3>
            <span class="material-symbols-outlined text-primary bg-primary-container/20 p-sm rounded-full">account_balance_wallet</span>
          </div>
          <div class="font-display-lg text-on-surface mb-sm">${{ walletBalance }}</div>
        </div>
        <NuxtLink to="/provider/earnings" class="text-primary font-label-sm hover:underline flex items-center">
          Withdraw Funds <span class="material-symbols-outlined text-[16px] ml-1">arrow_forward</span>
        </NuxtLink>
      </UiBaseCard>

      <UiBaseCard class="p-lg col-span-1 lg:col-span-2">
        <div class="flex justify-between items-center mb-md">
          <h3 class="font-label-md text-on-surface-variant">Revenue (Last 30 Days)</h3>
        </div>
        <div class="h-32">
           <Bar v-if="chartData.labels" :data="chartData" :options="chartOptions" />
        </div>
      </UiBaseCard>
    </div>

    <!-- Recent Bookings -->
    <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl shadow-sm overflow-hidden">
      <div class="p-lg border-b border-outline-variant bg-surface-container/30 flex justify-between items-center">
        <h2 class="font-headline-md">Upcoming Consultations</h2>
        <NuxtLink to="/provider/bookings" class="text-primary font-label-sm hover:underline">View All</NuxtLink>
      </div>
      
      <div class="p-md">
        <div v-if="isFetching" class="py-xl flex justify-center">
          <span class="material-symbols-outlined animate-spin text-primary text-[32px]">progress_activity</span>
        </div>
        <div v-else-if="bookings.length === 0" class="py-2xl flex flex-col items-center justify-center text-on-surface-variant">
          <div class="w-16 h-16 rounded-full bg-surface-container flex items-center justify-center mb-md">
             <span class="material-symbols-outlined text-[32px]">event_busy</span>
          </div>
          <p class="font-body-lg">No upcoming bookings</p>
          <p class="font-body-sm mt-xs">You don't have any consultations scheduled yet.</p>
        </div>
        <div v-else class="space-y-md">
          <SharedBookingList :bookings="bookings.slice(0, 3)" role="provider" />
        </div>
      </div>
    </div>

  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useAuthStore } from '~/stores/auth'
import SharedBookingList from '~/components/shared/BookingList.vue'
import { Bar } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

definePageMeta({ layout: 'provider', middleware: ['auth'] })

const authStore = useAuthStore()

const isFetching = ref(false)
const errorMsg = ref('')

const bookings = ref<any[]>([])
const walletBalance = ref('0')
const chartData = ref<any>({})

const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: { legend: { display: false } },
  scales: { y: { beginAtZero: true } }
}

const fetchDashboardData = async () => {
  isFetching.value = true
  errorMsg.value = ''
  try {
    const balanceRes: any = await authStore.apiFetch('/wallet/balance')
    walletBalance.value = balanceRes.data.balance

    const chartRes: any = await authStore.apiFetch('/wallet/chart')
    const labels = chartRes.data.map((d: any) => new Date(d.date).toLocaleDateString(undefined, { month: 'short', day: 'numeric' }))
    const data = chartRes.data.map((d: any) => d.total)
    chartData.value = {
      labels,
      datasets: [{ label: 'Revenue', backgroundColor: '#059669', data }]
    }

    const bookingsRes: any = await authStore.apiFetch('/bookings')
    bookings.value = bookingsRes.data

  } catch (e: any) {
    console.error(e)
    errorMsg.value = e.data?.message || 'Failed to load dashboard data. Please try again.'
  } finally {
    isFetching.value = false
  }
}

onMounted(() => {
  fetchDashboardData()
})
</script>
