<template>
  <div class="h-screen bg-background font-body-md text-on-background flex flex-col antialiased">
    <main class="flex-grow flex items-center justify-center p-margin-mobile md:p-lg relative overflow-hidden">
      <!-- Abstract Background Decoration -->
      <div class="absolute inset-0 pointer-events-none overflow-hidden z-0 flex items-center justify-center opacity-40">
        <div class="w-[800px] h-[800px] bg-primary-fixed-dim rounded-full blur-[120px] mix-blend-multiply opacity-20 transform -translate-x-1/2 -translate-y-1/2 absolute top-1/4 left-1/4"/>
        <div class="w-[600px] h-[600px] bg-secondary-fixed rounded-full blur-[100px] mix-blend-multiply opacity-20 transform translate-x-1/3 translate-y-1/3 absolute bottom-1/4 right-1/4"/>
      </div>
      
      <div class="w-full max-w-md relative z-10">
        <!-- Brand Header -->
        <div class="text-center mb-xl">
          <div class="inline-flex items-center justify-center w-12 h-12 bg-primary-container text-on-primary-container rounded-xl mb-sm shadow-sm">
            <span class="material-symbols-outlined text-[24px]">vpn_key</span>
          </div>
          <h1 class="font-headline-lg text-on-background">ConsultFlow</h1>
        </div>

        <!-- Recovery Card -->
        <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant p-lg md:p-xl transition-all duration-300 relative overflow-hidden h-[420px]">
          
          <!-- State 1: Enter Email -->
          <Transition name="fade">
            <div v-if="step === 'email'" class="absolute inset-0 p-lg md:p-xl flex flex-col">
              <h2 class="font-headline-md text-on-surface mb-sm">Forgot Password?</h2>
              <p class="font-body-md text-on-surface-variant mb-xl">Enter the email address associated with your account, and we'll send you a 6-digit recovery code.</p>
              <form class="space-y-lg flex-1" @submit.prevent="sendOtp">
                <div>
                  <label class="block font-label-md text-on-surface mb-xs" for="email">Email Address</label>
                  <input id="email" v-model="email" type="email" placeholder="name@company.com" required class="w-full px-md py-sm bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-on-surface focus:border-secondary focus:ring-1 focus:ring-secondary outline-none transition-shadow" >
                </div>
                <div v-if="errorMsg" class="text-error font-body-sm">{{ errorMsg }}</div>
                <button type="submit" :disabled="isSubmitting" class="w-full py-sm px-md bg-primary text-on-primary rounded-lg font-label-md hover:bg-surface-tint transition-all shadow-sm disabled:opacity-50">
                  {{ isSubmitting ? 'Sending...' : 'Send Recovery Code' }}
                </button>
              </form>
              <div class="mt-lg text-center">
                <NuxtLink to="/login" class="font-body-sm text-secondary hover:text-on-secondary-fixed-variant transition-colors flex items-center justify-center gap-xs">
                  <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                  Back to Login
                </NuxtLink>
              </div>
            </div>
          </Transition>

          <!-- State 2: OTP Verification -->
          <Transition name="fade">
            <div v-if="step === 'otp'" class="absolute inset-0 p-lg md:p-xl bg-surface-container-lowest flex flex-col">
              <div class="flex items-center gap-sm mb-sm text-primary">
                <button type="button" class="hover:bg-surface-container rounded-full p-1 transition-colors -ml-2" @click="step = 'email'">
                  <span class="material-symbols-outlined">arrow_back</span>
                </button>
                <h2 class="font-headline-md text-on-surface">Enter Code</h2>
              </div>
              <p class="font-body-md text-on-surface-variant mb-xl">We sent a 6-digit code to <strong>{{ email || 'user@company.com' }}</strong>. Please enter it below.</p>
              <form class="space-y-xl flex-1" @submit.prevent="verifyOtp">
                <div class="flex justify-between gap-sm">
                  <input v-for="i in 6" :key="i" v-model="otpDigits[i-1]" type="text" maxlength="1" class="w-12 h-14 text-center text-headline-lg bg-surface-container-lowest border border-outline-variant rounded-lg focus:border-secondary focus:ring-1 focus:ring-secondary outline-none transition-shadow" >
                </div>
                <div class="space-y-md">
                  <div v-if="errorMsg" class="text-error font-body-sm text-center">{{ errorMsg }}</div>
                  <button type="submit" :disabled="isSubmitting" class="w-full py-sm px-md bg-primary text-on-primary rounded-lg font-label-md hover:bg-surface-tint transition-all shadow-sm disabled:opacity-50">
                    {{ isSubmitting ? 'Verifying...' : 'Verify Code' }}
                  </button>
                  <p class="text-center font-body-sm text-on-surface-variant">
                    Didn't receive code? <button type="button" @click="sendOtp" class="text-secondary font-label-md hover:underline ml-1">Resend</button>
                  </p>
                </div>
              </form>
            </div>
          </Transition>

          <!-- State 3: New Password -->
          <Transition name="fade">
            <div v-if="step === 'new-password'" class="absolute inset-0 p-lg md:p-xl bg-surface-container-lowest flex flex-col">
              <h2 class="font-headline-md text-on-surface mb-sm">Create New Password</h2>
              <p class="font-body-md text-on-surface-variant mb-xl">Your identity has been verified. Please set a new, strong password.</p>
              <form class="space-y-lg flex-1" @submit.prevent="resetPassword">
                <div class="space-y-xs">
                  <label class="block font-label-md text-on-surface" for="new-password">New Password</label>
                  <div class="relative">
                    <input id="new-password" v-model="newPassword" type="password" placeholder="••••••••" required class="w-full px-md py-sm bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-on-surface focus:border-secondary focus:ring-1 focus:ring-secondary outline-none transition-shadow" >
                  </div>
                </div>
                <div>
                  <label class="block font-label-md text-on-surface mb-xs" for="confirm-password">Confirm Password</label>
                  <input id="confirm-password" v-model="confirmPassword" type="password" placeholder="••••••••" required class="w-full px-md py-sm bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-on-surface focus:border-secondary focus:ring-1 focus:ring-secondary outline-none transition-shadow" >
                </div>
                <div class="pt-sm space-y-md">
                  <div v-if="errorMsg" class="text-error font-body-sm text-center">{{ errorMsg }}</div>
                  <button type="submit" :disabled="isSubmitting" class="w-full py-sm px-md bg-primary text-on-primary rounded-lg font-label-md hover:bg-surface-tint transition-all shadow-sm disabled:opacity-50">
                    {{ isSubmitting ? 'Resetting...' : 'Reset Password' }}
                  </button>
                </div>
              </form>
            </div>
          </Transition>

        </div>
        
        <div class="mt-xl text-center">
          <p class="font-body-sm text-on-surface-variant opacity-70">
            Secure connection • ConsultFlow B2B Standard
          </p>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import { useRuntimeConfig } from '#app'

