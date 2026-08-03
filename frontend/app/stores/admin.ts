import { defineStore } from 'pinia'
import { shallowRef, ref } from 'vue'

export const useAdminStore = defineStore('admin', () => {
  const pendingConsultants = shallowRef([
    { id: 'p1', name: 'Michael Chang', title: 'Data Science Consultant', applicationDate: 'Nov 1, 2023', status: 'Pending Review' },
    { id: 'p2', name: 'Sarah O\'Connor', title: 'Agile Coach', applicationDate: 'Oct 30, 2023', status: 'Under Review' },
  ])

  const platformSettings = ref({
    platformFeePercentage: 10,
    allowAutoApproval: false,
    maintenanceMode: false,
    supportEmail: 'support@consultflow.com'
  })

  function approveConsultant(id: string) {
    pendingConsultants.value = pendingConsultants.value.filter(c => c.id !== id)
  }

  function rejectConsultant(id: string) {
    pendingConsultants.value = pendingConsultants.value.filter(c => c.id !== id)
  }

  return {
    pendingConsultants,
    platformSettings,
    approveConsultant,
    rejectConsultant
  }
})
