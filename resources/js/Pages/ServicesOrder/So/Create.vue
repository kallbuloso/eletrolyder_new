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
  tenant_id: '',
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
  in_use: '',
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
              <app-text-field id="tenant_id" v-model="form.tenant_id" label="Tenant Id" placeholder="Tenant Id" :error-messages="form.errors.tenant_id" />
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
              <app-text-field
                id="warranty_expires_on"
                v-model="form.warranty_expires_on"
                label="Warranty Expires On"
                placeholder="Warranty Expires On"
                :error-messages="form.errors.warranty_expires_on"
              />
            </v-col>
            <v-col cols="12">
              <app-text-field id="labor_cost" v-model="form.labor_cost" label="Labor Cost" placeholder="Labor Cost" :error-messages="form.errors.labor_cost" />
            </v-col>
            <v-col cols="12">
              <app-text-field id="parts_cost" v-model="form.parts_cost" label="Parts Cost" placeholder="Parts Cost" :error-messages="form.errors.parts_cost" />
            </v-col>
            <v-col cols="12">
              <app-text-field id="service_cost" v-model="form.service_cost" label="Service Cost" placeholder="Service Cost" :error-messages="form.errors.service_cost" />
            </v-col>
            <v-col cols="12">
              <app-text-field id="discount" v-model="form.discount" label="Discount" placeholder="Discount" :error-messages="form.errors.discount" />
            </v-col>
            <v-col cols="12">
              <app-text-field
                id="advance_payment"
                v-model="form.advance_payment"
                label="Advance Payment"
                placeholder="Advance Payment"
                :error-messages="form.errors.advance_payment"
              />
            </v-col>
            <v-col cols="12">
              <app-text-field id="in_use" v-model="form.in_use" label="In Use" placeholder="In Use" :error-messages="form.errors.in_use" />
            </v-col>
            <v-col cols="12">
              <app-text-field
                id="currently_editing"
                v-model="form.currently_editing"
                label="Currently Editing"
                placeholder="Currently Editing"
                :error-messages="form.errors.currently_editing"
              />
            </v-col>
            <v-col cols="12">
              <app-text-field
                id="initially_attended_by"
                v-model="form.initially_attended_by"
                label="Initially Attended By"
                placeholder="Initially Attended By"
                :error-messages="form.errors.initially_attended_by"
              />
            </v-col>
            <v-col cols="12">
              <app-text-field
                id="abandonment_alert"
                v-model="form.abandonment_alert"
                label="Abandonment Alert"
                placeholder="Abandonment Alert"
                :error-messages="form.errors.abandonment_alert"
              />
            </v-col>
            <v-col cols="12">
              <app-text-field
                id="quoted_by_technician"
                v-model="form.quoted_by_technician"
                label="Quoted By Technician"
                placeholder="Quoted By Technician"
                :error-messages="form.errors.quoted_by_technician"
              />
            </v-col>
            <v-col cols="12">
              <app-text-field
                id="repaired_by_technician"
                v-model="form.repaired_by_technician"
                label="Repaired By Technician"
                placeholder="Repaired By Technician"
                :error-messages="form.errors.repaired_by_technician"
              />
            </v-col>
            <v-col cols="12">
              <app-text-field id="internal_notes" v-model="form.internal_notes" label="Internal Notes" placeholder="Internal Notes" :error-messages="form.errors.internal_notes" />
            </v-col>
            <v-col cols="12">
              <app-text-field id="closed_at" v-model="form.closed_at" label="Closed At" placeholder="Closed At" :error-messages="form.errors.closed_at" />
            </v-col>
            <v-col cols="12">
              <app-text-field id="reopened_at" v-model="form.reopened_at" label="Reopened At" placeholder="Reopened At" :error-messages="form.errors.reopened_at" />
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
