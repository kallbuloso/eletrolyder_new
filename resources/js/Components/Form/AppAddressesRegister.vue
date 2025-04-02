<script setup>
const props = defineProps({
  modelValue: {
    type: Array,
    default: () => []
  },
  errors: {
    type: Object,
    default: () => ({})
  }
})

const emit = defineEmits(['update:modelValue'])

const addresses = ref([...props.modelValue])

const addAddress = () => {
  addresses.value.push({
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
}

const removeAddress = (index) => {
  addresses.value.splice(index, 1)
}

watch(
  addresses,
  (newAddresses) => {
    emit('update:modelValue', newAddresses)
  },
  { deep: true }
)
</script>

<template>
  <v-row>
    <v-col cols="12">
      <div>
        <p class="font-weight-medium"><v-icon icon="mdi-map-marker-radius" /> Endereço(s)</p>
        <v-divider />
      </div>
    </v-col>
    <v-col cols="12">
      <v-row v-for="(address, index) in addresses" :key="index">
        <v-col cols="12">
          <app-address-form v-model="addresses[index]" :errors="props.errors[`addresses.${index}`] || {}" />
          <div class="d-flex flex-row justify-end my-4">
            <v-btn v-tooltip="'Excluir Endereço'" color="error" prepend-icon="mdi-delete" variant="text" @click="removeAddress(index)"> Excluir Endereço </v-btn>
          </div>
        </v-col>
      </v-row>
      <v-row>
        <v-col v-show="!addresses[0]" cols="12" class="text-center">
          <v-btn color="primary" prepend-icon="mdi-home" @click="addAddress">Adicionar Endereço</v-btn>
        </v-col>
      </v-row>
    </v-col>
  </v-row>
</template>
