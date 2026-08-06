<script setup lang="ts">
interface Props {
  modelValue: string | number;
  label?: string;
  type?: string;
  placeholder?: string;
  error?: string;
  icon?: string;
  id?: string;
  required?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
  type: 'text',
  placeholder: '',
  required: false,
});

const emit = defineEmits<{
  (e: 'update:modelValue', value: string): void;
  (e: 'blur', event: FocusEvent): void;
}>();

const handleInput = (event: Event) => {
  const target = event.target as HTMLInputElement;
  emit('update:modelValue', target.value);
};
</script>

<template>
  <div class="flex flex-col gap-1.5 w-full text-left">
    <label v-if="label" :for="id" class="text-sm font-medium text-slate-700">
      {{ label }}<span v-if="required" class="text-emerald-600 ml-0.5">*</span>
    </label>
    <div class="relative">
      <div v-if="icon" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
        <!-- BaseIcon with props.icon -->
      </div>
      <input
        :id="id"
        :type="type"
        :value="modelValue"
        :placeholder="placeholder"
        :required="required"
        :class="[
          'w-full px-3 py-2 text-sm border bg-white focus:outline-none focus:ring-2 transition-all duration-200 rounded-xl',
          error 
            ? 'border-red-300 focus:ring-red-100 text-red-900 placeholder-red-300' 
            : 'border-slate-200 focus:ring-emerald-50 focus:border-emerald-500 text-slate-900 placeholder-slate-400',
          icon ? 'pl-10' : ''
        ]"
        @input="handleInput"
        @blur="emit('blur', $event)"
      />
    </div>
    <p v-if="error" class="text-xs text-red-600 mt-1">{{ error }}</p>
  </div>
</template>