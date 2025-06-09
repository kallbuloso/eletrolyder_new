<script setup>
const props = defineProps({
  data: {
    type: Object,
    required: true
  }
})

const form = useForm({
  tenant_id: props.data.tenant_id,
  so_status_id: props.data.so_status_id,
  description: props.data.description
})

const submit = () => {
  form.put('/so-status-steps/' + props.data.id, {
    onSuccess() {
      form.reset()
    }
  })
}

onMounted(() => {
  form.tenant_id = props.data.tenant_id
  form.so_status_id = props.data.so_status_id
  form.description = props.data.description
  // console.log('SoStatusStep page Edit mounted')
})
</script>

<template layout="AppShell,AuthenticatedLayout">
  <v-form @submit.prevent="submit">
    <v-card class="mx-auto" width="400" prepend-icon="mdi-pencil" :title="$page.props.title">
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
        <v-btn type="submit" color="primary" :loading="form.processing">Atualizar</v-btn>
      </v-card-actions>
    </v-card>
  </v-form>
</template>
