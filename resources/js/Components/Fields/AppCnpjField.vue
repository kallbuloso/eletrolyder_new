<script setup>
import { cnpjValidator } from '@/utils/validators'

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
const cnpj = computed({
  get: () => props.modelValue,
  set: (cnpj) => {
    emit('update:modelValue', cnpj)
  }
})

const rules = ref([])

const updateRules = () => {
  rules.value = []
  if (props.required) {
    rules.value.push((v) => !!v || 'Obrigatório')
  }
  rules.value.push(cnpjValidator)
}

onMounted(() => {
  updateRules()
})

watch(
  () => cnpj.value,
  () => {
    updateRules()
  }
)
</script>

<template>
  <app-mask-field
    v-bind="$attrs"
    v-model="cnpj"
    label="cnpj"
    placeholder="Digite o cnpj"
    mask="##.###.###/####-##"
    style="min-width: 170px; max-width: 170px"
    :required="props.required"
    :rules="rules"
  />
</template>
