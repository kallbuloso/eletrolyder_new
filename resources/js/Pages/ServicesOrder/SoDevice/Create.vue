<script setup>
const props = defineProps({
  title: {
    type: String,
    required: true
  },
  routeDefault: {
    type: String,
    required: true
  },
  soDevicesType: {
    type: Array,
    required: true
  }
})

const pageTitle = props.title

function routeBase(name) {
  return props.routeDefault + name
}

// Todo: Ajustar o form
const form = useForm({
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
  // console.log(props.soDevicesType)
})
</script>

<template>
  <app-modal width="800">
    <v-form @submit.prevent="submit">
      <v-card prepend-icon="mdi-plus" :title="pageTitle">
        <v-card-text class="mx-1">
          <v-row>
            <v-col cols="4">
              <app-autocomplete
                id="so_device_type_id"
                v-model="form.so_device_type_id"
                label="Tipo de Dispositivo"
                :items="props.soDevicesType"
                item-value="id"
                item-title="description"
                autofocus
                placeholder="TV, Computador, Impressora, etc."
                :error-messages="form.errors.so_device_type_id"
              />
            </v-col>
            <v-col cols="8">
              <app-name-field id="description" v-model="form.description" label="Descrição" placeholder="LED 32, Notebook, etc." :error-messages="form.errors.description" />
            </v-col>
            <!-- <pre>{{ form.so_device_type_id }}</pre> -->
            <v-col cols="5">
              <!-- Todo: adicionar botão com etiqueta rasurada ou sem marca -->
              <app-upper-field id="brand" v-model="form.brand" label="Marca" placeholder="ex: Samsung" :error-messages="form.errors.brand" />
            </v-col>
            <v-col cols="7">
              <!-- Todo: adicionar botão com etiqueta rasurada ou sem modelo -->
              <app-upper-field id="model" v-model="form.model" label="Modelo" placeholder="ex: Galaxy S21" :error-messages="form.errors.model" />
            </v-col>
            <v-col cols="5">
              <!-- Todo: adicionar botão com etiqueta rasurada ou sem número de série -->
              <app-upper-field
                id="serial_number"
                v-model="form.serial_number"
                label="Número de Série / IMEI"
                placeholder="Número de Série"
                :error-messages="form.errors.serial_number"
              />
            </v-col>
            <v-col cols="7">
              <app-text-field
                id="damages"
                v-model="form.damages"
                label="Danos visíveis"
                placeholder="ex: Tela trincada, Gabinete riscado, faltando peças"
                :error-messages="form.errors.damages"
              />
            </v-col>
            <v-col cols="6">
              <app-text-field
                id="accessories"
                v-model="form.accessories"
                label="Acessórios"
                placeholder="ex: suporte, cabo de força, base, etc."
                :error-messages="form.errors.accessories"
              />
            </v-col>
            <v-col cols="6">
              <app-text-field id="notes" v-model="form.notes" label="Observações" placeholder="Notas sobre o dispositivo" :error-messages="form.errors.notes" />
            </v-col>
            <v-col cols="6">
              <app-text-field
                id="warranty_provider"
                v-model="form.warranty_provider"
                label="Fornecedor da Garantia"
                placeholder="Fornecedor da Garantia"
                :error-messages="form.errors.warranty_provider"
              />
            </v-col>
            <v-col cols="6">
              <app-text-field id="purchase_date" v-model="form.purchase_date" label="Purchase Date" placeholder="Purchase Date" :error-messages="form.errors.purchase_date" />
            </v-col>
            <v-col cols="6">
              <app-text-field id="reseller" v-model="form.reseller" label="Reseller" placeholder="Reseller" :error-messages="form.errors.reseller" />
            </v-col>
            <v-col cols="6">
              <app-text-field id="invoice_number" v-model="form.invoice_number" label="Invoice Number" placeholder="Invoice Number" :error-messages="form.errors.invoice_number" />
            </v-col>
            <v-col cols="6">
              <app-text-field
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
