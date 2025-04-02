<script setup>
const props = defineProps({
  modelId: {
    type: Number,
    required: false
  },
  routeStore: {
    type: String,
    required: false
  }
})

const address = ref({
  id: null,
  type: 'residencial',
  street: '',
  number: '',
  complement: '',
  neighborhood: '',
  city: '',
  state: 'SP',
  country: 'BR',
  zip_code: '',
  reference: ''
})

const form = useForm(address.value)

watch(
  () => address.value,
  (newValue) => {
    Object.assign(form, newValue)
  },
  { deep: true }
)
</script>

<template>
  <v-dialog activator="parent" max-width="700" persistent>
    <template #default="{ isActive }">
      <AppDialogCloseBtn @click="isActive.value = false" />
      <v-form
        @submit.prevent="
          form.post(route(props.routeStore, props.modelId), {
            onSuccess() {
              form.reset()
              isActive.value = false
            }
          })
        "
      >
        <v-card prepend-icon="mdi-map-marker-account" title="Adicionar Endereço">
          <v-card-text>
            <app-address-form v-model="address" :errors="form.errors" />
          </v-card-text>
          <v-card-actions>
            <v-btn color="error" @click="isActive.value = false">Cancelar</v-btn>
            <v-btn type="submit" color="primary" :disabled="form.processing">Salvar</v-btn>
          </v-card-actions>
        </v-card>
      </v-form>
    </template>
  </v-dialog>
</template>
