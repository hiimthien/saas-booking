import { useCookie, useRuntimeConfig } from '#app'

export const useApiClient = () => {
  const config = useRuntimeConfig()
  const token = useCookie('auth_token')
  
  // Use internal Docker URL for SSR, public URL for client
  const baseURL = process.server ? config.apiBaseUrl : config.public.apiBase
  
  return $fetch.create({
    baseURL: baseURL as string,
    onRequest({ options }) {
      const headers = new Headers(options.headers || {})
      headers.set('Accept', 'application/json')
      
      if (token.value) {
        headers.set('Authorization', `Bearer ${token.value}`)
      }
      options.headers = headers
    }
  })
}
