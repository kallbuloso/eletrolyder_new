<script setup>
const props = defineProps({
  modelValue: {
    type: Object,
    required: true
  },
  errors: {
    type: Object,
    default: () => ({})
  }
})

const emit = defineEmits(['update:modelValue'])

const address = ref({
  type: props.modelValue.type || 'residencial',
  street: props.modelValue.street || '',
  number: props.modelValue.number || '',
  complement: props.modelValue.complement || '',
  neighborhood: props.modelValue.neighborhood || '',
  city: props.modelValue.city || '',
  state: props.modelValue.state || 'SP',
  country: props.modelValue.country || 'BR',
  zip_code: props.modelValue.zip_code || '',
  reference: props.modelValue.reference || ''
})

const loadingCep = ref(false)

// TODO: setar foco no campo de número quando o CEP for preenchido

async function fetchCep(zipCode) {
  try {
    loadingCep.value = true
    const response = await fetch(`https://viacep.com.br/ws/${zipCode}/json/`)
    const data = await response.json()
    address.value.street = data.logradouro
    address.value.neighborhood = data.bairro
    address.value.city = data.localidade
    address.value.state = data.uf
    // setar foco no campo de número
    if (data.erro) {
      throw new Error('CEP não encontrado.\nVerifique o CEP digitado.')
    }
  } catch (error) {
    address.value.street = ''
    address.value.neighborhood = ''
    address.value.city = ''
    // voltar foco quando o CEP não for encontrado
    swToast(error, 'error', '5000')
  }
  loadingCep.value = false
}

watch(
  () => address.value.zip_code,
  () => {
    if (address.value.zip_code.length === 8) {
      fetchCep(address.value.zip_code)
    }
  }
)

watch(
  address,
  (newValue) => {
    emit('update:modelValue', newValue)
  },
  { deep: true }
)
</script>

<template>
  <v-row>
    <v-col cols="4">
      <app-select
        v-bind="$attrs"
        v-model="address.type"
        label="Tipo de Endereço"
        placeholder="Selecione o tipo"
        :items="[
          { title: 'Residencial', value: 'residencial' },
          { title: 'Comercial', value: 'comercial' },
          { title: 'Entrega', value: 'entrega' }
        ]"
        item-title="title"
        item-value="value"
        hint="Selecione o tipo de endereço"
      />
    </v-col>
    <v-col cols="4">
      <app-cep-field v-model="address.zip_code" :disabled="loadingCep" :loading="loadingCep" required :error-messages="props.errors.zip_code" />
    </v-col>
    <v-col cols="4">
      <div class="d-flex flex-row">
        <v-spacer />
        <app-search-cep v-model="address.zip_code" class="mt-6" :focusable="false" />
      </div>
    </v-col>
    <v-col cols="9">
      <app-name-field
        v-model="address.street"
        label="Endereço"
        placeholder="ex: Rua, Avenida, Alameda, etc"
        :disabled="loadingCep"
        required
        :error-messages="props.errors.address"
      />
    </v-col>
    <v-col cols="3">
      <div class="d-flex">
        <app-number-field
          v-model="address.number"
          v-tooltip="`Digite 0 para 'sem número'.`"
          label="Número"
          placeholder="Número"
          required
          :disabled="loadingCep"
          hint="0 para s/número"
          :error-messages="props.errors.number"
        />
      </div>
    </v-col>
    <v-col cols="4">
      <app-name-field v-model="address.complement" label="Complemento" placeholder="Bl A, Apto 101, etc" :disabled="loadingCep" :error-messages="props.errors.complement" />
    </v-col>
    <v-col cols="8">
      <app-name-field v-model="address.neighborhood" label="Bairro" placeholder="Ex: Bela Vista" :disabled="loadingCep" required :error-messages="props.errors.neighborhood" />
    </v-col>
    <v-col cols="7">
      <app-name-field v-model="address.city" label="Cidade / Município" placeholder="Ex: São paulo" :disabled="loadingCep" required :error-messages="props.errors.city" />
    </v-col>
    <v-col cols="5">
      <app-states-select v-model="address.state" :disabled="loadingCep" required :error-messages="props.errors.state" />
    </v-col>
    <v-col cols="8">
      <app-name-field
        v-model="address.reference"
        label="Ponto de Referência"
        placeholder="Ex: Próximo ao Mercado Dia"
        :disabled="loadingCep"
        :error-messages="props.errors.reference"
      />
    </v-col>
    <v-col cols="4">
      <app-country-select v-model="address.country" :disabled="loadingCep" :error-messages="props.errors.country" />
    </v-col>
  </v-row>
</template>
