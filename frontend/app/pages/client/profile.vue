<template>
  <div>
    <!-- Page Header -->
    <div class="mb-xl flex flex-col md:flex-row md:items-end justify-between gap-md">
      <div>
        <h2 class="font-display-lg text-on-surface">Settings</h2>
        <p class="font-body-md text-on-surface-variant mt-sm">Manage your profile, billing, and preferences.</p>
      </div>
    </div>

    <!-- Bento Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-md xl:gap-lg">
      
      <!-- Profile Form -->
      <UiCard class="lg:col-span-7 p-lg">
        <h3 class="font-headline-md text-on-surface mb-md">Personal Information</h3>
        <form class="space-y-lg" @submit.prevent>
          <div class="flex items-center gap-lg">
            <div class="relative group cursor-pointer">
              <img src="https://ui-avatars.com/api/?name=Jane+Doe&background=random" alt="Profile" class="w-24 h-24 rounded-full object-cover border-2 border-surface-container" >
              <div class="absolute inset-0 bg-on-surface/50 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                <span class="material-symbols-outlined text-on-primary">edit</span>
              </div>
            </div>
            <div>
              <UiButton variant="outline" type="button">
                Change Photo
              </UiButton>
              <p class="font-body-sm text-on-surface-variant mt-xs">JPG, GIF or PNG. Max size of 800K</p>
            </div>
          </div>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
            <div class="space-y-xs">
              <label class="font-label-md text-on-surface block">First Name</label>
              <UiInput model-value="Jane" />
            </div>
            <div class="space-y-xs">
              <label class="font-label-md text-on-surface block">Last Name</label>
              <UiInput model-value="Doe" />
            </div>
          </div>
          
          <div class="space-y-xs">
            <label class="font-label-md text-on-surface block">Email Address</label>
            <UiInput type="email" model-value="jane.doe@example.com" />
          </div>
          
          <div class="space-y-xs">
            <label class="font-label-md text-on-surface block">Timezone</label>
            <UiSelect :options="[{value:'(GMT-08:00) Pacific Time (US & Canada)', label:'(GMT-08:00) Pacific Time (US & Canada)'},{value:'(GMT-05:00) Eastern Time (US & Canada)', label:'(GMT-05:00) Eastern Time (US & Canada)'},{value:'(GMT+00:00) London', label:'(GMT+00:00) London'}]" model-value="(GMT-08:00) Pacific Time (US & Canada)" />
          </div>
          
          <div class="pt-sm flex justify-end">
            <UiButton type="submit" variant="primary">
              Save Changes
            </UiButton>
          </div>
        </form>
      </UiCard>

      <!-- Billing & Payment -->
      <div class="lg:col-span-5 flex flex-col gap-md xl:gap-lg">
        <!-- Saved Payment Methods -->
        <UiCard class="p-lg">
          <div class="flex items-center justify-between mb-md">
            <h3 class="font-headline-md text-on-surface">Payment Methods</h3>
            <button class="text-primary hover:text-primary-container transition-colors font-label-md flex items-center gap-xs">
              <span class="material-symbols-outlined text-sm">add_circle</span> Add
            </button>
          </div>
          <div class="space-y-sm">
            <div class="flex items-center justify-between p-md border border-outline-variant rounded-lg bg-surface relative overflow-hidden group">
              <div class="absolute left-0 top-0 bottom-0 w-1 bg-primary"/>
              <div class="flex items-center gap-md">
                <div class="w-10 h-6 bg-surface-container-highest rounded flex items-center justify-center border border-outline-variant">
                  <span class="font-label-sm text-on-surface-variant">VISA</span>
                </div>
                <div>
                  <p class="font-label-md text-on-surface">Visa ending in 4242</p>
                  <p class="font-body-sm text-on-surface-variant">Expires 12/24</p>
                </div>
              </div>
              <div class="flex items-center gap-sm opacity-0 group-hover:opacity-100 transition-opacity">
                <button class="text-on-surface-variant hover:text-error transition-colors" title="Remove">
                  <span class="material-symbols-outlined">delete</span>
                </button>
              </div>
              <UiBadge variant="neutral" class="absolute top-md right-md group-hover:hidden">Default</UiBadge>
            </div>
            
            <div class="flex items-center justify-between p-md border border-outline-variant rounded-lg bg-surface-container-lowest hover:bg-surface transition-colors group">
              <div class="flex items-center gap-md">
                <div class="w-10 h-6 bg-surface-container-highest rounded flex items-center justify-center border border-outline-variant">
                  <span class="font-label-sm text-on-surface-variant">MC</span>
                </div>
                <div>
                  <p class="font-label-md text-on-surface">Mastercard ending in 8899</p>
                  <p class="font-body-sm text-on-surface-variant">Expires 08/25</p>
                </div>
              </div>
              <div class="flex items-center gap-sm opacity-0 group-hover:opacity-100 transition-opacity">
                <button class="text-on-surface-variant hover:text-primary transition-colors font-label-sm mr-xs">Make Default</button>
                <button class="text-on-surface-variant hover:text-error transition-colors" title="Remove">
                  <span class="material-symbols-outlined">delete</span>
                </button>
              </div>
            </div>
          </div>
        </UiCard>

        <!-- Current Plan -->
        <UiCard class="p-lg relative overflow-hidden">
          <div class="absolute -right-10 -top-10 w-32 h-32 bg-secondary-container/20 rounded-full blur-2xl"/>
          <h3 class="font-headline-md text-on-surface mb-xs relative z-10">Pro Plan</h3>
          <p class="font-body-sm text-on-surface-variant mb-md relative z-10">$29.00/month</p>
          <div class="flex items-end justify-between relative z-10">
            <div>
              <p class="font-label-sm text-on-surface-variant uppercase tracking-wider mb-xs">Next Billing Date</p>
              <p class="font-body-md text-on-surface font-medium">Nov 15, 2023</p>
            </div>
            <button class="text-secondary hover:text-secondary-fixed transition-colors font-label-md">
              Manage Plan
            </button>
          </div>
        </UiCard>
      </div>

      <!-- Invoice History Table -->
      <UiCard class="lg:col-span-12 mt-md xl:mt-0 overflow-hidden flex flex-col p-0">
        <div class="p-lg border-b border-outline-variant flex justify-between items-center bg-surface-bright">
          <h3 class="font-headline-md text-on-surface">Billing History</h3>
          <button class="text-on-surface-variant hover:text-primary transition-colors">
            <span class="material-symbols-outlined">filter_list</span>
          </button>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse">
            <thead>
              <tr class="bg-surface-container-low border-b border-outline-variant">
                <th class="font-label-sm text-on-surface-variant uppercase py-sm px-lg font-medium">Invoice ID</th>
                <th class="font-label-sm text-on-surface-variant uppercase py-sm px-lg font-medium">Date</th>
                <th class="font-label-sm text-on-surface-variant uppercase py-sm px-lg font-medium">Amount</th>
                <th class="font-label-sm text-on-surface-variant uppercase py-sm px-lg font-medium">Status</th>
                <th class="font-label-sm text-on-surface-variant uppercase py-sm px-lg font-medium text-right">Action</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant bg-surface-container-lowest">
              <tr v-for="i in 3" :key="i" class="hover:bg-surface-variant/50 transition-colors group">
                <td class="py-md px-lg font-body-sm text-on-surface font-medium">#INV-2023-01{{ i }}</td>
                <td class="py-md px-lg font-body-sm text-on-surface-variant">Oct {{ 15 + i }}, 2023</td>
                <td class="py-md px-lg font-body-sm text-on-surface">$29.00</td>
                <td class="py-md px-lg">
                  <UiBadge variant="primary">Paid</UiBadge>
                </td>
                <td class="py-md px-lg text-right">
                  <button class="text-on-surface-variant hover:text-primary transition-colors opacity-0 group-hover:opacity-100" title="Download Receipt">
                    <span class="material-symbols-outlined">download</span>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </UiCard>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'client' })
</script>
