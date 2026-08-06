<script setup lang="ts">
interface Column {
  key: string;
  label: string;
  sortable?: boolean;
}

interface Props {
  columns: Column[];
  items: any[];
  loading?: boolean;
  emptyText?: string;
}

const props = withDefaults(defineProps<Props>(), {
  emptyText: 'No data found',
  loading: false,
});

const emit = defineEmits<{
  (e: 'row-click', item: any): void;
  (e: 'sort', key: string): void;
}>();
</script>

<template>
  <div class="w-full overflow-hidden border border-slate-100 rounded-xl bg-white shadow-sm">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-slate-50 border-b border-slate-100">
            <th 
              v-for="col in columns" 
              :key="col.key"
              class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500"
              :class="{ 'cursor-pointer hover:text-emerald-600 transition-colors': col.sortable }"
              @click="col.sortable && emit('sort', col.key)"
            >
              <div class="flex items-center gap-2">
                {{ col.label }}
                <svg v-if="col.sortable" xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                </svg>
              </div>
            </th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
          <tr v-if="loading">
            <td :colspan="columns.length" class="px-6 py-12 text-center">
              <div class="flex flex-col items-center gap-3">
                <div class="w-8 h-8 border-4 border-emerald-100 border-t-emerald-600 rounded-full animate-spin"></div>
                <span class="text-sm text-slate-500 font-medium">Loading data...</span>
              </div>
            </td>
          </tr>
          <tr v-else-if="items.length === 0">
            <td :colspan="columns.length" class="px-6 py-12 text-center text-sm text-slate-400 italic">
              {{ emptyText }}
            </td>
          </tr>
          <tr 
            v-for="(item, index) in items" 
            :key="index"
            class="hover:bg-slate-50/50 transition-colors cursor-pointer group"
            @click="emit('row-click', item)"
          >
            <td 
              v-for="col in columns" 
              :key="col.key"
              class="px-6 py-4 text-sm text-slate-700"
            >
              <slot :name="`cell-${col.key}`" :item="item">
                {{ item[col.key] }}
              </slot>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>