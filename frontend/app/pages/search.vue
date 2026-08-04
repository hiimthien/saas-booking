<template>
  <div class="max-w-container-max mx-auto w-full px-margin-mobile md:px-gutter py-lg md:py-xl flex flex-col md:flex-row gap-lg">
    <!-- Mobile Filter Toggle -->
    <div class="md:hidden mb-4 flex justify-between items-center w-full">
      <h1 class="font-headline-lg-mobile text-on-surface">Explore Consultants</h1>
      <button class="flex items-center gap-xs text-primary font-label-md px-3 py-2 border border-outline-variant rounded-lg bg-surface-container-low">
        <span class="material-symbols-outlined text-sm">tune</span>
        Filters
      </button>
    </div>

    <!-- Sidebar Filters -->
    <aside class="hidden md:block w-full md:w-64 lg:w-72 flex-shrink-0">
      <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-md shadow-sm sticky top-24">
        <div class="flex justify-between items-center mb-md border-b border-outline-variant pb-sm">
          <h2 class="font-headline-md text-on-surface">Filters</h2>
          <button @click="clearFilters" class="text-body-sm text-primary hover:underline">Clear all</button>
        </div>

        <!-- Price Range Filter -->
        <div class="mb-lg border-b border-outline-variant pb-md">
          <h3 class="font-label-md text-on-surface mb-sm">Hourly Rate</h3>
          <div class="flex items-center gap-sm mt-4">
            <div class="flex-1 relative">
              <span class="absolute left-2 top-1/2 -translate-y-1/2 text-on-surface-variant text-body-sm">$</span>
              <input v-model.lazy="minRate" type="number" placeholder="Min" class="w-full pl-6 pr-2 py-1.5 bg-surface-container-low border border-outline-variant rounded-lg text-body-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary" >
            </div>
            <span class="text-on-surface-variant">-</span>
            <div class="flex-1 relative">
              <span class="absolute left-2 top-1/2 -translate-y-1/2 text-on-surface-variant text-body-sm">$</span>
              <input v-model.lazy="maxRate" type="number" placeholder="Max" class="w-full pl-6 pr-2 py-1.5 bg-surface-container-low border border-outline-variant rounded-lg text-body-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary" >
            </div>
          </div>
        </div>

        <!-- Rating Filter -->
        <div class="mb-md">
          <h3 class="font-label-md text-on-surface mb-sm">Minimum Rating</h3>
          <div class="space-y-2">
            <label class="flex items-center justify-between cursor-pointer group">
              <div class="flex items-center gap-sm">
                <input type="radio" v-model="minRating" name="rating" :value="5.0" class="border-outline-variant text-primary focus:ring-primary w-4 h-4" >
                <div class="flex text-amber-500">
                  <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                  <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                  <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                  <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                  <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                </div>
              </div>
              <span class="font-body-sm text-on-surface-variant">5.0</span>
            </label>
            <label class="flex items-center justify-between cursor-pointer group">
              <div class="flex items-center gap-sm">
                <input type="radio" v-model="minRating" name="rating" :value="4.0" class="border-outline-variant text-primary focus:ring-primary w-4 h-4" >
                <div class="flex text-amber-500">
                  <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                  <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                  <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                  <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                  <span class="material-symbols-outlined text-sm text-outline-variant">star_border</span>
                </div>
              </div>
              <span class="font-body-sm text-on-surface-variant">4.0 & Up</span>
            </label>
            <label class="flex items-center justify-between cursor-pointer group">
              <div class="flex items-center gap-sm">
                <input type="radio" v-model="minRating" name="rating" :value="''" class="border-outline-variant text-primary focus:ring-primary w-4 h-4" >
                <span class="font-body-sm text-on-surface-variant">Any Rating</span>
              </div>
            </label>
          </div>
        </div>
      </div>
    </aside>

    <!-- Search Results & Sorting -->
    <div class="flex-1 flex flex-col">
      <!-- Results Header & Sort -->
      <div class="hidden md:flex justify-between items-end mb-lg">
        <div>
          <h1 class="font-headline-lg text-on-surface">Explore Consultants</h1>
          <p class="font-body-sm text-on-surface-variant mt-1">Showing {{ meta.total }} results</p>
        </div>
        <div class="flex items-center gap-sm">
          <span class="font-label-sm text-on-surface-variant uppercase tracking-wider">Sort by:</span>
          <select v-model="sort" class="bg-surface-container-lowest border border-outline-variant rounded-lg text-body-sm text-on-surface py-1.5 pl-3 pr-8 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary cursor-pointer">
            <option value="recommended">Recommended</option>
            <option value="highest_rated">Highest Rated</option>
            <option value="price_asc">Price: Low to High</option>
            <option value="price_desc">Price: High to Low</option>
          </select>
        </div>
      </div>

      <!-- Mobile Results Header -->
      <p class="md:hidden font-body-sm text-on-surface-variant mb-4">{{ meta.total }} results</p>

      <!-- Results Grid -->
      <div class="grid grid-cols-1 xl:grid-cols-2 gap-md md:gap-lg mb-xl relative min-h-[400px]">
        <div v-if="pending" class="absolute inset-0 bg-surface-container/50 z-10 flex justify-center pt-xl text-on-surface-variant">
          Loading consultants...
        </div>
        <div v-else-if="error" class="col-span-full py-xl text-center text-error">
          Error loading consultants: {{ error }}
        </div>
        <div v-else-if="consultants.length === 0" class="col-span-full py-xl text-center text-on-surface-variant">
          No consultants found matching your filters.
        </div>
        
        <!-- Consultant Card -->
        <div v-for="consultant in consultants" :key="consultant.id" class="bg-surface-container-lowest border border-outline-variant rounded-xl p-md shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between group">
          <div class="flex gap-md mb-md">
            <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-surface-container flex-shrink-0">
              <img :src="consultant.user.avatar_url || `https://ui-avatars.com/api/?name=${consultant.user.name}&background=random`" :alt="consultant.user.name" class="w-full h-full object-cover" >
            </div>
            <div class="flex-1 min-w-0">
              <div class="flex justify-between items-start">
                <div>
                  <NuxtLink :to="`/consultants/${consultant.slug}`" class="font-headline-md text-on-surface truncate group-hover:text-primary transition-colors">{{ consultant.user.name }}</NuxtLink>
                  <p class="font-body-sm text-on-surface-variant truncate">{{ consultant.title }}</p>
                </div>
                <div class="text-right flex-shrink-0">
                  <p class="font-headline-md text-on-surface">${{ consultant.hourly_rate }}<span class="font-body-sm text-on-surface-variant font-normal">/hr</span></p>
                </div>
              </div>
              <div class="flex items-center gap-xs mt-1">
                <span class="material-symbols-outlined text-amber-500 text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                <span class="font-label-sm text-on-surface">{{ Number(consultant.rating).toFixed(1) }}</span>
                <span class="font-body-sm text-on-surface-variant">({{ consultant.reviews_count }} reviews)</span>
              </div>
            </div>
          </div>
          <div class="mb-md">
            <div class="flex flex-wrap gap-xs">
              <span v-for="tag in consultant.tags" :key="tag" class="bg-surface-container-low text-on-surface-variant font-label-sm px-2 py-1 rounded-full">{{ tag }}</span>
            </div>
          </div>
          <div class="flex gap-sm mt-auto pt-sm border-t border-outline-variant">
            <NuxtLink :to="`/consultants/${consultant.slug}`" class="flex-1 text-center font-label-md text-on-surface bg-surface-container-lowest border border-outline-variant py-2 rounded-lg hover:bg-surface-variant transition-colors">View Profile</NuxtLink>
            <NuxtLink :to="`/checkout?consultant=${consultant.slug}`" class="flex-1 text-center font-label-md text-on-primary bg-primary py-2 rounded-lg hover:bg-surface-tint hover:shadow-md transition-all">Quick Book</NuxtLink>
          </div>
        </div>
      </div>

      <!-- Pagination -->
      <div v-if="meta.last_page > 1" class="flex justify-center items-center gap-sm mt-auto">
        <button 
          @click="page = Math.max(1, page - 1)"
          :disabled="page === 1"
          class="w-8 h-8 flex items-center justify-center rounded-lg text-on-surface-variant hover:bg-surface-variant border border-transparent disabled:opacity-50"
        >
          <span class="material-symbols-outlined text-sm">chevron_left</span>
        </button>
        
        <button 
          v-for="p in meta.last_page" 
          :key="p"
          @click="page = p"
          :class="['w-8 h-8 flex items-center justify-center rounded-lg font-label-sm transition-colors', page === p ? 'bg-primary text-on-primary' : 'text-on-surface hover:bg-surface-variant border border-outline-variant']"
        >
          {{ p }}
        </button>
        
        <button 
          @click="page = Math.min(meta.last_page, page + 1)"
          :disabled="page === meta.last_page"
          class="w-8 h-8 flex items-center justify-center rounded-lg text-on-surface-variant hover:bg-surface-variant border border-transparent disabled:opacity-50"
        >
          <span class="material-symbols-outlined text-sm">chevron_right</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useConsultantService } from '~/services/consultant.service'

