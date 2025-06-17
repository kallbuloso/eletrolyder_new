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
  tenant_id: '',
  so_device_type_id: '',
  description: '',
  brand: '',
  model: '',
  serial_number: '',
  damages: '',
  accessories: '',
  notes: '',
  warranty_provider: '',
  purchase_date: '',
  reseller: '',
  invoice_number: '',
  warranty_certificate: ''
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
  // console.log('SoDevice page Create mounted')
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
              <v-text-field id="tenant_id" v-model="form.tenant_id" label="Tenant Id" placeholder="Tenant Id" :error-messages="form.errors.tenant_id" />
            </v-col>
            <v-col cols="12">
              <v-text-field
                id="so_device_type_id"
                v-model="form.so_device_type_id"
                label="So Device Type Id"
                placeholder="So Device Type Id"
                :error-messages="form.errors.so_device_type_id"
              />
            </v-col>
            <v-col cols="12">
              <v-text-field id="description" v-model="form.description" label="Description" placeholder="Description" :error-messages="form.errors.description" />
            </v-col>
            <v-col cols="12">
              <v-text-field id="brand" v-model="form.brand" label="Brand" placeholder="Brand" :error-messages="form.errors.brand" />
            </v-col>
            <v-col cols="12">
              <v-text-field id="model" v-model="form.model" label="Model" placeholder="Model" :error-messages="form.errors.model" />
            </v-col>
            <v-col cols="12">
              <v-text-field id="serial_number" v-model="form.serial_number" label="Serial Number" placeholder="Serial Number" :error-messages="form.errors.serial_number" />
            </v-col>
            <v-col cols="12">
              <v-text-field id="damages" v-model="form.damages" label="Damages" placeholder="Damages" :error-messages="form.errors.damages" />
            </v-col>
            <v-col cols="12">
              <v-text-field id="accessories" v-model="form.accessories" label="Accessories" placeholder="Accessories" :error-messages="form.errors.accessories" />
            </v-col>
            <v-col cols="12">
              <v-text-field id="notes" v-model="form.notes" label="Notes" placeholder="Notes" :error-messages="form.errors.notes" />
            </v-col>
            <v-col cols="12">
              <v-text-field
                id="warranty_provider"
                v-model="form.warranty_provider"
                label="Warranty Provider"
                placeholder="Warranty Provider"
                :error-messages="form.errors.warranty_provider"
              />
            </v-col>
            <v-col cols="12">
              <v-text-field id="purchase_date" v-model="form.purchase_date" label="Purchase Date" placeholder="Purchase Date" :error-messages="form.errors.purchase_date" />
            </v-col>
            <v-col cols="12">
              <v-text-field id="reseller" v-model="form.reseller" label="Reseller" placeholder="Reseller" :error-messages="form.errors.reseller" />
            </v-col>
            <v-col cols="12">
              <v-text-field id="invoice_number" v-model="form.invoice_number" label="Invoice Number" placeholder="Invoice Number" :error-messages="form.errors.invoice_number" />
            </v-col>
            <v-col cols="12">
              <v-text-field
                id="warranty_certificate"
                v-model="form.warranty_certificate"
                label="Warranty Certificate"
                placeholder="Warranty Certificate"
                :error-messages="form.errors.warranty_certificate"
              />
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
