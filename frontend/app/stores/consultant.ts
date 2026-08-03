import { defineStore } from 'pinia'
import { shallowRef, ref, computed } from 'vue'

export interface Consultant {
  id: string
  name: string
  title: string
  hourlyRate: number
  rating: number
  reviewsCount: number
  avatar: string
  bio: string
  skills: string[]
  services: { id: string, name: string, durationMin: number, description: string, price: number }[]
}

export const useConsultantStore = defineStore('consultant', () => {
  const consultants = shallowRef<Consultant[]>([
    {
      id: '1',
      name: 'Sarah Jenkins',
      title: 'Senior UX Strategy Consultant',
      hourlyRate: 150,
      rating: 4.9,
      reviewsCount: 128,
      avatar: 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=200&q=80',
      bio: 'Helping SaaS startups optimize workflows and drive retention through actionable UX. I have 10+ years of experience redesigning B2B dashboards.',
      skills: ['Figma', 'Wireframing', 'User Research'],
      services: [
        { id: 's1', name: 'UX Strategy Audit', durationMin: 60, description: 'A complete teardown of your primary user flow.', price: 150 },
        { id: 's2', name: 'Design System Review', durationMin: 90, description: 'Evaluation of your component library.', price: 225 }
      ]
    },
    {
      id: '2',
      name: 'David Chen',
      title: 'Product Management Lead',
      hourlyRate: 200,
      rating: 5.0,
      reviewsCount: 84,
      avatar: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=200&q=80',
      bio: 'Scaling product teams from seed to Series C. I help you find PMF faster through rigorous user testing and market analysis.',
      skills: ['Agile', 'Roadmapping', 'GTM Strategy'],
      services: [
        { id: 's3', name: 'Product Strategy Session', durationMin: 60, description: '1-on-1 strategy call for your roadmap.', price: 200 }
      ]
    },
    {
      id: '3',
      name: 'Elena Rodriguez',
      title: 'Growth Marketing Expert',
      hourlyRate: 125,
      rating: 4.8,
      reviewsCount: 201,
      avatar: 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=200&q=80',
      bio: 'Specializing in B2B SaaS growth, paid acquisition, and SEO optimization. Let\'s scale your MRR.',
      skills: ['SEO', 'Paid Social', 'Conversion Rate Optimization'],
      services: [
        { id: 's4', name: 'SEO Technical Audit', durationMin: 60, description: 'Review of your landing pages.', price: 125 }
      ]
    }
  ])

  const searchQuery = ref('')
  
  const filteredConsultants = computed(() => {
    if (!searchQuery.value) return consultants.value
    const q = searchQuery.value.toLowerCase()
    return consultants.value.filter(c => 
      c.name.toLowerCase().includes(q) || 
      c.title.toLowerCase().includes(q) ||
      c.skills.some(s => s.toLowerCase().includes(q))
    )
  })

  function getConsultantById(id: string): Consultant | undefined {
    return consultants.value.find(c => c.id === id)
  }

  return {
    consultants,
    searchQuery,
    filteredConsultants,
    getConsultantById
  }
})
