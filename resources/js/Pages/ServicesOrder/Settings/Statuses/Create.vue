<script setup>
const props = defineProps({
  title: {
    type: String,
    required: true
  },
  errors: {
    type: Object,
    default: () => ({})
  }
})

const form = useForm({
  description: '',
  status_type: '0',
  generates_revenue: true
})

const submit = () => {
  form.post(route('orders.soSettings.soStatus.store'), {
    onSuccess: () => form.reset()
  })
}

const statusTypes = [
  { title: 'Entada', value: '0' },
  { title: 'Em Andamento', value: '1' },
  { title: 'Saída', value: '2' }
]
</script>

<template>
  <app-modal width="450">
    <v-form @submit.prevent="submit">
      <v-card :prepend-icon="'mdi-plus'" :title="props.title">
        <v-card-text class="mx-1">
          <v-row>
            <v-col cols="12">
              <app-text-field id="description" v-model="form.description" label="Descrição" placeholder="Descrição do status" autofocus :error-messages="form.errors.description" />
            </v-col>
            <v-col cols="7">
              <app-select
                id="status_type"
                v-model="form.status_type"
                :items="statusTypes"
                label="Tipo de Status"
                placeholder="Selecione o tipo de status"
                :error-messages="form.errors.status_type"
              />
            </v-col>
            <v-spacer />
            <v-col cols="5">
              <v-checkbox id="generates_revenue" v-model="form.generates_revenue" class="mt-6" label="Gera Receita?" :error-messages="form.errors.generates_revenue" />
            </v-col>
          </v-row>
        </v-card-text>
        <v-card-actions class="mx-4">
          <v-spacer />
          <v-btn type="submit" color="primary" variant="text" :loading="form.processing">Salvar</v-btn>
        </v-card-actions>
      </v-card>
    </v-form>
  </app-modal>
</template>
