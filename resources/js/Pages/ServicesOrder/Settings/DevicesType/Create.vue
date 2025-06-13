<script setup>
const props = defineProps({
  title: {
    type: String,
    required: true
  },
  routeDefault: {
    type: String,
    required: true
  }
})

const pageTitle = props.title

function routeBase(name) {
  return props.routeDefault + name
}

const form = useForm({
  description: '',
  is_active: true
})

const submit = () => {
  form.post(route(routeBase('store')), {
    onSuccess() {
      form.reset()
    }
  })
}
</script>

<template>
  <app-modal width="450">
    <v-form @submit.prevent="submit">
      <v-card prepend-icon="mdi-plus" :title="pageTitle">
        <v-card-text class="mx-1">
          <App-name-field v-model="form.description" label="Description" placeholder="Description" autofocus :error-messages="form.errors.description" />
        </v-card-text>
        <v-card-actions>
          <v-spacer />
          <v-btn type="submit" color="primary" :loading="form.processing">Salvar</v-btn>
        </v-card-actions>
      </v-card>
    </v-form>
  </app-modal>
</template>
