<!--
  Componente de campo de CEP
  Utiliza o componente VMaskField para aplicar a máscara de CEP
 -->
<template>
  <app-mask-field v-bind="$attrs" v-model="cep" label="CEP" placeholder="Digite o CEP" :mask="['#####-###']" :required="props.required" :rules="rules" hint="Somente números" />
</template>

<script setup>
const props = defineProps({
  modelValue: [String, Number],
  required: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['update:modelValue'])
const cep = computed({
  get: () => props.modelValue,
  set: (cep) => {
    emit('update:modelValue', cep)
  }
})

const rules = computed(() => {
  const rules = []
  if (props.required) {
    rules.push((v) => !!v || 'Campo obrigatório')
  }
  return rules
})
</script>
