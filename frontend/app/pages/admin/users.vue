<template>
  <div class="p-margin-mobile md:p-lg xl:p-xl w-full flex-1">
    <!-- Header -->
    <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-md mb-lg">
      <div>
        <h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface">User Management</h1>
        <p class="font-body-sm text-body-sm text-on-surface-variant mt-xs">Manage all registered users on the platform.</p>
      </div>
      <div class="flex gap-sm">
        <UiBaseButton variant="outline">
          <span class="material-symbols-outlined text-[18px]">download</span>
          Export
        </UiBaseButton>
        <UiBaseButton variant="primary">
          <span class="material-symbols-outlined text-[18px]">person_add</span>
          Add User
        </UiBaseButton>
      </div>
    </header>

    <!-- Filters & Search -->
    <UiBaseCard class="p-md mb-lg flex flex-col md:flex-row gap-md items-center justify-between">
      <div class="flex flex-1 w-full gap-md">
        <div class="relative flex-1 max-w-md">
          <span class="material-symbols-outlined absolute left-sm top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px] z-10">search</span>
          <UiBaseInput type="text" placeholder="Search users by name, email, or ID..." class="[&>div>input]:pl-10" />
        </div>
        <div class="hidden md:flex gap-sm w-full max-w-md">
          <UiBaseSelect :options="[{value:'All Roles', label:'All Roles'},{value:'Customer', label:'Customer'},{value:'Consultant', label:'Consultant'},{value:'Admin', label:'Admin'}]" model-value="All Roles" class="flex-1" />
          <UiBaseSelect :options="[{value:'All Statuses', label:'All Statuses'},{value:'Active', label:'Active'},{value:'Inactive', label:'Inactive'},{value:'Suspended', label:'Suspended'}]" model-value="All Statuses" class="flex-1" />
        </div>
      </div>
      <UiBaseButton variant="outline" class="md:hidden w-full flex justify-center items-center gap-xs">
        <span class="material-symbols-outlined text-[18px]">filter_list</span>
        Filters
      </UiBaseButton>
    </UiBaseCard>

    <!-- Data Table -->
    <UiBaseCard class="p-0 overflow-hidden flex flex-col">
      <div class="overflow-x-auto w-full">
        <table class="w-full text-left border-collapse min-w-[800px]">
          <thead class="bg-surface-container-low border-b border-outline-variant">
            <tr>
              <th class="py-sm px-md w-12">
                <input type="checkbox" class="rounded border-outline-variant text-primary focus:ring-primary h-4 w-4" >
              </th>
              <th class="py-md px-md font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider font-bold">User</th>
              <th class="py-md px-md font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider font-bold">Role</th>
              <th class="py-md px-md font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider font-bold">Status</th>
              <th class="py-md px-md font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider font-bold">Joined Date</th>
              <th class="py-md px-md font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider font-bold text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-outline-variant font-body-sm text-body-sm text-on-surface">
            <!-- User Row 1 -->
            <tr class="hover:bg-surface-container-lowest transition-colors group">
              <td class="py-md px-md">
                <input type="checkbox" class="rounded border-outline-variant text-primary focus:ring-primary h-4 w-4" >
              </td>
              <td class="py-md px-md">
                <div class="flex items-center gap-sm">
                  <img src="https://ui-avatars.com/api/?name=Emma+Watson&background=random" class="w-8 h-8 rounded-full" >
                  <div>
                    <div class="font-label-md text-label-md text-on-surface font-bold">Emma Watson</div>
                    <div class="text-[12px] text-on-surface-variant">emma.w@example.com</div>
                  </div>
                </div>
              </td>
              <td class="py-md px-md">
                <UiStatusBadge variant="neutral">Customer</UiStatusBadge>
              </td>
              <td class="py-md px-md">
                <UiStatusBadge variant="success">Active</UiStatusBadge>
              </td>
              <td class="py-md px-md text-on-surface-variant">Oct 24, 2023</td>
              <td class="py-md px-md text-right">
                <button class="text-on-surface-variant hover:text-primary transition-colors p-1" title="Edit User">
                  <span class="material-symbols-outlined text-[20px]">edit</span>
                </button>
                <button class="text-on-surface-variant hover:text-error transition-colors p-1" title="Suspend User">
                  <span class="material-symbols-outlined text-[20px]">block</span>
                </button>
              </td>
            </tr>
            <!-- User Row 2 -->
            <tr class="hover:bg-surface-container-lowest transition-colors group">
              <td class="py-md px-md">
                <input type="checkbox" class="rounded border-outline-variant text-primary focus:ring-primary h-4 w-4" >
              </td>
              <td class="py-md px-md">
                <div class="flex items-center gap-sm">
                  <img src="https://ui-avatars.com/api/?name=David+Chen&background=random" class="w-8 h-8 rounded-full" >
                  <div>
                    <div class="font-label-md text-label-md text-on-surface font-bold">David Chen</div>
                    <div class="text-[12px] text-on-surface-variant">david.c@consultflow.com</div>
                  </div>
                </div>
              </td>
              <td class="py-md px-md">
                <UiStatusBadge variant="primary">Consultant</UiStatusBadge>
              </td>
              <td class="py-md px-md">
                <UiStatusBadge variant="success">Active</UiStatusBadge>
              </td>
              <td class="py-md px-md text-on-surface-variant">Sep 12, 2023</td>
              <td class="py-md px-md text-right">
                <button class="text-on-surface-variant hover:text-primary transition-colors p-1" title="Edit User">
                  <span class="material-symbols-outlined text-[20px]">edit</span>
                </button>
                <button class="text-on-surface-variant hover:text-error transition-colors p-1" title="Suspend User">
                  <span class="material-symbols-outlined text-[20px]">block</span>
                </button>
              </td>
            </tr>
            <!-- User Row 3 -->
            <tr class="hover:bg-surface-container-lowest transition-colors group">
              <td class="py-md px-md">
                <input type="checkbox" class="rounded border-outline-variant text-primary focus:ring-primary h-4 w-4" >
              </td>
              <td class="py-md px-md">
                <div class="flex items-center gap-sm">
                  <div class="w-8 h-8 rounded-full bg-error-container text-on-error-container flex items-center justify-center font-bold">JD</div>
                  <div>
                    <div class="font-label-md text-label-md text-on-surface font-bold">John Doe</div>
                    <div class="text-[12px] text-on-surface-variant">j.doe@example.com</div>
                  </div>
                </div>
              </td>
              <td class="py-md px-md">
                <UiStatusBadge variant="neutral">Customer</UiStatusBadge>
              </td>
              <td class="py-md px-md">
                <UiStatusBadge variant="error">Suspended</UiStatusBadge>
              </td>
              <td class="py-md px-md text-on-surface-variant">Nov 01, 2023</td>
              <td class="py-md px-md text-right">
                <button class="text-on-surface-variant hover:text-primary transition-colors p-1" title="Edit User">
                  <span class="material-symbols-outlined text-[20px]">edit</span>
                </button>
                <button class="text-on-surface-variant hover:text-primary transition-colors p-1" title="Restore User">
                  <span class="material-symbols-outlined text-[20px]">settings_backup_restore</span>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- Pagination -->
      <div class="border-t border-outline-variant p-md flex items-center justify-between bg-surface-container-lowest">
        <span class="font-body-sm text-body-sm text-on-surface-variant">Showing 1 to 10 of 2,451 entries</span>
        <div class="flex gap-xs">
          <UiBaseButton variant="outline" class="!p-1" disabled>
            <span class="material-symbols-outlined">chevron_left</span>
          </UiBaseButton>
          <UiBaseButton variant="primary" class="!px-3 !py-1 min-w-[32px]">1</UiBaseButton>
          <UiBaseButton variant="outline" class="!px-3 !py-1 min-w-[32px]">2</UiBaseButton>
          <UiBaseButton variant="outline" class="!px-3 !py-1 min-w-[32px]">3</UiBaseButton>
          <UiBaseButton variant="outline" class="!p-1">
            <span class="material-symbols-outlined">chevron_right</span>
          </UiBaseButton>
        </div>
      </div>
    </UiBaseCard>
  </div>
</template>

<script setup lang="ts">
definePageMeta({
  layout: 'admin'
})
</script>
