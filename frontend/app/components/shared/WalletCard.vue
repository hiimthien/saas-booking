<template>
  <div :class="['text-on-primary-container rounded-2xl p-xl shadow-sm relative overflow-hidden', bgClass]">
    <div class="absolute -right-10 -top-10 w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>
    <p class="font-label-md uppercase tracking-wider mb-sm relative z-10">{{ label }}</p>
    <h1 class="font-display-lg text-[48px] relative z-10">${{ parseFloat(balance || '0').toFixed(2) }}</h1>
    <div class="mt-md relative z-10">
      <slot name="actions"></slot>
    </div>
  </div>
</template>

<script setup lang="ts">
defineProps({
  balance: {
    type: [String, Number],
    required: true
  },
  label: {
    type: String,
    default: 'Available Balance'
  },
  bgClass: {
    type: String,
    default: 'bg-primary'
  }
})
</script>