definePageMeta({ layout: false })

const step = ref<'email' | 'otp' | 'new-password'>('email')
const email = ref('')
const newPassword = ref('')
const confirmPassword = ref('')
const otpDigits = ref(['', '', '', '', '', ''])
const errorMsg = ref('')
const isSubmitting = ref(false)

const router = useRouter()
const config = useRuntimeConfig()

const otpCode = computed(() => otpDigits.value.join(''))

const sendOtp = async () => {
  if (!email.value) return
  isSubmitting.value = true
  errorMsg.value = ''
  try {
    await $fetch(`${config.public.apiBase}/forgot-password/send-otp`, {
      method: 'POST',
      body: { email: email.value }
    })
    step.value = 'otp'
  } catch (e: any) {
    errorMsg.value = e.response?._data?.message || 'Failed to send OTP'
  } finally {
    isSubmitting.value = false
  }
}

const verifyOtp = async () => {
  if (otpCode.value.length < 6) return
  isSubmitting.value = true
  errorMsg.value = ''
  try {
    await $fetch(`${config.public.apiBase}/forgot-password/verify-otp`, {
      method: 'POST',
      body: { email: email.value, otp: otpCode.value }
    })
    step.value = 'new-password'
  } catch (e: any) {
    errorMsg.value = e.response?._data?.message || 'Invalid or expired OTP'
  } finally {
    isSubmitting.value = false
  }
}

const resetPassword = async () => {
  if (newPassword.value !== confirmPassword.value) {
    errorMsg.value = 'Passwords do not match'
    return
  }
  isSubmitting.value = true
  errorMsg.value = ''
  try {
    await $fetch(`${config.public.apiBase}/forgot-password/reset`, {
      method: 'POST',
      body: { 
        email: email.value, 
        otp: otpCode.value, 
        password: newPassword.value,
        password_confirmation: confirmPassword.value
      }
    })
    alert('Password successfully reset!')
    router.push('/login')
  } catch (e: any) {
    errorMsg.value = e.response?._data?.message || 'Failed to reset password'
  } finally {
    isSubmitting.value = false
  }
}
</script>
