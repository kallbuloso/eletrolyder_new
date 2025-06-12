<script setup>
const props = defineProps({
  title: {
    type: String,
    required: true
  },
  soStatusId: {
    type: [Number, String],
    required: true
  },
  errors: {
    type: Object,
    default: () => ({})
  }
})

const form = useForm({
  so_status_id: props.soStatusId,
  tenant_id: usePage().props.auth.user.tenant_id,
  description: ''
})

const submit = () => {
  form.post(route('orders.soSettings.statusStep.store'), {
    onSuccess() {
      form.reset()
    }
  })
}

onMounted(() => {
  // console.log('SoStatusStep page Create mounted')
})
</script>

<template>
  <app-modal width="450">
    <v-form @submit.prevent="submit">
      <v-card prepend-icon="mdi-plus" :title="props.title">
        <v-card-text class="mx-1">
          <v-row>
            <v-col cols="12">
              <app-text-field id="description" v-model="form.description" label="Descrição" placeholder="Descrição do passo" autofocus :error-messages="form.errors.description" />
            </v-col>
          </v-row>
        </v-card-text>
        <v-card-actions>
          <v-spacer />
          <v-btn type="submit" color="primary" :loading="form.processing">Salvar</v-btn>
        </v-card-actions>
      </v-card>
    </v-form>
  </app-modal>
</template>
