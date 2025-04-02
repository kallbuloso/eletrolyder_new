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

const phoneNumbers = ref([...props.modelValue])

const addPhone = () => {
  phoneNumbers.value.push({
    phone_type: 'P',
    phone_number: '',
    phone_has_whatsapp: false,
    phone_contact: ''
  })
}

const removePhone = (index) => {
  phoneNumbers.value.splice(index, 1)
}

const getErrorMessage = (index, model) => {
  return props.errors[`phones.${index}.${model}`] || ''
}

watch(
  phoneNumbers,
  (newPhoneNumbers) => {
    emit('update:modelValue', newPhoneNumbers)
  },
  { deep: true }
)
</script>

<template>
  <v-row>
    <v-col cols="12">
      <div>
        <p class="font-weight-medium"><v-icon icon="mdi-phone" /> Telefone(s)</p>
        <v-divider />
      </div>
    </v-col>
    <v-col cols="12">
      <v-row v-for="(phone, index) in phoneNumbers" :key="index">
        <v-col cols="3">
          <app-select
            v-model="phone.phone_type"
            label="Tipo de Telefone"
            :items="[
              { title: 'Principal', value: 'P' },
              { title: 'Contato', value: 'C' }
            ]"
            item-title="title"
            item-value="value"
          />
        </v-col>
        <v-col cols="4">
          <app-name-field
            v-model="phone.phone_contact"
            v-tooltip="`Obrigatório se o tipo de telefone for 'Contato'`"
            label="Contato"
            placeholder="Nome do contato"
            :disabled="phone.phone_type === 'P'"
            :required="phone.phone_type === 'C'"
            :error-messages="getErrorMessage(index, 'phone_contact')"
          />
        </v-col>
        <v-col>
          <div class="d-flex align-content-between">
            <app-phone-field
              v-model="phone.phone_number"
              label="Número do telefone"
              prepend-inner-icon="mdi-phone"
              style="min-width: 190px; max-width: 190px"
              required
              :error-messages="getErrorMessage(index, 'phone_number')"
            />
            <div class="d-flex align-content-between mt-6">
              <v-checkbox v-model="phone.phone_has_whatsapp" v-tooltip="`Clique se tiver Whatsapp`" true-icon="mdi-whatsapp" false-icon="mdi-whatsapp" />
              <v-icon v-tooltip="'Excluir Telefone'" class="mt-2 ml-1" color="error" icon="mdi-delete" size="24" link @click="removePhone(index)" />
            </div>
          </div>
        </v-col>
      </v-row>
    </v-col>
    <v-row>
      <v-col cols="12" class="text-center">
        <v-btn color="primary" class="mt-4" prepend-icon="mdi-phone" @click="addPhone">Adicionar Telefone</v-btn>
      </v-col>
    </v-row>
  </v-row>
</template>
