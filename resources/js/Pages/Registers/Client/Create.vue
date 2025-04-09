<script setup>
const props = defineProps({
  data: {
    type: [Object, Array],
    required: false
  },
  phones: {
    type: [Object, Array],
    required: false
  },
  address: {
    type: [Object, Array],
    required: false
  },
  errors: {
    type: Object,
    default: () => ({})
  }
})

const form = useForm({
  name: '',
  nick_name: '',
  person: 'F',
  cpf_cnpj: '',
  gender: 'M',
  note: '',
  status: 'A',
  last_purchase: '',
  phones: [],
  addresses: []
})

const radioPerson = [
  {
    title: 'Física',
    desc: 'Selecione para Pessoa Física.',
    value: 'F',
    icon: {
      icon: 'mdi-account',
      size: '28'
    }
  },
  {
    title: 'Jurídica',
    desc: 'Selecione para Pessoa Jurídica.',
    value: 'J',
    icon: {
      icon: 'mdi-office-building',
      size: '28'
    }
  }
]

const verificaPerson = () => {
  if (form.person === 'J') {
    form.gender = ''
  }
}

const loadPerson = (param, value) => {
  return form.person === 'F' ? param : value
}

const submit = () => {
  verificaPerson()
  if (props.data) {
    form.put(route('registers.client.update', props.data.id), {
      onSuccess() {
        form.reset()
      }
    })
  } else {
    form.post(route('registers.client.store'), {
      onSuccess() {
        form.reset()
      }
    })
  }
}

onMounted(() => {
  if (props.data) {
    form.name = props.data.name
    form.nick_name = props.data.nick_name
    form.person = props.data.person
    form.cpf_cnpj = props.data.cpf_cnpj
    form.gender = props.data.gender
    form.note = props.data.note
    form.status = props.data.status
    form.last_purchase = props.data.last_purchase
    form.phones = props.phones
    form.addresses = props.addresses
  }
})
</script>

<template>
  <app-modal width="700">
    <v-form @submit.prevent="submit">
      <v-card class="mx-auto" :prepend-icon="props.data ? 'mdi-pencil' : 'mdi-plus'" :title="$page.props.title">
        <v-card-text class="mx-4">
          <!-- Pessoa -->
          <app-row-form icon="mdi-account-arrow-up" title="Tipo de Pessoa">
            <v-col cols="12">
              <app-radios-with-icon v-model:selected-radio="form.person" :radio-content="radioPerson" :grid-column="{ sm: '6', cols: '12' }" />
            </v-col>
          </app-row-form>

          <!-- Informações Principais -->
          <app-row-form icon="mdi-information" title="Informações Principais">
            <v-col cols="12">
              <app-name-field
                id="full_name"
                v-model="form.name"
                :label="loadPerson('Nome', 'Rasão Social')"
                :placeholder="loadPerson('Mesmo do documento', 'Rasão Social da Empresa')"
                required
                :error-messages="form.errors.name"
              />
            </v-col>
            <v-col cols="12">
              <app-name-field
                id="nick_name"
                v-model="form.nick_name"
                :label="loadPerson('Apelido/Nome social', 'Nome Fantasia')"
                :placeholder="loadPerson('Apelido/Como gosta de ser chamado(a)', 'Nome Fantasia')"
                :error-messages="form.errors.nick_name"
              />
            </v-col>
            <v-col cols="4">
              <app-cpf-cnpj-field v-model="form.cpf_cnpj" :type-person="form.person" :error-messages="form.errors.cpf_cnpj" />
            </v-col>
            <v-col cols="4">
              <app-gender-select v-if="form.person === 'F'" :id="loadPerson('CPF', 'CNPJ')" v-model="form.gender" :error-messages="form.errors.gender" />
            </v-col>
          </app-row-form>

          <!-- Telefones -->
          <app-phones-register v-model="form.phones" :errors="props.errors" />

          <!-- Endereço -->
          <app-addresses-register v-model="form.addresses" :errors="props.errors" />

          <!-- Mais Informações -->
          <app-row-form icon="mdi-information" title="Notas">
            <v-col cols="12">
              <app-textarea v-model="form.note" label="Observações" placeholder="Escreva aqui anotações pertinentes à este cliente" rows="3" :error-messages="form.errors.note" />
            </v-col>
          </app-row-form>
        </v-card-text>
        <v-card-actions class="mx-4">
          <v-spacer />
          <Link :href="route('registers.client.index')" as="div">
            <v-btn class="mr-2" variant="text">Cancelar</v-btn>
          </Link>
          <v-btn type="submit" color="primary" variant="flat" :loading="form.processing">{{ props.data ? 'Atualizar' : 'Salvar' }}</v-btn>
        </v-card-actions>
      </v-card>
    </v-form>
  </app-modal>
</template>
