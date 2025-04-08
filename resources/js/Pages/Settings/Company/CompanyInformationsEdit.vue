<script setup>
const props = defineProps({
  data: {
    type: Object,
    required: true
  }
})

const form = useForm({
  name: '',
  fantasy_name: '',
  contact_name: '',
  person: '',
  cpf_cnpj: '',
  rg_insc_est: '',
  ccm: '',
  birth_date: '',
  logo: '',
  description: '',
  email: '',
  website: '',
  note: ''
})

const radioPerson = [
  {
    title: 'Jurídica',
    desc: 'Selecione para Pessoa Jurídica.',
    value: 'J',
    icon: {
      icon: 'mdi-office-building',
      size: '28'
    }
  },
  {
    title: 'Física',
    desc: 'Selecione para Pessoa Física.',
    value: 'F',
    icon: {
      icon: 'mdi-account',
      size: '28'
    }
  }
]

const loadPerson = (param, value) => {
  return form.person === 'F' ? param : value
}

onMounted(() => {
  Object.assign(form, props.data)
})
</script>

<template>
  <v-dialog activator="parent" max-width="700" persistent>
    <template #default="{ isActive }">
      <AppDialogCloseBtn @click="isActive.value = false" />
      <v-form
        @submit.prevent="
          form.put(route('settings.company.update', props.data.id), {
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
            <app-row-form icon="mdi-account-arrow-up" title="Tipo de Pessoa">
              <v-col cols="12">
                <app-radios-with-icon v-model:selected-radio="form.person" :radio-content="radioPerson" :grid-column="{ sm: '6', cols: '12' }" />
              </v-col>
            </app-row-form>

            <!-- Informações Pessoais -->
            <app-row-form icon="mdi-information" title="Informações Principais">
              <v-col cols="12">
                <app-name-field
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
                  v-model="form.fantasy_name"
                  :label="loadPerson('Apelido/Nome social', 'Nome Fantasia')"
                  :placeholder="loadPerson('Apelido/Como gosta de ser chamado(a)', 'Nome Fantasia')"
                  :error-messages="form.errors.fantasy_name"
                />
              </v-col>
              <v-col cols="12">
                <app-name-field
                  id="contact"
                  v-model="form.contact"
                  :label="loadPerson('Contato', 'Responsável')"
                  :placeholder="loadPerson('Contato', 'Responsável pela empresa')"
                  :error-messages="form.errors.contact"
                />
              </v-col>
              <v-col cols="4">
                <app-cpf-cnpj-field v-model="form.cpf_cnpj" :type-person="form.person" :error-messages="form.errors.cpf_cnpj" />
              </v-col>
              <v-col cols="3">
                <app-text-field v-model="form.rg_insc_est" :label="loadPerson('RG', 'Inscr. Estadual')" :error-messages="form.errors.rg_insc_est" />
              </v-col>
              <v-col v-show="form.person === 'J'" cols="2">
                <app-text-field v-model="form.ccm" label="CCM" :error-messages="form.errors.ccm" />
              </v-col>
              <v-col cols="3">
                <app-date-field
                  v-model="form.birth_date"
                  :label="loadPerson('Aniverssário', 'Inalguração')"
                  :placeholder="loadPerson('Aniverssário', 'Inalguração')"
                  :error-messages="form.errors.birth_date"
                />
              </v-col>
            </app-row-form>

            <!-- Mais Informações -->
            <app-row-form icon="mdi-information" title="Informações Adicionais">
              <v-col cols="12">
                <app-email-field v-model="form.email" label="E-mail" placeholder="meu-email@exemplo.com" :error-messages="form.errors.email" />
              </v-col>
              <v-col cols="12">
                <app-url-field v-model="form.website" label="Site" placeholder="https://meusite.com.br" :error-messages="form.errors.website" />
              </v-col>
              <v-col cols="12">
                <app-textarea v-model="form.note" label="Observações" placeholder="Escreva aqui anotações pertinentes à este cliente" rows="3" :error-messages="form.errors.note" />
              </v-col>
            </app-row-form>
          </v-card-text>
          <v-card-actions>
            <v-btn color="error" @click="isActive.value = false">Cancelar</v-btn>
            <v-btn type="submit" color="primary">Salvar</v-btn>
          </v-card-actions>
          <!--
            <pre>{{ form }}</pre>
            <pre>{{ props.errors }}</pre>
            -->
        </v-card>
      </v-form>
    </template>
  </v-dialog>
</template>
