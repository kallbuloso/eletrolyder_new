<!--
  Componente de campo de data
  @param {String} modelValue - Valor do campo de data
 -->
<template>
  <app-mask-field
    v-bind="$attrs"
    v-model="date"
    masked
    label="Data"
    placeholder="Digite a Data"
    mask="##/##/####"
    style="min-width: 130px; max-width: 130px"
    :rules="[dateValidator]"
  />
</template>

<script setup>
import { dateValidator } from '@/utils/validators'
const props = defineProps({
  modelValue: {
    type: String
  }
})

const emit = defineEmits(['update:modelValue'])
const date = computed({
  get: () => props.modelValue,
  set: (date) => {
    emit('update:modelValue', date)
  }
})
</script>
