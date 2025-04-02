<!--
  VPhoneField
  Componente de campo de telefone com máscara
 -->
<template>
  <app-mask-field
    v-bind="$attrs"
    v-model="phone"
    label="Telefone"
    placeholder="DDD + número"
    :mask="['(##) #####-####', '(##) ####-####']"
    :required="props.required"
    :rules="rules"
  >
    <template v-for="(_, name) in $slots" #[name]="slotData">
      <slot :name="name" v-bind="slotData" />
    </template>
  </app-mask-field>
</template>

<script setup>
const props = defineProps({
  modelValue: {
    type: [String, Number]
  },
  required: {
    type: Boolean,
    default: false
  }
})

const rules = computed(() => {
  const rules = [(v) => !v || (v.length <= 12 && v.length >= 10) || 'Número de telefone inválido']
  if (props.required) {
    rules.push((v) => !!v || 'Campo obrigatório')
  }
  return rules
})

const emit = defineEmits(['update:modelValue'])
const phone = computed({
  get: () => props.modelValue,
  set: (phone) => {
    emit('update:modelValue', phone)
  }
})
</script>
