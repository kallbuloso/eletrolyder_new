<template>
  <app-text-field v-bind="$attrs" v-model="number" label="Número" placeholder="Digite o Número" :onkeypress="onlyNumbers" />
</template>

<script setup>
const props = defineProps({
  modelValue: {
    type: [String, Number]
  }
})

const onlyNumbers = (event) => {
  return event.charCode >= 48 && event.charCode <= 57
}

const emit = defineEmits(['update:modelValue'])
const number = computed({
  get: () => props.modelValue,
  set: (number) => {
    emit('update:modelValue', number)
  }
})
</script>
