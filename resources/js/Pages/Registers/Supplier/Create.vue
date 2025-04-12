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
  contact: '',
  person: 'F',
  cpf_cnpj: '',
  birth_date: '',
  site: '',
  email: '',
  note: '',
  status: 'A',
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

const loadPerson = (param, value) => {
  return form.person === 'F' ? param : value
}

const submit = () => {
  if (props.data) {
    form.put(route('registers.supplier.update', props.data.id), {
      onSuccess() {
        form.reset()
      }
    })
  } else {
    form.post(route('registers.supplier.store'), {
      onSuccess() {
        form.reset()
        router.visit(route('registers.supplier.index'), {
          preserveScroll: true,
          preserveState: false
        })
      }
    })
  }
}

onMounted(() => {
  if (props.data) {
    form.name = props.data.name
    form.nick_name = props.data.nick_name
    form.contact = props.data.contact
    form.person = props.data.person
    form.cpf_cnpj = props.data.cpf_cnpj
    form.birth_date = props.data.birth_date
    form.site = props.data.site
    form.email = props.data.email
    form.note = props.data.note
    form.status = props.data.status
    form.phones = props.phones
    form.addresses = props.addresses
  }
})
</script>

<template layout="AppShell,AuthenticatedLayout">
  <app-modal width="700">
    <v-form @submit.prevent="submit">
      <v-card class="mx-auto" :prepend-icon="props.data ? 'mdi-pencil' : 'iconify:material-symbols-light:add-business'" :title="$page.props.title">
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
                :label="loadPerson('Nome', 'Razão Social')"
                :placeholder="loadPerson('Mesmo do documento', 'Razão Social da Empresa')"
                required
                :error-messages="form.errors.name"
              />
            </v-col>
            <v-col cols="12">
              <app-name-field
                id="nick_name"
                v-model="form.nick_name"
                :label="loadPerson('Nome Fantasia', 'Nome Fantasia')"
                :placeholder="loadPerson('Nome Fantasia', 'Nome Fantasia')"
                :error-messages="form.errors.nick_name"
              />
            </v-col>
            <v-col cols="12" md="4">
              <app-cpf-cnpj-field v-model="form.cpf_cnpj" :type-person="form.person" :error-messages="form.errors.cpf_cnpj" />
            </v-col>
            <v-col cols="12" md="4">
              <app-name-field id="contact" v-model="form.contact" label="Nome do Contato" placeholder="Nome do contato principal" :error-messages="form.errors.contact" />
            </v-col>
            <v-col cols="12" md="4">
              <app-text-field
                v-model="form.birth_date"
                label="Data de Fundação"
                placeholder="Data de fundação"
                type="date"
                :error-messages="form.errors.birth_date"
                density="comfortable"
                variant="outlined"
              />
            </v-col>
          </app-row-form>

          <!-- Telefones -->
          <app-phones-register v-model="form.phones" :errors="props.errors" />

          <!-- Endereço -->
          <app-addresses-register v-model="form.addresses" :errors="props.errors" />

          <!-- Contato -->
          <v-row>
            <v-col cols="12" md="6">
              <v-text-field v-model="form.site" label="Site" placeholder="Site da empresa" :error-messages="form.errors.site" density="comfortable" variant="outlined" />
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                v-model="form.email"
                label="E-mail"
                placeholder="E-mail principal"
                type="email"
                :error-messages="form.errors.email"
                density="comfortable"
                variant="outlined"
              />
            </v-col>
          </v-row>

          <!-- Mais Informações -->
          <v-row>
            <v-col cols="12">
              <app-textarea
                v-model="form.note"
                label="Observações"
                placeholder="Escreva aqui anotações pertinentes à este fornecedor"
                rows="3"
                :error-messages="form.errors.note"
              />
            </v-col>
          </v-row>
        </v-card-text>
        <v-card-actions class="mx-4">
          <v-spacer />
          <Link :href="route('registers.supplier.index')" as="div">
            <v-btn class="mr-2" variant="text">Cancelar</v-btn>
          </Link>
          <v-btn type="submit" color="primary" variant="flat" :loading="form.processing">{{ props.data ? 'Atualizar' : 'Salvar' }}</v-btn>
        </v-card-actions>
      </v-card>
    </v-form>
  </app-modal>
</template>
