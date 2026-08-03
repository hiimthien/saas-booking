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
          <form class="space-y-lg" @submit.prevent="handleRegister">
            
            <UiInput
              id="fullname"
              v-model="fullname"
              type="text"
              label="Full Name"
              floating
              required
            />

            <UiInput
              id="email"
              v-model="email"
              type="email"
              label="Email address"
              floating
              required
            />
            
            <UiInput
              id="password"
              v-model="password"
              type="password"
              label="Password"
              floating
              required
            />
            
            <!-- Actions Row -->
            <div class="flex items-center mt-sm mb-lg">
              <input id="terms" name="terms" type="checkbox" required class="h-4 w-4 rounded border-outline-variant text-primary focus:ring-secondary bg-surface-container-lowest transition-colors cursor-pointer" >
              <label for="terms" class="ml-sm block font-body-sm text-body-sm text-on-surface-variant cursor-pointer">
                I agree to the <a href="#" class="text-secondary hover:underline">Terms of Service</a> and <a href="#" class="text-secondary hover:underline">Privacy Policy</a>
              </label>
            </div>
            
            <!-- Submit Button -->
            <UiButton type="submit" block variant="primary">
              Create account
            </UiButton>
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
            <UiButton type="button" variant="outline" class="flex items-center justify-center gap-sm">
              <svg class="h-5 w-5" aria-hidden="true" viewBox="0 0 24 24">
                <path d="M12.0003 4.75C13.7703 4.75 15.3553 5.36 16.6053 6.54998L20.0303 3.125C17.9502 1.19 15.2353 0 12.0003 0C7.31028 0 3.25527 2.69 1.28027 6.60998L5.27028 9.70498C6.21525 6.86002 8.87028 4.75 12.0003 4.75Z" fill="#EA4335"/>
                <path d="M23.49 12.275C23.49 11.49 23.415 10.73 23.3 10H12V14.51H18.47C18.18 15.99 17.34 17.25 16.08 18.1L19.945 21.1C22.2 19.01 23.49 15.92 23.49 12.275Z" fill="#4285F4"/>
                <path d="M5.26498 14.2949C5.02498 13.5699 4.88501 12.7999 4.88501 11.9999C4.88501 11.1999 5.01998 10.4299 5.26498 9.7049L1.275 6.60986C0.46 8.22986 0 10.0599 0 11.9999C0 13.9399 0.46 15.7699 1.28 17.3899L5.26498 14.2949Z" fill="#FBBC05"/>
                <path d="M12.0004 24.0001C15.2404 24.0001 17.9654 22.935 19.9454 21.095L16.0804 18.095C15.0054 18.82 13.6204 19.245 12.0004 19.245C8.8704 19.245 6.21537 17.135 5.26538 14.29L1.27539 17.385C3.25539 21.31 7.3104 24.0001 12.0004 24.0001Z" fill="#34A853"/>
              </svg>
              Google
            </UiButton>
            <UiButton type="button" variant="outline" class="flex items-center justify-center gap-sm">
              <svg class="h-5 w-5" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 0H0V10H10V0Z" fill="#F25022"/>
                <path d="M21 0H11V10H21V0Z" fill="#7FBA00"/>
                <path d="M10 11H0V21H10V11Z" fill="#00A4EF"/>
                <path d="M21 11H11V21H21V11Z" fill="#FFB900"/>
              </svg>
              Microsoft
            </UiButton>
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

definePageMeta({
  layout: false
})

const router = useRouter()
const email = ref('')
const password = ref('')

const handleRegister = () => {
  router.push('/onboarding')
}
</script>
