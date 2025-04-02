<template>
  <app-mask-field
    v-bind="$attrs"
    v-model="cpfCnpj"
    :label="getPerson('CPF', 'CNPJ')"
    :placeholder="getPerson('Digite o CPF', 'Digite o CNPJ')"
    :mask="getPerson('###.###.###-##', '##.###.###/####-##')"
    style="min-width: 170px; max-width: 170px"
    :required="getPerson(false, true)"
    :rules="rules"
  />
</template>

<script setup>
import { cnpjValidator, cpfValidator } from '@/utils/validators'

const props = defineProps({
  modelValue: {
    type: String
  },
  typePerson: {
    type: String,
    default: 'J'
  }
})

const emit = defineEmits(['update:modelValue'])
const cpfCnpj = computed({
  get: () => props.modelValue,
  set: (cpfCnpj) => {
    emit('update:modelValue', cpfCnpj)
  }
})

const getPerson = (param, value) => {
  return props.typePerson === 'F' ? param : value
}

const rules = ref([])

const updateRules = () => {
  rules.value = []
  if (props.typePerson === 'J') {
    // console.log('Using CNPJ Validator')
    rules.value.push(cnpjValidator)
    rules.value.push((v) => !!v || 'Obrigatório para PJ')
  } else {
    // console.log('Using CPF Validator')
    rules.value.push(cpfValidator)
  }
  // console.log('Current rules:', rules.value)
}

onMounted(() => {
  updateRules()
})

watch(
  () => props.typePerson,
  () => {
    updateRules()
  }
)
</script>
