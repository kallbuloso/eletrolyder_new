<script setup>
const props = defineProps({
  data: {
    type: Array,
    required: true
  },
  title: {
    type: [Object, Array],
    required: true
  },
  errors: {
    type: Object,
    default: () => ({})
  }
})

const form = useForm({
  description: props.data.description,
  status_type: props.data.status_type,
  generates_revenue: props.data.generates_revenue
})

const submit = () => {
  form.post(route('orders.soStatus.store'), {
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
  <app-modal width="600">
    <v-form @submit.prevent="submit">
      <v-card :prepend-icon="'mdi-plus'" :title="props.title">
        <v-card-text class="mx-1">
          <v-row>
            <v-col cols="6">
              <app-text-field id="description" v-model="form.description" label="Descrição" placeholder="Descrição do status" required :error-messages="form.errors.description" />
            </v-col>
            <v-col cols="6">
              <app-select
                id="status_type"
                v-model="form.status_type"
                :items="statusTypes"
                label="Tipo de Status"
                placeholder="Selecione o tipo de status"
                required
                :error-messages="form.errors.status_type"
              />
            </v-col>
            <v-spacer />
            <v-col cols="6">
              <app-checkbox id="generates_revenue" v-model="form.generates_revenue" title="Gera Receita?" :error-messages="form.errors.generates_revenue" />
            </v-col>
          </v-row>
        </v-card-text>
        <v-card-actions class="mx-4">
          <v-spacer />
          <Link :href="route('orders.soStatus.index')" as="div">
            <v-btn class="mr-2" variant="text">Cancelar</v-btn>
          </Link>
          <v-btn type="submit" color="primary" variant="flat" :loading="form.processing">Salvar</v-btn>
        </v-card-actions>
      </v-card>
    </v-form>
  </app-modal>
</template>
