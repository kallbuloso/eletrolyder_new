<script setup>
const props = defineProps({
  data: {
    type: Object,
    required: false
  },
  statusSteps: {
    type: Object,
    default: () => ({})
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

const value = shallowRef(props.data.status_type || '0')

const form = useForm({
  id: props.data.id,
  tenant_id: usePage().props.auth.user.tenant_id,
  description: props.data.description,
  status_type: value.value.toString(),
  generates_revenue: props.data.generates_revenue
})

const headers = ref([
  { title: 'ID', align: 'start', key: 'id', sortable: true },
  { title: 'Andamentos do Status', align: 'start', key: 'description', sortable: false },
  { title: 'Ações', align: 'end', key: 'action', sortable: false }
])

const submit = () => {
  form.put(route('orders.soStatus.update', props.data.id), {
    onSuccess() {
      form.reset()
      router.visit(route('orders.soStatus.index'), {
        preserveScroll: true,
        preserveState: false
      })
    }
  })
}

const statusTypes = [
  { title: 'Entada', value: '0' },
  { title: 'Em Andamento', value: '1' },
  { title: 'Saída', value: '2' }
]

function editItem(item) {
  if (can('soStatusStep', 'editar')) {
    router.get(route('orders.statusStep.edit', item.id))
  } else {
    swToast('Você não tem permissão para editar Passos de OS.', 'error', 3000)
  }
}

function deleteItem(item) {
  if (can('soStatusStep', 'excluir')) {
    swDeleteQuestion(item.description, route('orders.statusStep.destroy', item.id))
  } else {
    swToast('Você não tem permissão para excluir Passos de OS.', 'error', 3000)
  }
}
</script>

<template>
  <app-modal width="550">
    <v-form @submit.prevent="submit">
      <v-card :prepend-icon="'mdi-plus'" :title="props.title">
        <v-card-text class="mx-1">
          <v-row>
            <v-col cols="12">
              <app-text-field id="description" v-model="form.description" label="Descrição" placeholder="Descrição do status" required :error-messages="form.errors.description" />
            </v-col>
            <v-col cols="7">
              <app-select
                id="status_type"
                v-model="form.status_type"
                :items="statusTypes"
                item-title="title"
                item-value="value"
                label="Tipo de Status"
                placeholder="Selecione o tipo de status"
                required
                :error-messages="form.errors.status_type"
              />
            </v-col>
            <v-col cols="5">
              <v-checkbox id="generates_revenue" v-model="form.generates_revenue" class="mt-6" label="Gera Receita?" :error-messages="form.errors.generates_revenue" />
            </v-col>
          </v-row>
        </v-card-text>
        <v-card-text>
          <v-data-table :headers="headers" :items="props.statusSteps" item-value="description" :show-select="false">
            <template #item.action="{ item }">
              <v-icon class="ml-2" color="warning" icon="mdi-pencil" size="small" @click="editItem(item)" />
              <v-icon class="ml-2" color="error" icon="mdi-delete" size="small" @click="deleteItem(item)" />
            </template>
            <template #bottom>
              <v-spacer />
              <v-btn type="submit" color="primary" variant="text" :loading="form.processing">Adicionar andamento</v-btn>
            </template>
          </v-data-table>
          <!-- <pre>{{ props.statusSteps }}</pre> -->
        </v-card-text>
        <v-card-actions class="mx-4">
          <v-spacer />
          <!-- <Link :href="route('orders.soStatus.index')" as="div">
            <v-btn class="mr-2" variant="text">Cancelar</v-btn>
          </Link> -->
          <v-btn type="submit" color="primary" variant="text" :loading="form.processing">Salvar</v-btn>
        </v-card-actions>
      </v-card>
    </v-form>
  </app-modal>
</template>
