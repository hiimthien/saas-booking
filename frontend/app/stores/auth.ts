import { defineStore } from 'pinia'
import { ref } from 'vue'
import { useCookie, useRouter, useRuntimeConfig } from '#app'
import { AuthService } from '~/services/auth.service'
import type { User } from '~/types'

export const useAuthStore = defineStore('auth', () => {
  const user = ref<User | null>(null)
  const token = useCookie('auth_token', { maxAge: 60 * 60 * 24 * 30 }) // 30 days
  const router = useRouter()
  const config = useRuntimeConfig()

  const apiFetch = $fetch.create({
    baseURL: config.public.apiBase as string,
    onRequest({ options }) {
      const headers = new Headers(options.headers || {})
      headers.set('Accept', 'application/json')
      
      if (token.value) {
        headers.set('Authorization', `Bearer ${token.value}`)
      }
      options.headers = headers
    }
  })

  const authService = new AuthService(apiFetch as any)

  const login = async (credentials: any) => {
    try {
      const response = await authService.login(credentials)
      user.value = response.user
      token.value = response.token
      
      if (user.value.role === 'admin') {
        router.push('/admin/dashboard')
      } else if (user.value.role === 'consultant') {
        router.push('/provider/dashboard')
      } else {
        router.push('/client/dashboard')
      }
      return true
    } catch (error: any) {
      throw error.data?.message || 'Thông tin đăng nhập không hợp lệ.'
    }
  }

  const register = async (data: any) => {
    try {
      const response = await authService.register(data)
      user.value = response.user
      token.value = response.token
      router.push('/client/dashboard')
      return true
    } catch (error: any) {
      throw error.data?.message || 'Đăng ký thất bại, vui lòng kiểm tra lại thông tin.'
    }
  }

  const logout = async () => {
    try {
      if (token.value) {
        await authService.logout()
      }
    } catch (e) {
      console.error(e)
    } finally {
      user.value = null
      token.value = null
      router.push('/login')
    }
  }

  const fetchUser = async () => {
    if (!token.value) return null
    try {
      const response: any = await apiFetch('/user')
      user.value = response
      return user.value
    } catch (e) {
      console.error('Failed to fetch user', e)
      return null
    }
  }

  return { user, token, login, register, logout, fetchUser, apiFetch }
})
