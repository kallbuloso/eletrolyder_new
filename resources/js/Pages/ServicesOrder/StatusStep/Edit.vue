<script setup>
const props = defineProps({
  data: {
    type: Object,
    required: true
  },
  title: {
    type: String,
    required: true
  },
  errors: {
    type: Object,
    default: () => ({})
  }
})

const form = useForm({
  id: props.data.id,
  tenant_id: usePage().props.auth.user.tenant_id,
  so_status_id: props.data.so_status_id,
  description: props.data.description
})

const submit = () => {
  form.put(route('orders.statusStep.update', props.data.id), {
    onSuccess() {
      form.reset()
    }
  })
}
</script>

<template>
  <app-modal width="450">
    <v-form @submit.prevent="submit">
      <v-card prepend-icon="mdi-pencil" :title="props.title">
        <v-card-text class="mx-1">
          <v-row>
            <v-col cols="12">
              <app-text-field id="description" v-model="form.description" label="Descrição" placeholder="Descrição do passo" required :error-messages="form.errors.description" />
            </v-col>
          </v-row>
        </v-card-text>
        <v-card-actions>
          <v-spacer />
          <v-btn type="submit" color="primary" :loading="form.processing">Atualizar</v-btn>
        </v-card-actions>
      </v-card>
    </v-form>
  </app-modal>
</template>
