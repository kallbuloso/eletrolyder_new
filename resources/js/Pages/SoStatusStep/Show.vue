<script setup>
const props = defineProps({
  data: {
    type: Object,
    required: true
  }
})
onMounted(() => {
  console.log('SoStatusStep page Show mounted')
})
</script>

<template layout="AppShell,AuthenticatedLayout">
  <v-card class="mx-auto" prepend-icon="mdi-eye" :title="$page.props.title">
    <v-card-text>
      <div class="text-h6 text-medium-emphasis">Show</div>
    </v-card-text>
    <v-card-actions>
      <v-spacer />
      <Link :href="route('so-status-steps.index')" as="div">
        <v-btn variant="text">Cancelar</v-btn>
      </Link>
    </v-card-actions>
  </v-card>
</template>
