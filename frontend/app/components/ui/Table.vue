<template>
  <div class="overflow-x-auto bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm">
    <table class="w-full text-left font-body-sm text-on-surface">
      <thead class="bg-surface-container-low border-b border-outline-variant text-on-surface-variant font-label-sm uppercase tracking-wider">
        <tr>
          <th v-for="(column, idx) in columns" :key="idx" class="px-md py-sm font-medium">
            {{ column.label }}
          </th>
        </tr>
      </thead>
      <tbody class="divide-y divide-outline-variant">
        <tr v-if="data.length === 0">
          <td :colspan="columns.length" class="px-md py-xl text-center text-on-surface-variant font-body-md">
            No data available.
          </td>
        </tr>
        <tr v-for="(row, rowIndex) in data" :key="rowIndex" class="hover:bg-surface-container-low transition-colors">
          <td v-for="(column, colIndex) in columns" :key="colIndex" class="px-md py-sm">
            <slot :name="`cell-${column.key}`" :row="row" :value="row[column.key]">
              {{ row[column.key] }}
            </slot>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup lang="ts">
// Basic Table wrapper component
// Extends easily for pagination or actions

export interface TableColumn {
  key: string
  label: string
}

defineProps<{
  columns: TableColumn[]
  data: Record<string, unknown>[]
}>()
</script>