useHead({
  title: 'Explore Consultants | ConsultFlow'
})

const route = useRoute()
const router = useRouter()
const { getConsultants } = useConsultantService()

const page = ref(Number(route.query.page) || 1)
const sort = ref(route.query.sort as string || 'recommended')
const minRate = ref<number | ''>(route.query.min_rate ? Number(route.query.min_rate) : '')
const maxRate = ref<number | ''>(route.query.max_rate ? Number(route.query.max_rate) : '')
const minRating = ref<number | ''>(route.query.min_rating ? Number(route.query.min_rating) : '')

const buildParams = () => {
  const params: Record<string, any> = { page: page.value, sort: sort.value }
  if (minRate.value !== '') params.min_rate = minRate.value
  if (maxRate.value !== '') params.max_rate = maxRate.value
  if (minRating.value !== '') params.min_rating = minRating.value
  return params
}

const { data, pending, error, execute } = await useAsyncData(
  'consultants', 
  () => getConsultants(buildParams())
)

const updateRouteAndFetch = () => {
  const params = buildParams()
  router.push({ query: params })
  execute()
}

watch([sort, minRate, maxRate, minRating], () => {
  page.value = 1
  updateRouteAndFetch()
})

watch(page, (newPage, oldPage) => {
  if (newPage !== oldPage) {
    updateRouteAndFetch()
  }
})

const clearFilters = () => {
  minRate.value = ''
  maxRate.value = ''
  minRating.value = ''
  sort.value = 'recommended'
  page.value = 1
}

const consultants = computed(() => data.value?.data || [])
const meta = computed(() => data.value?.meta || { total: 0, current_page: 1, last_page: 1 })
</script>
