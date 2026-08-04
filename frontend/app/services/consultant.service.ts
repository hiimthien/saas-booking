import { useApiClient } from '~/utils/api'
import type { ConsultantProfile } from '~/types'

interface ConsultantsResponse {
  data: ConsultantProfile[]
  meta: {
    current_page: number
    last_page: number
    per_page: number
    total: number
  }
}

export const useConsultantService = () => {
  const api = useApiClient()

  const getConsultants = async (params: Record<string, any> = {}) => {
    // Build query string
    const query = new URLSearchParams()
    for (const [key, value] of Object.entries(params)) {
      if (value !== undefined && value !== null && value !== '') {
        query.append(key, String(value))
      }
    }
    const queryString = query.toString()
    const url = `/consultants${queryString ? `?${queryString}` : ''}`

    return await api<ConsultantsResponse>(url, {
      method: 'GET'
    })
  }

  const getConsultantBySlug = async (slug: string) => {
    return await api<{ data: ConsultantProfile }>(`/consultants/${slug}`, {
      method: 'GET'
    })
  }

  return {
    getConsultants,
    getConsultantBySlug
  }
}
