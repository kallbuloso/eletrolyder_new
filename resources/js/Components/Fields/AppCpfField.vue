<script setup>
import { cpfValidator } from '@/utils/validators'

const props = defineProps({
  modelValue: {
    type: String
  },
  required: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['update:modelValue'])
const cpf = computed({
  get: () => props.modelValue,
  set: (cpf) => {
    emit('update:modelValue', cpf)
  }
})

const rules = ref([])

const updateRules = () => {
  rules.value = []
  if (props.required) {
    rules.value.push((v) => !!v || 'Obrigatório')
  }
  rules.value.push(cpfValidator)
}

onMounted(() => {
  updateRules()
})

watch(
  () => cpf.value,
  () => {
    updateRules()
  }
)
</script>

<template>
  <app-mask-field
    v-bind="$attrs"
    v-model="cpf"
    label="CPF"
    placeholder="Digite o CPF"
    mask="###.###.###-##"
    style="min-width: 170px; max-width: 170px"
    :required="props.required"
    :rules="rules"
  />
</template>
