<script setup>
import { formatToCPFOrCNPJ } from 'brazilian-values'

const props = defineProps({
  clientsCount: {
    type: Number,
    required: true
  }
})

// Estado da tabela
const responseData = ref({ data: [], total: 0, current_page: 1, last_page: 1 })
const content = computed(() => responseData.value)
const isLoadingTable = ref(true)
const search = ref(null)
const itemsPerPage = ref(10)
const page = ref(1)

// Definição das colunas
const headers = ref([
  { title: 'Nome', key: 'name', sortable: true },
  { title: 'Apelido', key: 'nick_name', sortable: true },
  { title: 'Pessoa', key: 'person', sortable: true },
  { title: 'CPF/CNPJ', key: 'cpf_cnpj', sortable: true },
  { title: 'Status', key: 'status', sortable: true },
  { title: 'Action', key: 'action', sortable: false, align: 'end' }
])

// Funções auxiliares
const genderList = {
  M: 'Masculino',
  F: 'Feminino',
  L: 'LGBTQIA+',
  NB: 'Ñ Binário',
  O: 'Outros'
}

const personList = {
  F: 'Física',
  J: 'Jurídica'
}

const statusList = {
  0: { text: 'Ativo', color: 'primary' },
  1: { text: 'Inativo', color: 'warning' },
  2: { text: 'Bloqueado', color: 'error' }
}

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
    const response = await fetch(`/registers/clients?${params.toString()}`, {
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
        person: personList[item.person] || 'Não definido',
        gender: genderList[item.gender] || 'Não definido',
        status: statusList[item.status]?.text || 'Não definido',
        statusColor: statusList[item.status]?.color || 'grey'
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
  if (can('client', 'criar')) {
    router.get(route('registers.client.create'))
  } else {
    swToast('Você não tem permissão para criar clientes.', 'error', 3000)
  }
}

function editItem(id) {
  if (can('client', 'editar')) {
    router.get(route('registers.client.edit', id))
  } else {
    swToast('Você não tem permissão para editar clientes.', 'error', 3000)
  }
}

function deleteItem(item) {
  if (can('client', 'excluir')) {
    swDeleteQuestion(item.name, route('registers.client.destroy', item.id))
  } else {
    swToast('Você não tem permissão para excluir clientes.', 'error', 3000)
  }
}
</script>

<template layout="AppShell,AuthenticatedLayout">
  <!-- Lista de clientes -->
  <template v-if="props.clientsCount > 0">
    <v-card class="mx-auto" prepend-icon="mdi-account-group" :title="$page.props.title">
      <!-- Botão Novo -->
      <template #append>
        <v-btn prepend-icon="mdi-plus" color="primary" variant="text" @click="createItem">Novo</v-btn>
      </template>

      <!-- Filtros -->
      <v-card-text>
        <v-row>
          <v-col cols="12" md="9" sm="9">
            <v-text-field
              v-model="search"
              hint="Procurar cliente por nome, apelido ou CPF/CNPJ"
              label="Procurar cliente"
              prepend-inner-icon="mdi-magnify"
              clearable
              density="comfortable"
              persistent-hint
            />
          </v-col>
          <v-col v-if="content.total > 10" cols="12" md="3" sm="3">
            <v-select v-model="itemsPerPage" :items="[10, 15, 25, 35, 50, 100]" label="Itens por Página" hide-details density="comfortable" />
          </v-col>
        </v-row>
      </v-card-text>

      <!-- Tabela -->
      <v-card-item>
        <v-data-table-server
          :headers="headers"
          :items="content.data"
          :items-length="Number(content.total)"
          :items-per-page="itemsPerPage"
          :page="page"
          :search="search"
          :loading="isLoadingTable"
          :show-select="false"
          loading-text="Carregando, por favor aguarde..."
          @update:options="loadItems"
        >
          <!-- Loading -->
          <template #loading>
            <v-skeleton-loader type="table-row@5" />
          </template>

          <!-- Status -->
          <template #item.status="{ item }">
            <v-chip :color="item.statusColor" size="small">
              {{ item.status }}
            </v-chip>
          </template>

          <!-- Documento -->
          <template #item.cpf_cnpj="{ item }">
            {{ item.cpf_cnpj ? formatToCPFOrCNPJ(item.cpf_cnpj) : 'Não informado' }}
          </template>

          <!-- Ações -->
          <template #item.action="{ item }">
            <v-icon v-if="can('client', 'editar')" color="warning" icon="mdi-pencil" size="small" class="mr-1" @click="editItem(item.id)" />
            <v-icon v-if="can('client', 'excluir')" color="error" icon="mdi-delete" size="small" @click="deleteItem(item)" />
          </template>

          <template #bottom>
            <v-divider />
          </template>
        </v-data-table-server>
      </v-card-item>

      <!-- Paginação -->
      <v-card-actions v-if="content.total > 10">
        <v-list-item :title="`Página ${content.current_page} de ${content.last_page}`" :subtitle="`Total de ${formatCount(content.total)} ${$page.props.title}`" />
        <v-spacer />
        <v-pagination v-model="page" :length="content.last_page" :total-visible="5" size="small" rounded />
      </v-card-actions>
    </v-card>
  </template>

  <!-- Estado vazio -->
  <template v-else>
    <v-row align="center" justify="center" style="height: 70vh">
      <v-empty-state :headline="$page.props.title" title="Nenhum registro encontrado.">
        <template #media>
          <v-icon icon="iconify:fa6-solid:people-line" />
        </template>
        <v-btn prepend-icon="mdi-plus" color="primary" variant="flat" @click="createItem"> Adicionar Um Cliente </v-btn>
      </v-empty-state>
    </v-row>
  </template>
</template>
