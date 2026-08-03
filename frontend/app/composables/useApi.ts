import type { UseFetchOptions } from '#app'

export const useApi = <T>(url: string | (() => string), options: UseFetchOptions<T> = {}) => {
  const config = useRuntimeConfig()
  
  return useFetch(url, {
    ...options,
    // Connect to the Laravel API container inside docker-compose
    baseURL: config.public.apiBase || 'http://localhost:8000/api',
    // Example of passing authorization headers if token exists
    // headers: {
    //   Authorization: `Bearer ${token}`,
    //   Accept: 'application/json'
    // }
  })
}
