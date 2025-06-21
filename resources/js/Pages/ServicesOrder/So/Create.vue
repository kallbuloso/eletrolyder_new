<script setup>
const props = defineProps({
  title: {
    type: String,
    required: true
  },
  routeDefault: {
    type: String,
    required: true
  }
})

const pageTitle = props.title

function routeBase(name) {
  return props.routeDefault + name
}

// Todo: Ajustar o form
const form = useForm({
  order_number: '',
  client_id: '',
  so_device_id: '',
  so_status_id: '',
  so_status_steps_id: '',
  warranty_expires_on: '',
  labor_cost: '',
  parts_cost: '',
  service_cost: '',
  discount: '',
  advance_payment: '',
  currently_editing: '',
  initially_attended_by: '',
  abandonment_alert: '',
  quoted_by_technician: '',
  repaired_by_technician: '',
  internal_notes: '',
  closed_at: '',
  reopened_at: ''
})

// Todo: alterar a rota abaixo
const submit = () => {
  form.post(route(routeBase('store')), {
    onSuccess() {
      form.reset()
      router.visit(route(routeBase('index')), {
        preserveScroll: true,
        preserveState: false
      })
    }
  })
}

onMounted(() => {
  // console.log('ServiceOrder page Create mounted')
})
</script>

<template>
  <app-modal width="450">
    <v-form @submit.prevent="submit">
      <v-card prepend-icon="mdi-plus" :title="pageTitle">
        <v-card-text class="mx-1">
          <!-- Todo: Ajustar fields do form -->
          <v-row>
            <v-col cols="12">
              <app-text-field id="order_number" v-model="form.order_number" label="Order Number" placeholder="Order Number" :error-messages="form.errors.order_number" />
            </v-col>
            <v-col cols="12">
              <app-text-field id="client_id" v-model="form.client_id" label="Client Id" placeholder="Client Id" :error-messages="form.errors.client_id" />
            </v-col>
            <v-col cols="12">
              <app-text-field id="so_device_id" v-model="form.so_device_id" label="So Device Id" placeholder="So Device Id" :error-messages="form.errors.so_device_id" />
            </v-col>
            <v-col cols="12">
              <app-text-field id="so_status_id" v-model="form.so_status_id" label="So Status Id" placeholder="So Status Id" :error-messages="form.errors.so_status_id" />
            </v-col>
            <v-col cols="12">
              <app-text-field
                id="so_status_steps_id"
                v-model="form.so_status_steps_id"
                label="So Status Steps Id"
                placeholder="So Status Steps Id"
                :error-messages="form.errors.so_status_steps_id"
              />
            </v-col>
            <v-col cols="12">
              <app-text-field id="internal_notes" v-model="form.internal_notes" label="Internal Notes" placeholder="Internal Notes" :error-messages="form.errors.internal_notes" />
            </v-col>
          </v-row>
        </v-card-text>
        <v-card-actions>
          <v-spacer />
          <!-- Todo: Alterar rota ou excluir, caso não seja usada -->
          <!-- <Link :href="route(routeBase('index'))" as="div">
            <v-btn variant="text">Cancelar</v-btn>
          </Link> -->
          <v-btn type="submit" color="primary" :loading="form.processing">Salvar</v-btn>
        </v-card-actions>
      </v-card>
    </v-form>
  </app-modal>
</template>
