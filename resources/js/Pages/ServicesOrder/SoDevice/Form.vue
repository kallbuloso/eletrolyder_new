<script setup>
const props = defineProps({
  data: {
    type: Object,
    required: false
  }
})

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

const submit = () => {
  if (props.data) {
    form.put(route('so-devices.update', props.data.id), {
      onSuccess() {
        form.reset()
      }
    })
  } else {
    form.post(route('so-devices.store'), {
      onSuccess() {
        form.reset()
      }
    })
  }
}

onMounted(() => {
  if (props.data) {
    form.tenant_id = props.data.tenant_id
    form.so_device_type_id = props.data.so_device_type_id
    form.description = props.data.description
    form.brand = props.data.brand
    form.model = props.data.model
    form.serial_number = props.data.serial_number
    form.damages = props.data.damages
    form.accessories = props.data.accessories
    form.notes = props.data.notes
    form.warranty_provider = props.data.warranty_provider
    form.purchase_date = props.data.purchase_date
    form.reseller = props.data.reseller
    form.invoice_number = props.data.invoice_number
    form.warranty_certificate = props.data.warranty_certificate
  }
  // console.log('SoDevice page Form mounted')
})
</script>

<template layout="AppShell,AuthenticatedLayout">
  <v-form @submit.prevent="submit">
    <v-card class="mx-auto" width="400" :prepend-icon="props.data ? 'mdi-pencil' : 'mdi-plus'" :title="$page.props.title">
      <v-card-text>
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
      </v-card-text>
      <v-card-actions>
        <v-spacer />
        <Link :href="route('so-devices.index')" as="div">
          <v-btn variant="text">Cancelar</v-btn>
        </Link>
        <v-btn type="submit" color="primary" :loading="form.processing">{{ props.data ? 'Atualizar' : 'Salvar' }}</v-btn>
      </v-card-actions>
    </v-card>
  </v-form>
</template>
