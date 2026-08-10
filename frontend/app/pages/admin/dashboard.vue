<template>
  <div class="p-margin-mobile md:p-lg xl:p-xl flex-1 w-full max-w-7xl mx-auto">
    <header class="mb-lg flex justify-between items-center">
      <div>
        <h1 class="font-headline-lg text-headline-lg text-on-surface">Platform Overview</h1>
        <p class="font-body-md text-on-surface-variant mt-xs">High-level metrics for the SaaS Booking platform.</p>
      </div>
      <UiBaseButton variant="outline" @click="fetchDashboard">
        <span class="material-symbols-outlined mr-2" :class="{ 'animate-spin': isFetching }">refresh</span>
        Refresh
      </UiBaseButton>
    </header>

    <div v-if="errorMsg" class="mb-lg p-sm bg-error-container text-on-error-container rounded-lg font-body-sm flex items-center gap-sm">
      <span class="material-symbols-outlined">error</span>
      {{ errorMsg }}
    </div>

    <!-- Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-lg mb-lg">
      <UiBaseCard class="p-lg flex flex-col justify-between">
        <div class="flex justify-between items-start mb-md">
          <h3 class="font-label-md text-on-surface-variant">Total Users</h3>
          <span class="material-symbols-outlined text-primary bg-primary-container/20 p-sm rounded-full">group</span>
        </div>
        <div class="font-display-md text-on-surface">{{ stats.total_users }}</div>
      </UiBaseCard>
      
      <UiBaseCard class="p-lg flex flex-col justify-between">
        <div class="flex justify-between items-start mb-md">
          <h3 class="font-label-md text-on-surface-variant">Consultants</h3>
          <span class="material-symbols-outlined text-secondary bg-secondary-container/20 p-sm rounded-full">badge</span>
        </div>
        <div class="font-display-md text-on-surface">{{ stats.total_consultants }}</div>
      </UiBaseCard>
      
      <UiBaseCard class="p-lg flex flex-col justify-between">
        <div class="flex justify-between items-start mb-md">
          <h3 class="font-label-md text-on-surface-variant">Total Bookings</h3>
          <span class="material-symbols-outlined text-tertiary bg-tertiary-container/20 p-sm rounded-full">event</span>
        </div>
        <div class="font-display-md text-on-surface">{{ stats.total_bookings }}</div>
      </UiBaseCard>
      
      <UiBaseCard class="p-lg flex flex-col justify-between">
        <div class="flex justify-between items-start mb-md">
          <h3 class="font-label-md text-on-surface-variant">Platform Revenue</h3>
          <span class="material-symbols-outlined text-error bg-error-container/20 p-sm rounded-full">paid</span>
        </div>
        <div class="font-display-md text-on-surface">${{ stats.total_revenue.toFixed(2) }}</div>
      </UiBaseCard>
    </div>

    <!-- Chart -->
    <UiBaseCard class="p-lg w-full mb-lg">
      <div class="flex justify-between items-center mb-md">
        <h3 class="font-headline-sm text-on-surface">Platform Fee Revenue (30 Days)</h3>
      </div>
      <div class="h-64 w-full">
         <Bar v-if="chartData.labels" :data="chartData" :options="chartOptions" />
         <div v-else class="h-full flex items-center justify-center text-on-surface-variant">
           <span class="material-symbols-outlined animate-spin text-[32px]">progress_activity</span>
         </div>
      </div>
    </UiBaseCard>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useAuthStore } from '~/stores/auth'
import { Bar } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

definePageMeta({ layout: 'admin', middleware: ['auth'] }) // ideally also an admin middleware on client

const authStore = useAuthStore()

const isFetching = ref(false)
const errorMsg = ref('')

const stats = ref({
  total_users: 0,
  total_consultants: 0,
  total_bookings: 0,
  total_revenue: 0
})
const chartData = ref<any>({})

const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: { legend: { display: false } },
  scales: { y: { beginAtZero: true } }
}

const fetchDashboard = async () => {
  isFetching.value = true
  errorMsg.value = ''
  try {
    const res: any = await authStore.apiFetch('/admin/dashboard')
    if (res.data) {
      stats.value.total_users = res.data.total_users
      stats.value.total_consultants = res.data.total_consultants
      stats.value.total_bookings = res.data.total_bookings
      stats.value.total_revenue = parseFloat(res.data.total_revenue) || 0
      
      const labels = res.data.chart_data.map((d: any) => new Date(d.date).toLocaleDateString(undefined, { month: 'short', day: 'numeric' }))
      const data = res.data.chart_data.map((d: any) => d.total)
      chartData.value = {
        labels,
        datasets: [{ label: 'Platform Revenue', backgroundColor: '#8b5cf6', data }] // Purple for admin
      }
    }
  } catch (e: any) {
    console.error(e)
    errorMsg.value = e.data?.message || 'Failed to load dashboard data.'
  } finally {
    isFetching.value = false
  }
}

onMounted(() => {
  fetchDashboard()
})
</script>
