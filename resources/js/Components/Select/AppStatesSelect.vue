<!--
  Este componente é uma seleção simples que permite ao usuário selecionar um estado.
  Ele usa o componente Vuetify v-select.
  O componente recebe uma propriedade modelValue e emite um evento update:modelValue.
  O componente possui uma propriedade computada que obtém e define o valor do estado.
 -->
<template>
  <app-select
    v-bind="$attrs"
    v-model="state"
    label="Estado"
    placeholder="Estado"
    :items="[
      { title: 'Acre', value: 'AC' },
      { title: 'Alagoas', value: 'AL' },
      { title: 'Amapá', value: 'AP' },
      { title: 'Amazonas', value: 'AM' },
      { title: 'Bahia', value: 'BA' },
      { title: 'Ceará', value: 'CE' },
      { title: 'Distrito Federal', value: 'DF' },
      { title: 'Espírito Santo', value: 'ES' },
      { title: 'Goiás', value: 'GO' },
      { title: 'Maranhão', value: 'MA' },
      { title: 'Mato Grosso', value: 'MT' },
      { title: 'Mato Grosso do Sul', value: 'MS' },
      { title: 'Minas Gerais', value: 'MG' },
      { title: 'Pará', value: 'PA' },
      { title: 'Paraíba', value: 'PB' },
      { title: 'Paraná', value: 'PR' },
      { title: 'Pernambuco', value: 'PE' },
      { title: 'Piauí', value: 'PI' },
      { title: 'Rio de Janeiro', value: 'RJ' },
      { title: 'Rio Grande do Norte', value: 'RN' },
      { title: 'Rio Grande do Sul', value: 'RS' },
      { title: 'Rondônia', value: 'RO' },
      { title: 'Roraima', value: 'RR' },
      { title: 'Santa Catarina', value: 'SC' },
      { title: 'São Paulo', value: 'SP' },
      { title: 'Sergipe', value: 'SE' },
      { title: 'Tocantins', value: 'TO' }
    ]"
    item-title="title"
    item-value="value"
    flat
  />
</template>

<script setup>
const props = defineProps({
  modelValue: {
    type: String,
    default: 'SP'
  }
})

const emit = defineEmits(['update:modelValue'])
const state = computed({
  get: () => props.modelValue,
  set: (state) => {
    emit('update:modelValue', state)
  }
})
</script>
