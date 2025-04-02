<!--
  Componente de campo de texto para URL
  Utiliza o componente VTextField do Vuetify
  Recebe um valor de URL e emite um evento de atualização
  Utiliza uma regra de validação para URL
 -->
<template>
  <app-text-field v-bind="$attrs" v-model="url" label="URL" placeholder="Digite a URL" hint="http:// ou https://" :rules="rules" />
</template>

<script setup>
const props = defineProps({
  modelValue: {
    type: String
  }
})

const rules = [urlValidator]

const emit = defineEmits(['update:modelValue'])
const url = computed({
  get: () => props.modelValue,
  set: (url) => {
    emit('update:modelValue', url)
  }
})
</script>
