<!--
  Componente de campo de seleção de garantia
  Utiliza o componente v-select do Vuetify
  Recebe um valor de garantia e emite um evento de atualização
  para o componente pai
 -->
<template>
  <app-select
    v-bind="$attrs"
    v-model="warranty"
    label="Garantia"
    placeholder="Selecione Garantia"
    :items="[
      { title: 'Não', value: '' },
      { title: 'Loja', value: 'loja' },
      { title: 'Fabricante', value: 'fabricante' }
    ]"
    item-title="title"
    item-value="value"
    style="min-width: 145px; max-width: 145px"
    flat
  />
</template>

<script setup>
const props = defineProps({
  modelValue: {
    type: String
  }
})

const emit = defineEmits(['update:modelValue'])
const warranty = computed({
  get: () => props.modelValue,
  set: (warranty) => {
    emit('update:modelValue', warranty)
  }
})
</script>
