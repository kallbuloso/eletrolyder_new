<script setup>
const form = useForm({
  tenant_id: '',
  so_status_id: '',
  description: ''
})

const submit = () => {
  form.post('/so-status-steps', {
    onSuccess() {
      form.reset()
    }
  })
}

onMounted(() => {
  // console.log('SoStatusStep page Create mounted')
})
</script>

<template layout="AppShell,AuthenticatedLayout">
  <v-form @submit.prevent="submit">
    <v-card class="mx-auto" width="400" prepend-icon="mdi-plus" :title="$page.props.title">
      <v-card-text>
        <v-text-field v-model="form.tenant_id" label="Tenant Id" placeholder="Tenant Id" :error-messages="form.errors.tenant_id" />
        <v-text-field v-model="form.so_status_id" label="So Status Id" placeholder="So Status Id" :error-messages="form.errors.so_status_id" />
        <v-text-field v-model="form.description" label="Description" placeholder="Description" :error-messages="form.errors.description" />
      </v-card-text>
      <v-card-actions>
        <v-spacer />
        <Link :href="route('so-status-steps.index')" as="div">
          <v-btn variant="text">Cancelar</v-btn>
        </Link>
        <v-btn type="submit" color="primary" :loading="form.processing">Salvar</v-btn>
      </v-card-actions>
    </v-card>
  </v-form>
</template>
