<script setup>
const props = defineProps({
  title: {
    type: String,
    required: true
  },
  routeDefault: {
    type: String,
    required: true
  },
  count: {
    type: Number,
    default: 0
  }
})

const pageTitle = props.title
const pageIcon = 'iconify:game-icons:auto-repair'

function routeBase(name) {
  return props.routeDefault + name
}

// Definição das colunas
const headers = ref([
  { title: 'OS. Nº', key: 'order_number' },
  { title: 'Cliente', key: 'client_id' },
  { title: 'Aparelho', key: 'so_device_id' },
  { title: 'Valor', key: 'labor_cost' },
  { title: 'Ações', key: 'action', sortable: false, align: 'end' }
])

// Estado da tabela
const responseData = ref([])
const content = computed(() => responseData.value)
const isLoadingTable = ref(true)
const search = ref(null)
const itemsPerPage = ref(10)
const page = ref(1)

// Carregamento dos dados
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
    const response = await fetch(`${route(routeBase('index'))}?${params.toString()}`, {
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
        ...item
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

function deleteItem(item) {
  if (can('serviceOrder', 'excluir')) {
    swDeleteQuestion('a OS nº' + item.order_number, route(routeBase('destroy'), item.id))
  } else {
    swToast(`Você não tem permissão para excluir ${pageTitle}.`, 'error', 3000)
  }
}

function editItem(item) {
  if (can('serviceOrder', 'editar')) {
    router.get(route(routeBase('edit'), item.id))
  } else {
    swToast(`Você não tem permissão para editar ${pageTitle}.`, 'error', 3000)
  }
}

function showItem(item) {
  if (can('serviceOrder', 'ver')) {
    router.get(route(routeBase('show'), item.id))
  } else {
    swToast(`Você não tem permissão para ver ${pageTitle}.`, 'error', 3000)
  }
}

function createItem() {
  if (can('serviceOrder', 'criar')) {
    router.get(route(routeBase('create')))
  } else {
    swToast(`Você não tem permissão para criar ${pageTitle}.`, 'error', 3000)
  }
}

onMounted(() => {
  // console.log(route(routeBase('index')))
  // console.log('ServiceOrder page mounted')
})
</script>

<template layout="AppShell,AuthenticatedLayout">
  <template v-if="props.count > 0">
    <v-card class="mx-auto" width="800" :prepend-icon="pageIcon" :title="pageTitle">
      <template #append>
        <v-btn prepend-icon="mdi-plus" color="primary" variant="text" @click="createItem()">Adicionar {{ pageTitle }}</v-btn>
      </template>
      <v-card-text class="d-flex">
        <v-row>
          <v-col cols="12" lg="8" md="8" sm="6">
            <v-text-field v-model="search" label="Procurar" prepend-inner-icon="mdi-magnify" hide-details clearable />
          </v-col>
          <v-col v-if="content.total > 10" cols="12" lg="4" md="4" sm="6">
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
          <!--<template #item.gender="{ item }">
            {{ item.gender == 'male' ? 'Masculino' : 'Feminino' }}
          </template>-->
          <template #item.action="{ item }">
            <v-icon v-if="can('serviceOrder', 'ver')" class="mr-1" color="primary" icon="mdi-eye" size="small" @click="showItem(item)" />
            <v-icon v-if="can('serviceOrder', 'editar')" class="ml-1" color="warning" icon="mdi-pencil" size="small" @click="editItem(item)" />
            <v-icon v-if="can('serviceOrder', 'excluir')" class="ml-1" color="error" icon="mdi-delete" size="small" @click="deleteItem(item)" />
          </template>
          <template #bottom>
            <v-divider />
          </template>
        </v-data-table-server>
      </v-card-item>
      <v-card-actions>
        <template v-if="content.total > 10 && itemsPerPage < content.total">
          <v-list-item :title="`Página ${content.current_page} de ${content.last_page}`" :subtitle="`Total de ${formatCount(content.total)} ${pageTitle}`" />
          <v-spacer />
          <v-pagination v-model="page" :length="content.last_page" :total-visible="4" size="small" rounded></v-pagination>
        </template>
      </v-card-actions>
    </v-card>
  </template>
  <template v-else>
    <v-row align="center" justify="center" style="height: 70vh">
      <v-empty-state :headline="pageTitle" title="Nenhum registro encontrado.">
        <template #media>
          <v-icon :icon="pageIcon" />
        </template>
        <!-- Todo: alterar (Adicionar) abaixo -->
        <v-btn prepend-icon="mdi-plus" color="primary" variant="flat" @click="createItem()">Adicionar {{ pageTitle }}</v-btn>
      </v-empty-state>
    </v-row>
  </template>
</template>
