<script setup>
const props = defineProps({
  data: {
    type: Object,
    required: true
  }
})
const address = ref({
  id: props.data.id,
  type: props.data.type,
  street: props.data.street,
  number: props.data.number,
  complement: props.data.complement,
  neighborhood: props.data.neighborhood,
  city: props.data.city,
  state: props.data.state,
  country: props.data.country,
  zip_code: props.data.zip_code,
  reference: props.data.reference
})

const form = useForm(address.value)

watch(
  () => address.value,
  () => {
    Object.assign(form, address.value)
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
          form.put(route('settings.address.update', props.data.id), {
            onSuccess() {
              isActive.value = false
              form.reset()
            }
          })
        "
      >
        <v-card prepend-icon="mdi-map-marker-account" title="Editar Endereço">
          <v-card-text>
            <app-address-form v-model="address" :errors="form.errors" />
          </v-card-text>
          <v-card-actions>
            <!-- <v-btn color="error" @click="isActive.value = false">Cancelar</v-btn> -->
            <v-btn type="submit" color="primary" :disabled="form.processing">Salvar</v-btn>
          </v-card-actions>
        </v-card>
      </v-form>
    </template>
  </v-dialog>
</template>
