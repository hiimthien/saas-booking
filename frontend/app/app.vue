<script setup lang="ts">
import { Toaster } from 'vue-sonner'
</script>

<template>
  <div>
    <NuxtLoadingIndicator color="#059669" :height="3" />
    <NuxtLayout>
      <NuxtPage />
    </NuxtLayout>
    <Toaster position="top-right" richColors />
  </div>
</template>
