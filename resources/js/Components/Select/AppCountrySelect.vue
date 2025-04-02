<template>
  <app-select v-bind="$attrs" v-model="country" label="País" placeholder="Selecione o país" :items="countries" item-title="name" item-value="code" flat />
</template>

<script setup>
const props = defineProps({
  modelValue: {
    type: String,
    default: 'BR'
  }
})

const emit = defineEmits(['update:modelValue'])

const countries = ref([
  { name: 'Brasil', code: 'BR' },
  { name: 'Argentina', code: 'AR' },
  { name: 'Chile', code: 'CL' },
  { name: 'Colômbia', code: 'CO' },
  { name: 'Equador', code: 'EC' },
  { name: 'Paraguai', code: 'PY' },
  { name: 'Peru', code: 'PE' },
  { name: 'Uruguai', code: 'UY' },
  { name: 'Venezuela', code: 'VE' }
])

const country = computed({
  get: () => props.modelValue,
  set: (country) => {
    emit('update:modelValue', country)
  }
})
</script>
