<script setup>
const props = defineProps({
  data: {
    type: Object,
    required: false
  },
  title: {
    type: String,
    required: true
  },
  errors: {
    type: Object,
    default: () => ({})
  }
})

const value = shallowRef(props.data.status_type || '0')

const form = useForm({
  id: props.data.id,
  tenant_id: usePage().props.auth.user.tenant_id,
  description: props.data.description,
  status_type: value.value.toString(),
  generates_revenue: props.data.generates_revenue
})

const submit = () => {
  form.put(route('orders.soStatus.update', props.data.id), {
    onSuccess() {
      form.reset()
      router.visit(route('orders.soStatus.index'), {
        preserveScroll: true,
        preserveState: false
      })
    }
  })
}

const statusTypes = [
  { title: 'Entada', value: '0' },
  { title: 'Em Andamento', value: '1' },
  { title: 'Saída', value: '2' }
]
</script>

<template>
  <app-modal width="700">
    <v-form @submit.prevent="submit">
      <v-card :prepend-icon="'mdi-plus'" :title="props.title">
        <v-card-text class="mx-1">
          <v-row>
            <v-col cols="5">
              <app-text-field id="description" v-model="form.description" label="Descrição" placeholder="Descrição do status" required :error-messages="form.errors.description" />
            </v-col>
            <v-col cols="4">
              <app-select
                id="status_type"
                v-model="form.status_type"
                :items="statusTypes"
                item-title="title"
                item-value="value"
                label="Tipo de Status"
                placeholder="Selecione o tipo de status"
                required
                :error-messages="form.errors.status_type"
              />
            </v-col>
            <v-col cols="3">
              <v-checkbox id="generates_revenue" v-model="form.generates_revenue" class="mt-6" label="Gera Receita?" :error-messages="form.errors.generates_revenue" />
            </v-col>
          </v-row>
        </v-card-text>
        <v-card-actions class="mx-4">
          <v-spacer />
          <!-- <Link :href="route('orders.soStatus.index')" as="div">
            <v-btn class="mr-2" variant="text">Cancelar</v-btn>
          </Link> -->
          <v-btn type="submit" color="primary" variant="text" :loading="form.processing">Salvar</v-btn>
        </v-card-actions>
      </v-card>
    </v-form>
  </app-modal>
</template>
