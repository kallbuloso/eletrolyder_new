<script setup>
import { ref, computed, watch, shallowRef } from 'vue'

const props = defineProps({
  modelValue: {
    type: String,
    required: false,
    default: ''
  }
})

const dialog = shallowRef(false)
const state = ref(35)
const cities = ref([])
const selectedCity = shallowRef('Taboão da Serra')
const address = ref('')
const loading = ref(false)
const addresses = ref([])
const headers = ref([
  { title: 'CEP', key: 'cep' },
  { title: 'Logradouro', key: 'logradouro' },
  { title: 'Bairro', key: 'bairro' },
  { title: 'Ação', key: 'action', sortable: false, align: 'end' }
])

const page = ref(1)
const itemsPerPage = 5
const pageCount = computed(() => Math.ceil(addresses.value.length / itemsPerPage))

const stateOptions = [
  { id: 12, nome: 'Acre' },
  { id: 27, nome: 'Alagoas' },
  { id: 16, nome: 'Amapá' },
  { id: 13, nome: 'Amazonas' },
  { id: 29, nome: 'Bahia' },
  { id: 23, nome: 'Ceará' },
  { id: 53, nome: 'Distrito Federal' },
  { id: 32, nome: 'Espírito Santo' },
  { id: 52, nome: 'Goiás' },
  { id: 21, nome: 'Maranhão' },
  { id: 51, nome: 'Mato Grosso' },
  { id: 50, nome: 'Mato Grosso do Sul' },
  { id: 31, nome: 'Minas Gerais' },
  { id: 15, nome: 'Pará' },
  { id: 25, nome: 'Paraíba' },
  { id: 41, nome: 'Paraná' },
  { id: 26, nome: 'Pernambuco' },
  { id: 22, nome: 'Piauí' },
  { id: 33, nome: 'Rio de Janeiro' },
  { id: 24, nome: 'Rio Grande do Norte' },
  { id: 43, nome: 'Rio Grande do Sul' },
  { id: 11, nome: 'Rondônia' },
  { id: 14, nome: 'Roraima' },
  { id: 42, nome: 'Santa Catarina' },
  { id: 35, nome: 'São Paulo' },
  { id: 28, nome: 'Sergipe' },
  { id: 17, nome: 'Tocantins' }
]

const emit = defineEmits(['update:modelValue'])

const cep = computed({
  get: () => props.modelValue,
  set: (newValue) => {
    emit('update:modelValue', newValue)
  }
})

function getStateName(stateCode) {
  const stateList = {
    12: 'AC',
    27: 'AL',
    16: 'AP',
    13: 'AM',
    29: 'BA',
    23: 'CE',
    53: 'DF',
    32: 'ES',
    52: 'GO',
    21: 'MA',
    51: 'MT',
    50: 'MS',
    31: 'MG',
    15: 'PA',
    25: 'PB',
    41: 'PR',
    26: 'PE',
    22: 'PI',
    33: 'RJ',
    24: 'RN',
    43: 'RS',
    11: 'RO',
    14: 'RR',
    42: 'SC',
    35: 'SP',
    28: 'SE',
    17: 'TO'
  }
  return stateList[stateCode] || ''
}

async function fetchCities(stateId) {
  loading.value = true
  cities.value = []
  try {
    const response = await fetch(`https://servicodados.ibge.gov.br/api/v1/localidades/estados/${stateId}/municipios`)
    if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`)
    const data = await response.json()
    // console.log(data.map(({ nome }) => ({ nome })))
    cities.value = data.map(({ nome }) => ({ nome }))
  } catch (error) {
    swToast(`Erro ao buscar municípios: ${error.message}`, 'error')
  } finally {
    loading.value = false
  }
}

async function fetchAddresses() {
  addresses.value = []
  if (!selectedCity.value) {
    swToast('Selecione um município', 'error', 3000)
    return
  }
  if (!address.value || address.value.length < 3) {
    swToast('Informe o logradouro para buscar o CEP', 'error', 3000)
    return
  }

  loading.value = true
  try {
    const stateName = getStateName(state.value)
    const response = await fetch(`https://viacep.com.br/ws/${stateName}/${selectedCity.value}/${address.value}/json/`)
    if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`)
    const data = await response.json()
    if (!data.length) {
      swToast('Endereço não encontrado.\nVerifique a digitação.', 'error', 4000)
      return
    }
    addresses.value = data.map(({ cep, logradouro, bairro }) => ({
      cep: cep.replace('-', ''),
      logradouro,
      bairro
    }))
  } catch (error) {
    swToast(`Erro ao buscar CEP: \n${error.message}`, 'error')
  } finally {
    loading.value = false
  }
}

function setSelectedCep(val) {
  cep.value = val
  dialogClose()
}

const dialogClose = () => {
  dialog.value = false
}

const dialogOpen = () => {
  dialog.value = true
  fetchCities(state.value)
  address.value = ''
  addresses.value = []
}

watch(state, (newVal) => {
  fetchCities(newVal)
  selectedCity.value = ''
})
</script>

<template>
  <v-btn v-tooltip="'Clique aqui para descobrir o seu CEP.'" v-bind="$attrs" class="mt-3" prepend-icon="mdi-map-marker-radius-outline" @click="dialogOpen()">Buscar CEP</v-btn>
  <v-dialog v-model="dialog" width="auto" persistent>
    <AppDialogCloseBtn @click="dialog = false" />
    <v-card
      class="mx-auto"
      width="750"
      title="Busca CEP"
      subtitle="Encontre o CEP por Endereço"
      prepend-icon="mdi-map-marker-radius-outline"
      :loading="loading"
      :disabled="loading"
    >
      <v-card-text>
        <v-form @submit.prevent="fetchAddresses">
          <v-row>
            <v-col cols="12" sm="4">
              <!-- Select para Estados -->
              <app-select v-model="state" label="Estado" :items="stateOptions" item-title="nome" item-value="id" />
            </v-col>
            <v-col cols="12" sm="8">
              <!-- Autocomplete para Municípios -->
              <app-autocomplete v-model="selectedCity" label="Cidade / Município" :items="cities" item-title="nome" item-value="nome" />
            </v-col>
            <v-col cols="12" sm="9">
              <!-- Campo de Texto para Logradouro -->
              <app-name-field id="logradouro" v-model="address" label="Logradouro" placeholder="Digite o logradouro" autofocus />
            </v-col>
            <v-col cols="12" sm="3">
              <!-- Botão para buscar CEP -->
              <v-btn class="mt-6" type="submit">Buscar CEP</v-btn>
            </v-col>
          </v-row>
        </v-form>
        <div class="d-flex"></div>
      </v-card-text>

      <v-card-item v-if="addresses.length > 0" id="8">
        <scale-y-transition>
          <!-- Tabela para exibir endereços buscados -->
          <v-data-table :headers="headers" :items="addresses" :page="page" :items-per-page="itemsPerPage" :items-length="pageCount">
            <template #item.action="{ item }">
              <v-btn icon="mdi-arrow-right-bold-circle" variant="plain" dencity="comfortable" @click="setSelectedCep(item.cep)"></v-btn>
            </template>
          </v-data-table>
        </scale-y-transition>
      </v-card-item>
    </v-card>
  </v-dialog>
</template>
