<script setup lang="ts">
import { ref, onMounted, watch } from 'vue';

interface Props {
  length?: number;
  modelValue: string;
  error?: string;
}

const props = withDefaults(defineProps<Props>(), {
  length: 6,
});

const emit = defineEmits<{
  (e: 'update:modelValue', value: string): void;
  (e: 'complete', value: string): void;
}>();

const digits = ref<string[]>(new Array(props.length).fill(''));
const inputRefs = ref<HTMLInputElement[]>([]);

const handleInput = (index: number, event: Event) => {
  const input = event.target as HTMLInputElement;
  const value = input.value.slice(-1);
  
  if (value && !/^\d$/.test(value)) {
    digits.value[index] = '';
    return;
  }

  digits.value[index] = value;
  
  if (value && index < props.length - 1) {
    inputRefs.value[index + 1]?.focus();
  }
  
  updateValue();
};

const handleKeyDown = (index: number, event: KeyboardEvent) => {
  if (event.key === 'Backspace' && !digits.value[index] && index > 0) {
    inputRefs.value[index - 1]?.focus();
  }
};

const updateValue = () => {
  const fullValue = digits.value.join('');
  emit('update:modelValue', fullValue);
  if (fullValue.length === props.length) {
    emit('complete', fullValue);
  }
};

watch(() => props.modelValue, (newVal) => {
  if (newVal.length === 0) {
    digits.value = new Array(props.length).fill('');
  }
});
</script>

<template>
  <div class="flex flex-col gap-2">
    <div class="flex items-center justify-between gap-2 sm:gap-3">
      <input
        v-for="(digit, index) in length"
        :key="index"
        ref="inputRefs"
        type="text"
        inputmode="numeric"
        maxlength="1"
        :value="digits[index]"
        class="w-10 h-12 sm:w-12 sm:h-14 text-center text-xl font-bold border-2 rounded-xl transition-all duration-200 focus:outline-none focus:ring-4"
        :class="[
          error 
            ? 'border-red-300 focus:ring-red-50 text-red-900' 
            : 'border-slate-200 focus:ring-emerald-50 focus:border-emerald-500 text-slate-900'
        ]"
        @input="handleInput(index, $event)"
        @keydown="handleKeyDown(index, $event)"
      />
    </div>
    <p v-if="error" class="text-xs text-red-600 text-center mt-1">{{ error }}</p>
  </div>
</template>