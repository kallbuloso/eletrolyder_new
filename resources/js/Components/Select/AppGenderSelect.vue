<!--
  Componente de campo de seleção de gênero
  Utiliza o componente v-select do Vuetify
  Recebe um valor de gênero e emite um evento de atualização
  para o componente pai
 -->
<template>
  <app-select
    v-bind="$attrs"
    v-model="gender"
    label="Gênero"
    placeholder="Selecione Gênero"
    :items="[
      { title: 'Masculino', value: 'M' },
      { title: 'Feminino', value: 'F' },
      { title: 'LGBTQIA+', value: 'L' },
      { title: 'Não Binário', value: 'NB' },
      { title: 'Outro', value: 'O' }
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
const gender = computed({
  get: () => props.modelValue,
  set: (gender) => {
    emit('update:modelValue', gender)
  }
})
</script>
