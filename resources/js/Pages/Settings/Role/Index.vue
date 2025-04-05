<script setup>
import { can } from '@/utils/helpers'
// import Create from '@/Pages/Settings/Role/Create.vue'
const props = defineProps({
  data: {
    type: Object
  }
})
const isLoadingTable = ref(false)
const search = ref(null)
const itemsPerPage = ref(10)
const page = ref(1)
const headers = ref([
  { title: 'Tipo de acesso', key: 'name' },
  { title: 'Descrição', key: 'description' },
  { title: 'Action', key: 'action', sortable: false, align: 'end' }
])

function deleteItem(item) {
  swDeleteQuestion(item.name, route('settings.roles.destroy', item.id))
}

function editItem(item) {
  router.get(route('settings.roles.edit', item.id))
}

function createItem() {
  router.get(route('settings.roles.create'))
}
</script>

<template layout="AppShell,AuthenticatedLayout">
  <v-card class="mx-auto" width="700" prepend-icon="mdi-account-key" :title="$page.props.title">
    <template #append>
      <!-- <Create /> -->
      <v-btn v-if="$page.props.auth.user.role.includes('Administrador') || can('role', 'criar')" prepend-icon="mdi-plus" color="primary" variant="text" @click="createItem()"
        >Novo acesso</v-btn
      >
    </template>
    <v-card-text>
      <v-row class="d-flex">
        <v-col cols="12" md="8">
          <app-text-field v-model="search" label="Procurar" prepend-inner-icon="mdi-magnify" hide-details clearable />
        </v-col>
        <v-col v-if="props.data.total > 5" cols="12" md="4">
          <app-select v-model="itemsPerPage" :items="[10, 15, 25, 35, 50, 100]" label="Itens por Página" width="150px"></app-select>
        </v-col>
      </v-row>
      <v-data-table
        :page="page"
        :items="props.data"
        :headers="headers"
        :search="search"
        :show-select="false"
        :items-per-page="itemsPerPage"
        loading-text="Carregando, por favor aguarde..."
        density="compact"
        :loading="isLoadingTable"
      >
        <template #loading>
          <v-skeleton-loader type="table-row@10" />
        </template>
        <template #item.action="{ item }">
          <v-icon v-if="item.name !== 'Super-admin' && can('role', 'edit')" class="ml-2" color="warning" icon="mdi-pencil" size="small" @click="editItem(item)" />
          <v-icon v-if="item.name !== 'Super-admin' && can('role', 'delete')" class="ml-2" color="error" icon="mdi-delete" size="small" @click="deleteItem(item)" />
        </template>
        <template #bottom>
          <v-divider />
        </template>
      </v-data-table>
    </v-card-text>
  </v-card>
</template>
