import { defineStore } from 'pinia'
import { shallowRef, ref } from 'vue'

export const useProviderStore = defineStore('provider', () => {
  const kpis = ref({
    totalEarnings: 4250.00,
    earningsGrowth: 12.5,
    completedConsultations: 28,
    upcomingBookings: 5
  })

  const upcomingConsultations = shallowRef([
    { id: 'c1', clientName: 'James D.', initials: 'JD', serviceName: 'UX Strategy Audit', date: 'Nov 3, 2023', time: '10:30 AM', duration: 60, status: 'Confirmed' },
    { id: 'c2', clientName: 'Alice W.', initials: 'AW', serviceName: 'Team Workshop', date: 'Nov 5, 2023', time: '02:00 PM', duration: 90, status: 'Pending' },
    { id: 'c3', clientName: 'Robert B.', initials: 'RB', serviceName: 'Design System Review', date: 'Nov 6, 2023', time: '09:00 AM', duration: 60, status: 'Confirmed' },
  ])

  const earningsHistory = shallowRef([
    { id: 'e1', date: 'Oct 28, 2023', description: 'Payout to Bank ****1234', amount: -1500.00, type: 'withdrawal' },
    { id: 'e2', date: 'Oct 25, 2023', description: 'Consultation with Emily R.', amount: 150.00, type: 'earning' },
    { id: 'e3', date: 'Oct 23, 2023', description: 'Consultation with TechCorp Inc.', amount: 450.00, type: 'earning' },
  ])

  return {
    kpis,
    upcomingConsultations,
    earningsHistory
  }
})
