<template>
  <div class="max-w-container-max mx-auto w-full px-margin-mobile md:px-gutter py-lg md:py-xl flex flex-col md:flex-row gap-lg">
    <!-- Mobile Filter Toggle -->
    <div class="md:hidden mb-4 flex justify-between items-center w-full">
      <h1 class="font-headline-lg-mobile text-on-surface">Explore Consultants</h1>
      <UiBaseButton variant="outline" class="flex items-center gap-xs" @click="showMobileFilters = true">
        <template #icon-left><span class="material-symbols-outlined text-sm">tune</span></template>
        Filters
      </UiBaseButton>
    </div>

    <!-- Sidebar Filters (Desktop) -->
    <aside class="hidden md:block w-full md:w-64 lg:w-72 flex-shrink-0">
      <div class="sticky top-24">
        <DomainSearchFilterSidebar
          :min-rate="minRate"
          :max-rate="maxRate"
          :min-rating="minRating"
          @update:min-rate="val => minRate = (val ? Number(val) : '')"
          @update:max-rate="val => maxRate = (val ? Number(val) : '')"
          @update:min-rating="val => minRating = (val ? Number(val) : '')"
          @clear="clearFilters"
        />
      </div>
    </aside>

    <!-- Mobile Filters Modal -->
    <UiBaseModal :is-open="showMobileFilters" title="Filters" @close="showMobileFilters = false">
      <DomainSearchFilterSidebar
        :min-rate="minRate"
        :max-rate="maxRate"
        :min-rating="minRating"
        @update:min-rate="val => minRate = (val ? Number(val) : '')"
        @update:max-rate="val => maxRate = (val ? Number(val) : '')"
        @update:min-rating="val => minRating = (val ? Number(val) : '')"
        @clear="clearFilters"
      />
      <div class="mt-md flex justify-end">
        <UiBaseButton variant="primary" @click="showMobileFilters = false">Apply Filters</UiBaseButton>
      </div>
    </UiBaseModal>

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
          <UiBaseSelect
            v-model="sort"
            :options="[
              { label: 'Recommended', value: 'recommended' },
              { label: 'Highest Rated', value: 'highest_rated' },
              { label: 'Price: Low to High', value: 'price_asc' },
              { label: 'Price: High to Low', value: 'price_desc' }
            ]"
          />
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
        
        <!-- Consultant Card Component -->
        <DomainConsultantProfileCard 
          v-for="consultant in consultants" 
          :key="consultant.id"
          :consultant="{
            id: consultant.id,
            name: consultant.user.name,
            title: consultant.title,
            avatar: consultant.user.avatar_url || `https://ui-avatars.com/api/?name=${consultant.user.name}&background=random`,
            rating: Number(consultant.rating),
            reviews: consultant.reviews_count,
            price: Number(consultant.hourly_rate),
            tags: consultant.tags ? consultant.tags.map((t: any) => t.name) : []
          }"
          @book="$router.push(`/consultants/${consultant.slug}`)"
        />
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
import DomainSearchFilterSidebar from '~/components/domain/SearchFilterSidebar.vue'

useHead({
  title: 'Explore Consultants | ConsultFlow'
})

const route = useRoute()
const router = useRouter()
const { getConsultants } = useConsultantService()

const showMobileFilters = ref(false)
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
