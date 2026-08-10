export default defineNuxtRouteMiddleware((to, from) => {
  const token = useCookie('auth_token')
  
  // If no token exists, redirect to login page
  if (!token.value) {
    return navigateTo('/login')
  }
})
