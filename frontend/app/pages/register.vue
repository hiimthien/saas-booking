<template>
  <div class="bg-background min-h-screen antialiased text-on-surface">
    <main class="flex min-h-screen w-full">
      <!-- Left Side: Form Area -->
      <section class="flex flex-col justify-center w-full lg:w-1/2 px-margin-mobile md:px-xl lg:px-2xl xl:px-[10%] py-xl lg:py-0 bg-surface-container-lowest">
        <div class="w-full max-w-md mx-auto">
          <!-- Brand / Logo -->
          <div class="mb-xl">
            <NuxtLink to="/" class="font-headline-md text-headline-md text-primary flex items-center gap-xs hover:opacity-90 transition-opacity">
              <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">dataset</span>
              ConsultFlow
            </NuxtLink>
          </div>
          
          <!-- Headers -->
          <div class="mb-xl">
            <h1 class="font-display-lg text-display-lg text-on-surface mb-xs hidden md:block">Create an account</h1>
            <h1 class="font-headline-lg-mobile text-headline-lg-mobile text-on-surface mb-xs md:hidden">Create an account</h1>
            <p class="font-body-md text-body-md text-on-surface-variant">Join ConsultFlow to book world-class experts or offer your services.</p>
          </div>
          
          <!-- Form -->
          <form class="space-y-lg" @submit.prevent="onSubmit">
            <div v-if="errorMsg" class="p-md bg-error-container text-on-error-container rounded-lg font-body-sm text-center">
              {{ errorMsg }}
            </div>
            
            <div>
              <UiBaseInput
                id="fullname"
                v-model="fullname"
                v-bind="fullnameProps"
                type="text"
                label="Full Name"
                floating
              />
              <span v-if="errors.fullname" class="text-error font-body-sm mt-1 inline-block">{{ errors.fullname }}</span>
            </div>

            <div>
              <UiBaseInput
                id="email"
                v-model="email"
                v-bind="emailProps"
                type="email"
                label="Email address"
                floating
              />
              <span v-if="errors.email" class="text-error font-body-sm mt-1 inline-block">{{ errors.email }}</span>
            </div>
            
            <div>
              <UiBaseInput
                id="password"
                v-model="password"
                v-bind="passwordProps"
                type="password"
                label="Password"
                floating
              />
              <span v-if="errors.password" class="text-error font-body-sm mt-1 inline-block">{{ errors.password }}</span>
            </div>
            
            <!-- Actions Row -->
            <div>
              <div class="flex items-center mt-sm mb-lg">
                <UiBaseCheckbox
                  id="terms"
                  v-model="terms"
                  v-bind="termsProps"
                  label="I agree to the Terms of Service and Privacy Policy"
                />
              </div>
              <span v-if="errors.terms" class="text-error font-body-sm mt-1 inline-block">{{ errors.terms }}</span>
            </div>
            
            <!-- Submit Button -->
            <UiBaseButton type="submit" block variant="primary">
              Create account
            </UiBaseButton>
          </form>
          
          <!-- Divider -->
          <div class="mt-xl mb-lg relative">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
              <div class="w-full border-t border-outline-variant"/>
            </div>
            <div class="relative flex justify-center text-sm">
              <span class="bg-surface-container-lowest px-sm font-body-sm text-body-sm text-on-surface-variant">Or sign up with</span>
            </div>
          </div>
          
          <!-- OAuth Buttons -->
          <div class="grid grid-cols-2 gap-md">
            <!-- Google Auth -->
            <a href="http://localhost:8000/api/auth/google/redirect" class="w-full flex items-center justify-center gap-sm bg-surface-container-lowest border border-outline-variant text-on-surface py-sm px-md rounded-lg font-label-md hover:bg-surface-container-low transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary">
              <svg class="w-5 h-5" viewBox="0 0 24 24">
                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
              </svg>
              Google
            </a>
            <UiBaseButton type="button" variant="outline" class="flex items-center justify-center gap-sm">
              <svg class="h-5 w-5" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 0H0V10H10V0Z" fill="#F25022"/>
                <path d="M21 0H11V10H21V0Z" fill="#7FBA00"/>
                <path d="M10 11H0V21H10V11Z" fill="#00A4EF"/>
                <path d="M21 11H11V21H21V11Z" fill="#FFB900"/>
              </svg>
              Microsoft
            </UiBaseButton>
          </div>
          
          <!-- Footer Sign In Link -->
          <p class="mt-xl text-center font-body-sm text-body-sm text-on-surface-variant">
            Already have an account? 
            <NuxtLink to="/login" class="font-label-md text-label-md text-primary hover:text-primary-container transition-colors">Sign in</NuxtLink>
          </p>
        </div>
      </section>
      
      <!-- Right Side: Visual Presentation -->
      <section class="hidden lg:flex flex-col lg:w-1/2 relative bg-inverse-surface overflow-hidden">
        <!-- Abstract Background Illustration -->
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat opacity-60 mix-blend-luminosity" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCoEjl4n3T4x5NNsSb0kQ5I0Gb68FHfX1N3nKI2c9VNjvuOF6fK8F5iSqGAqxSIe_aZZk9ibMPkVASCRgY53SvLNOmWtl91MLehfj9ExPCAk0TxUxlAILT2HBnBWYtSOUi0IxzuXr62EUvQBOIse-04eq27CFNxhsdFSp17EyRxLHL7W9pLjGuRJfNDHjwY2IdLw1wmoL0K2xJ3zwX6ksMG4y3RZFEclFsWaGJJLiRzpV4PaVsiyd2atA')"/>
        <!-- Gradient Overlay for Brand Identity -->
        <div class="absolute inset-0 bg-gradient-to-br from-inverse-surface/95 via-inverse-surface/80 to-secondary-container/30"/>
        <!-- Decorative Grid Pattern -->
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 32px 32px;"/>
        
        <!-- Content Area (Overlapping Background) -->
        <div class="relative z-10 flex flex-col justify-between h-full p-2xl">
          <!-- Top Badge/Tagline -->
          <div class="flex justify-end">
            <span class="inline-flex items-center rounded-full bg-surface-tint/20 px-sm py-xs font-label-sm text-label-sm text-primary-fixed border border-primary-fixed-dim/30 backdrop-blur-sm">
              <span class="w-1.5 h-1.5 rounded-full bg-primary-fixed mr-2 animate-pulse"/>
              Enterprise Grade Security
            </span>
          </div>
          
          <!-- Testimonial / Social Proof -->
          <div class="mt-auto max-w-lg bg-surface-variant/10 backdrop-blur-md rounded-2xl p-lg border border-outline-variant/20 shadow-2xl">
            <div class="mb-sm text-primary-fixed-dim opacity-80">
              <span class="material-symbols-outlined text-[32px]">format_quote</span>
            </div>
            <p class="font-headline-md text-headline-md text-on-error mb-lg leading-snug">
              "ConsultFlow completely transformed how we manage our internal resources. The interface is stunningly clean, and the data visualization tools saved us hundreds of hours in reporting alone."
            </p>
            <div class="flex items-center gap-md">
              <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-primary-fixed/30">
                <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuCaovRgDTizoUt6z3GYAc7hiEkdmBcxARVsuK-rNt0_Zq7v1Y5ABPib2e84mY2M0ZaDaHq5VAEJYRTw6FD1ekjuDO0glReof7e0Oyz9Wgrztjnh1KrsRzDc20YqxvMNf1W9CHY0tVtlCxixSGAcfm-ImVbTQnQJBBio18Vgx1TsoaHTTG-jABPvx7k7AVDtQZzvJP1C1dCmF9Fot-62n2qJ3VQMKUQgXnftElN_neewifcBhE6mLHV4fw" alt="Sarah Jenkins" class="w-full h-full object-cover" >
              </div>
              <div>
                <h4 class="font-label-md text-label-md text-on-error">Sarah Jenkins</h4>
                <p class="font-body-sm text-body-sm text-tertiary-fixed-dim">Operations Director, TechNova Inc.</p>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '~/stores/auth'
import { useForm } from 'vee-validate'
import { toTypedSchema } from '@vee-validate/zod'
import { registerSchema } from '~/utils/validations'

definePageMeta({
  layout: false
})

const router = useRouter()
const authStore = useAuthStore()
const errorMsg = ref('')
const loading = ref(false)

const { handleSubmit, errors, defineField } = useForm({
  validationSchema: toTypedSchema(registerSchema),
})

const [fullname, fullnameProps] = defineField('fullname')
const [email, emailProps] = defineField('email')
const [password, passwordProps] = defineField('password')
const [terms, termsProps] = defineField('terms')

const onSubmit = handleSubmit(async (values) => {
  errorMsg.value = ''
  loading.value = true
  try {
    await authStore.register({ 
      name: values.fullname, 
      email: values.email, 
      password: values.password,
      password_confirmation: values.password 
    })
  } catch (e: any) {
    errorMsg.value = e
  } finally {
    loading.value = false
  }
})
</script>
