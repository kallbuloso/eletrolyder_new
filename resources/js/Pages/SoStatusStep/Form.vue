<script setup>
const props = defineProps({
  data: {
    type: Object,
    required: false
  },
})

const form = useForm({ 
	tenant_id: '',
	so_status_id: '',
	description: '',
})

const submit = () => {
  if (props.data) {
    form.put(route('so-status-steps.update', props.data.id), {
      onSuccess() {
        form.reset()
      }
    })
  } else {
    form.post(route('so-status-steps.store'), {
      onSuccess() {
        form.reset()
      }
    })
  }

}

onMounted(() => {
  if (props.data) { 
		form.tenant_id = props.data.tenant_id
		form.so_status_id = props.data.so_status_id
		form.description = props.data.description
  }
  // console.log('SoStatusStep page Form mounted')
})
</script>

<template layout="AppShell,AuthenticatedLayout">
  <v-form @submit.prevent="submit">
    <v-card class="mx-auto" width="400" :prepend-icon="props.data ? 'mdi-pencil' : 'mdi-plus'" :title="$page.props.title">
        <v-card-text>
          
          <v-text-field
            v-model="form.tenant_id"
            label="Tenant Id"
            placeholder="Tenant Id"
            :error-messages="form.errors.tenant_id"
          />
          <v-text-field
            v-model="form.so_status_id"
            label="So Status Id"
            placeholder="So Status Id"
            :error-messages="form.errors.so_status_id"
          />
          <v-text-field
            v-model="form.description"
            label="Description"
            placeholder="Description"
            :error-messages="form.errors.description"
          />

        </v-card-text>
        <v-card-actions>
          <v-spacer />
          <Link :href="route('so-status-steps.index')" as="div">
            <v-btn variant="text">Cancelar</v-btn>
          </Link>
          <v-btn type="submit" color="primary" :loading="form.processing">{{ props.data ? 'Atualizar' : 'Salvar' }}</v-btn>
        </v-card-actions>
    </v-card>
  </v-form>
</template>
