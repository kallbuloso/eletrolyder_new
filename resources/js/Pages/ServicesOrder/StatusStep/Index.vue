<script setup>
const props = defineProps({
  soStatusStepCount: {
    type: Number,
    required: true
  },
  status: {
    type: Object,
    default: null
  }
})

const responseData = ref([])
const content = computed(() => responseData.value)
const isLoadingTable = ref(false)
const search = ref(null)
const itemsPerPage = ref(10)
const page = ref(1)

const headers = ref([
  { title: 'Status', key: 'so_status_id' },
  { title: 'Description', key: 'description' },
  { title: 'Action', key: 'action', sortable: false, align: 'end' }
])

async function loadItems(options = {}) {
  isLoadingTable.value = true
  const { page, itemsPerPage, sortBy = [], search = null } = options

  const params = new URLSearchParams()
  params.append('page', page || 1)
  params.append('limit', itemsPerPage || 10)

  if (sortBy?.length > 0) {
    params.append('sort[key]', sortBy[0].key)
    params.append('sort[order]', sortBy[0].order === 'desc' ? 'desc' : 'asc')
  }

  if (search) {
    params.append('search', search)
  }

  try {
    const response = await fetch(`/orders/status-steps?${params.toString()}`, {
      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
      }
    })

    if (!response.ok) {
      throw new Error(`HTTP error! Status: ${response.status}`)
    }

    const data = await response.json()
    if (data.data) {
      data.data = data.data.map((item) => ({
        ...item,
        role: item.roles?.[0]?.name ?? 'Sem acesso'
      }))
    }
    responseData.value = data
  } catch (error) {
    console.error('Error:', error)
    swToast(`Erro ao carregar dados: ${error.message}`, 'error', 6000)
  } finally {
    isLoadingTable.value = false
  }
}

// Ações da tabela
function createItem() {
  if (can('soStatus', 'criar')) {
    router.get(route('orders.statusStep.create'))
  } else {
    swToast('Você não tem permissão para criar status.', 'error', 3000)
  }
}

function deleteItem(item) {
  if (can('soStatusStep', 'excluir')) {
    swDeleteQuestion(item.name, route('orders.statusStep.destroy', item.id))
  } else {
    swToast('Você não tem permissão para excluir Passos de OS.', 'error', 3000)
  }
}

function editItem(item) {
  if (can('soStatusStep', 'editar')) {
    router.get(route('orders.statusStep.edit', item.id))
  } else {
    swToast('Você não tem permissão para editar Passos de OS.', 'error', 3000)
  }
}
</script>

<template layout="AppShell,AuthenticatedLayout">
  <template v-if="props.soStatusStepCount > 0">
    <v-card class="mx-auto" width="800" prepend-icon="mdi-account-lock" :title="props.status ? `Etapas de ${props.status.description}` : $page.props.title">
      <template #append>
        <v-btn prepend-icon="mdi-plus" color="primary" variant="text" @click="createItem()">Novo</v-btn>
      </template>
      <v-card-text class="d-flex">
        <v-row>
          <v-col cols="12" md="9">
            <v-text-field v-model="search" label="Procurar" prepend-inner-icon="mdi-magnify" hide-details clearable />
          </v-col>
          <v-col v-if="content.total > 10" cols="12" md="3">
            <v-select v-model="itemsPerPage" :items="[10, 15, 25, 35, 50, 100]" label="Itens por Página" width="150px"></v-select>
          </v-col>
        </v-row>
      </v-card-text>
      <v-card-item>
        <v-data-table-server
          :page="page"
          :items="content.data"
          :items-length="Number(content.total)"
          :headers="headers"
          :search="search"
          :show-select="false"
          :items-per-page="itemsPerPage"
          loading-text="Carregando, por favor aguarde..."
          :loading="isLoadingTable"
          @update:options="loadItems"
        >
          <template #loading>
            <v-skeleton-loader type="table-row@5" />
          </template>
          <template #item.action="{ item }">
            <v-icon class="ml-2" color="warning" icon="mdi-pencil" size="small" @click="editItem(item)" />
            <v-icon class="ml-2" color="error" icon="mdi-delete" size="small" @click="deleteItem(item)" />
          </template>
          <template #bottom>
            <v-divider />
          </template>
        </v-data-table-server>
      </v-card-item>
      <v-card-actions>
        <template v-if="content.total > 10 && itemsPerPage < content.total">
          <v-list-item :title="`Página ${content.current_page} de ${content.last_page}`" :subtitle="`Total de ${formatCount(content.total)} ${$page.props.title}`" />
          <v-spacer />
          <v-pagination v-model="page" :length="content.last_page" :total-visible="2" size="small" rounded></v-pagination>
        </template>
      </v-card-actions>
    </v-card>
  </template>
  <template v-else>
    <v-row align="center" justify="center" style="height: 70vh">
      <v-empty-state :headline="$page.props.title" title="Nenhum registro encontrado.">
        <template #media>
          <v-icon icon="iconify:fa6-solid:people-line" />
        </template>
        <v-btn prepend-icon="mdi-plus" color="primary" variant="flat" @click="createItem()">Adicionar Status</v-btn>
      </v-empty-state>
    </v-row>
  </template>
</template>
