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
  routeDefault: {
    type: String,
    required: true
  }
})

const pageTitle = props.title

function routeBase(name) {
  return props.routeDefault + name
}

const deviceIsActive = shallowRef(props.data.is_active)

const form = useForm({
  id: props.data.id,
  description: props.data.description,
  is_active: Boolean(deviceIsActive.value)
})

const submit = () => {
  form.put(route(routeBase('update'), props.data.id), {
    onSuccess() {
      form.reset()
      router.visit(route(routeBase('index')), {
        preserveScroll: true,
        preserveState: false
      })
    }
  })
}

onMounted(() => {
  // console.log(routeBase('index'))
})
</script>

<template>
  <app-modal width="450">
    <v-form @submit.prevent="submit">
      <v-card prepend-icon="mdi-pencil" :title="pageTitle">
        <v-card-text>
          <v-row>
            <v-col cols="8">
              <app-name-field id="description" v-model="form.description" label="Descrição" placeholder="Descrição " autofocus :error-messages="form.errors.description" />
            </v-col>
            <v-col cols="4">
              <v-checkbox id="is_active" v-model="form.is_active" class="mt-6" :label="form.is_active === true ? 'Ativo' : 'Inativo'" :error-messages="form.errors.is_active" />
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
