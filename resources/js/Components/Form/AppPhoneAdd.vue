<script setup>
const props = defineProps({
  modelId: {
    type: [Number, String],
    default: null
  },
  routeStore: {
    type: String,
    required: false
  }
})

const form = useForm({
  phone_type: 'P',
  phone_number: '',
  phone_has_whatsapp: false,
  phone_contact: ''
})

watch(
  () => form.phone_type === 'P',
  () => {
    form.phone_contact = ''
  }
)
</script>

<template>
  <v-dialog activator="parent" width="450" persistent>
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
        <v-card prepend-icon="mdi-phone-plus" title="Adicionar Telefone">
          <v-card-item>
            <v-col cols="12">
              <v-row>
                <v-radio-group v-model="form.phone_type" inline>
                  <v-radio label="Principal" value="P"></v-radio>
                  <v-radio label="Contato" value="C"></v-radio>
                </v-radio-group>
              </v-row>
              <v-row>
                <v-col v-if="form.phone_type === 'C'">
                  <app-name-field v-model="form.phone_contact" label="Contato" placeholder="Nome do contato" :error-messages="form.errors.phone_contact" />
                </v-col>
              </v-row>
            </v-col>
            <v-col cols="12">
              <div class="d-flex align-content-between">
                <app-phone-field
                  v-model="form.phone_number"
                  label="Telefone"
                  prepend-inner-icon="mdi-phone"
                  placeholder="Somente números"
                  clearable
                  autofocus
                  :error-messages="form.errors.phone_number"
                />
                <div class="d-flex align-content-between mt-6">
                  <v-checkbox v-model="form.phone_has_whatsapp" v-tooltip="`Clique se tiver Whatsapp`" class="ml-2" true-icon="mdi-whatsapp" false-icon="mdi-whatsapp" />
                </div>
              </div>
            </v-col>
          </v-card-item>
          <template #actions>
            <v-btn type="submit" color="primary">Adicionar</v-btn>
          </template>
        </v-card>
      </v-form>
    </template>
  </v-dialog>
</template>
