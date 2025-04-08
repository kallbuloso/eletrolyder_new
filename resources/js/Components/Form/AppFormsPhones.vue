<script setup>
import { formatToPhone } from 'brazilian-values'
const props = defineProps({
  dataId: {
    type: [Number, String],
    default: null,
    required: false
  },
  phones: {
    type: [Object, Array],
    required: false
  },
  routeStore: {
    type: String,
    required: false
  }
})

function deleteItem(item) {
  if (can('phone', 'excluir')) {
    swDeleteQuestion('o telefone<br>' + formatToPhone(item.phone_number), route('settings.phone.destroy', item.id))
  } else {
    swToast('Você não tem permissão para excluir Telefones.', 'error', 3000)
  }
}
</script>

<template>
  <v-col cols="12">
    <v-card class="">
      <VCardItem>
        <template #prepend>
          <VIcon icon="mdi-phone" size="24" class="me-2" />
        </template>
        <template #append>
          <v-btn v-tooltip="'Adicionar Telefone'" prepend-icon="mdi-plus" color="primary" variant="flat" :disabled="!can('phone', 'criar')">
            Adicionar telefone
            <app-phone-add :model-id="props.dataId" :route-store="props.routeStore" />
          </v-btn>
        </template>
        <VCardTitle>Telefone(s)</VCardTitle>
      </VCardItem>
      <v-card-text v-if="props.phones[0]">
        <v-table density="compact">
          <thead>
            <tr>
              <th class="text-left">Número</th>
              <th>Contato</th>
              <th class="text-right">Ações</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, id) in props.phones" :key="id">
              <td>{{ formatToPhone(item.phone_number) }}</td>
              <td>{{ item.phone_contact }}</td>
              <td class="text-right">
                <icon-btn density="compact" variant="plain" :disabled="!can('phone', 'editar')">
                  <v-icon v-tooltip="'Editar'" color="warning" icon="mdi-pencil" size="small" />
                  <app-phone-edit :data="item" />
                </icon-btn>
                <v-icon v-tooltip="'Excluir'" class="me-1" color="error" icon="mdi-delete" size="small" link @click="deleteItem(item)" />
                <v-icon
                  v-tooltip="'Ir para o Whatsapp'"
                  class="me-1"
                  :color="!item.phone_has_whatsapp ? 'secondary' : 'success'"
                  icon="mdi-whatsapp"
                  size="small"
                  link
                  :disabled="!item.phone_has_whatsapp"
                />
              </td>
            </tr>
          </tbody>
        </v-table>
      </v-card-text>
      <v-card-item v-else class="justify-center">
        <span>
          <p>
            Sem número de telefone.<br />
            Adicione <b>um ou mais números</b> para aumentar as formas de contato.
          </p>
        </span>
      </v-card-item>
    </v-card>
  </v-col>
</template>
