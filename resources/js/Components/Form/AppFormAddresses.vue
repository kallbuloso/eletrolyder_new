<template>
  <v-col cols="12">
    <v-card class="">
      <VCardItem>
        <template #prepend>
          <VIcon icon="mdi-map-marker-account" size="24" class="me-2" />
        </template>

        <VCardTitle>Endereço</VCardTitle>

        <template #append>
          <v-btn v-if="props.addresses[0]" v-tooltip="'Editar Endereço'" prepend-icon="mdi-pencil" variant="flat">
            Editar endereço
            <app-address-update :data="props.addresses[0]" />
          </v-btn>
        </template>
      </VCardItem>
      <v-card-text>
        <v-table>
          <tbody v-if="props.addresses[0]">
            <tr v-for="(item, id) in props.addresses" :key="id">
              <td>{{ item.street }}, {{ item.number }} - {{ item.neighborhood }} - {{ item.city }}/{{ item.state }} - {{ formatToCEP(item.zip_code) }}</td>
              <td class="text-right">
                <v-icon v-tooltip="'Excluir'" class="mt-1" color="error" icon="mdi-delete" size="small" link @click="deleteItem(item)" />
              </td>
            </tr>
          </tbody>
          <tbody v-else>
            <tr>
              <td class="text-center" colspan="2">
                <span>
                  <p>
                    Sem endereço cadastrado.<br />
                    Clique no <b>botão abaixo</b> para adicionar.
                  </p>
                </span>
                <v-btn prepend-icon="mdi-map-marker"
                  >Adicionar Endereço
                  <v-form-address-create :model-id="dataId" :route-store="props.routeStore" />
                </v-btn>
              </td>
            </tr>
          </tbody>
        </v-table>
      </v-card-text>
    </v-card>
  </v-col>
</template>

<script setup>
import { formatToCEP } from 'brazilian-values'
const props = defineProps({
  dataId: {
    type: Number,
    default: null,
    required: false
  },
  addresses: {
    type: Array,
    default: () => []
  },
  routeStore: {
    type: String,
    required: false
  }
})

function deleteItem(item) {
  if (can('address', 'excluir')) {
    swDeleteQuestion('<br>este endereço', route('settings.address.destroy', item.id))
  } else {
    swToast('Você não tem permissão para excluir Endereços.', 'error', 3000)
  }
}
</script>
