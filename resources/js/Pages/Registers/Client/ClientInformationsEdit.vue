<script setup>
const props = defineProps({
  data: {
    type: Object,
    required: true
  },
  errors: {
    type: Object,
    required: false
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
  blocking_reason: ''
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
    form.gender = null
  }
}

const verificaStatus = () => {
  if (form.status !== 'B') {
    form.blocking_reason = ''
  }
}

const loadPerson = (param, value) => {
  return form.person === 'F' ? param : value
}

const submit = (options) => {
  verificaPerson()
  verificaStatus()
  form.put(route('registers.client.update', props.data.id), options)
}

onMounted(() => {
  if (props.data) {
    Object.assign(form, props.data)
  }
})
</script>

<template>
  <v-dialog activator="parent" max-width="700" persistent>
    <template #default="{ isActive }">
      <AppDialogCloseBtn @click="isActive.value = false" />
      <v-form
        @submit.prevent="
          submit({
            preserveScroll: true,
            onSuccess() {
              isActive.value = false
            }
          })
        "
      >
        <v-card prepend-icon="mdi-map-marker-account" title="Editar Informações pessoais">
          <v-card-text>
            <!-- Pessoa -->
            <app-row-form icon="mdi-account-arrow-up" title="Status">
              <v-col cols="3">
                <app-select
                  v-model="form.status"
                  label="Status"
                  placeholder="Status"
                  :items="[
                    { title: 'Ativo', value: 'A' },
                    { title: 'Inativo', value: 'I' },
                    { title: 'Bloqueado', value: 'B' }
                  ]"
                  item-title="title"
                  item-value="value"
                  flat
                  :error-messages="form.errors.status"
                />
              </v-col>
              <v-col cols="9">
                <app-text-field
                  v-if="form.status === 'B'"
                  v-model="form.blocking_reason"
                  label="Motivo do Bloqueio"
                  placeholder="Motivo do Bloqueio do Cliente"
                  :required="form.status === 'B'"
                  :error-messages="form.errors.blocking_reason"
                />
              </v-col>
            </app-row-form>
            <app-row-form icon="mdi-account-arrow-up" title="Tipo de Pessoa">
              <v-col cols="12">
                <app-radios-with-icon v-model:selected-radio="form.person" :radio-content="radioPerson" :grid-column="{ sm: '6', cols: '12' }" />
              </v-col>
            </app-row-form>

            <!-- Informações Pessoais -->
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

            <!-- Mais Informações -->
            <v-row>
              <v-col cols="12">
                <app-textarea v-model="form.note" label="Observações" placeholder="Escreva aqui anotações pertinentes à este cliente" rows="3" :error-messages="form.errors.note" />
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-actions>
            <v-btn color="error" @click="isActive.value = false">Cancelar</v-btn>
            <v-btn type="submit" color="primary">Salvar</v-btn>
          </v-card-actions>
          <!--
            <pre>{{ props.data }}</pre>
            <pre>{{ props.errors }}</pre>
            -->
        </v-card>
      </v-form>
    </template>
  </v-dialog>
</template>
