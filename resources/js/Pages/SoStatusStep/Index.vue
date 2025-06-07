<script setup>
import { router } from '@inertiajs/vue3'

const props = defineProps({
  data: {
    type: Object
  },
  statusId: {
    type: [Number, String],
    default: null
  },
  status: {
    type: Object,
    default: null
  }
})

const isLoadingTable = ref(false)
const search = ref(null)
const itemsPerPage = ref(10)
const page = ref(1)
const pageCount = computed(() => {
  return props.data.last_page
})
const headers = ref([
  { title: 'ID', key: 'id' },
  { title: 'Tenant Id', key: 'tenant_id' },
  { title: 'So Status Id', key: 'so_status_id' },
  { title: 'Description', key: 'description' },
  { title: 'Action', key: 'action', sortable: false, align: 'end' }
])

function loadItems({ page, itemsPerPage, sortBy, search }) {
  isLoadingTable.value = true
  const upPage = page
  const params = {
    page: upPage,
    limit: itemsPerPage,
    sort: sortBy[0]
  }
  if (search) {
    params.search = search
  }
  if (props.statusId) {
    params.so_status_id = props.statusId
  }
  router.get('/so-status-steps', params, {
    preserveState: true,
    preserveScroll: true,
    onSuccess: () => {
      isLoadingTable.value = false
    }
  })
}

function deleteItem(item) {
  if (can('soStatusStep', 'delete')) {
    swDeleteQuestion(item.name, route('so-status-steps.destroy', item.id))
  } else {
    swToast('Você não tem permissão para excluir SoStatusStep.', 'error', 3000)
  }
}

function editItem(item) {
  if (can('soStatusStep', 'edit')) {
    router.get(route('so-status-steps.edit', item.id))
  } else {
    swToast('Você não tem permissão para editar SoStatusStep.', 'error', 3000)
  }
}

// function showItem(item) {
//   if (can('soStatusStep', 'show')) {
//     router.get(route('so-status-steps.show', item.id))
//   } else {
//     swToast('Você não tem permissão para visualizar SoStatusStep.', 'error', 3000)
//   }
// }

function createItem() {
  if (can('soStatusStep', 'create')) {
    router.get(route('so-status-steps.create'))
  } else {
    swToast('Você não tem permissão para criar SoStatusStep.', 'error', 3000)
  }
}

onMounted(() => {
  // console.log('SoStatusStep page mounted')
})
</script>

<template layout="AppShell,AuthenticatedLayout">
  <v-card class="mx-auto" width="800" prepend-icon="mdi-account-lock" :title="props.status ? `Etapas de ${props.status.description}` : $page.props.title">
    <template #append>
      <v-btn prepend-icon="mdi-plus" color="primary" variant="text" @click="createItem()">Novo</v-btn>
    </template>
    <v-card-text class="d-flex">
      <v-row>
        <v-col cols="12" md="9">
          <v-text-field v-model="search" label="Procurar" prepend-inner-icon="mdi-magnify" hide-details clearable />
        </v-col>
        <v-col v-if="props.data.total > 10" cols="12" md="3">
          <v-select v-model="itemsPerPage" :items="[10, 15, 25, 35, 50, 100]" label="Itens por Página" width="150px"></v-select>
        </v-col>
      </v-row>
    </v-card-text>
    <!--
      <pre>{{ props.data }}</pre>
      -->
    <v-card-item>
      <v-data-table-server
        :page="page"
        :items="props.data.data"
        :items-length="props.data.total"
        :headers="headers"
        :search="search"
        :show-select="false"
        :items-per-page="itemsPerPage"
        loading-text="Carregando, por favor aguarde..."
        :loading="isLoadingTable"
        @update:options="loadItems"
      >
        <!--<template #item.gender="{ item }">
          {{ item.gender == 'male' ? 'Masculino' : 'Feminino' }}
        </template>-->
        <template #item.action="{ item }">
          <!--
              <v-icon class="ml-2" color="primary" icon="mdi-eye" size="small" @click="showItem(item)" />
            -->
          <v-icon class="ml-2" color="warning" icon="mdi-pencil" size="small" @click="editItem(item)" />
          <v-icon class="ml-2" color="error" icon="mdi-delete" size="small" @click="deleteItem(item)" />
        </template>
        <template #bottom>
          <v-divider />
        </template>
      </v-data-table-server>
    </v-card-item>
    <v-card-actions>
      <template v-if="props.data.total > 10">
        <v-list-item :title="`Página ${page} de ${pageCount}`" :subtitle="`Total de ${props.data.total} itens`" />
        <v-spacer />
        <v-pagination v-model="page" :length="pageCount" :total-visible="2" size="small" rounded></v-pagination>
      </template>
    </v-card-actions>
  </v-card>
</template>
