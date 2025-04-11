<script setup>
import SupplierInformationsEdit from '@/Pages/Registers/Supplier/SupplierInformationsEdit.vue'
import { formatToCPFOrCNPJ } from 'brazilian-values'
import parallax from '@images/pages/user-profile-header-bg.png'

const props = defineProps({
  supplier: {
    type: Object,
    required: true,
    default: () => {}
  },
  phones: {
    type: Object,
    required: true,
    default: () => {}
  },
  addresses: {
    type: Object,
    required: true,
    default: () => {}
  }
})

// Função para retornar o status
function _getStatus(status) {
  const statusList = {
    A: 'Ativo',
    I: 'Inativo',
    B: 'Bloqueado'
  }
  return statusList[status]
}

// Função para retornar a cor do status
function _getStatusColor(status) {
  const statusList = {
    A: 'primary',
    I: 'warning',
    B: 'error'
  }
  return statusList[status]
}

function deleteSupplier(item) {
  if (can('supplier', 'excluir')) {
    swDeleteQuestion(`o(a) fornecedor<br>${item.name}`, route('registers.supplier.destroy', item.id))
  } else {
    swToast('Você não tem permissão para excluir Fornecedores.', 'error', 3000)
  }
}
</script>

<template layout="AppShell,AuthenticatedLayout">
  <!-- class="match-height" (alinha as colunas na vertical)-->
  <v-row>
    <!-- 👉 Supplier Header  -->
    <VCol cols="12">
      <VCard>
        <VImg :src="parallax" min-height="90" max-height="120" cover />
        <VCardText class="d-flex align-bottom flex-sm-row flex-column justify-center gap-x-6">
          <div class="d-flex h-0">
            <VAvatar
              class="user-profile-avatar mx-auto"
              rounded
              :size="130"
              :color="!props.supplier.avatar ? 'primary' : undefined"
              :variant="!props.supplier.avatar ? 'tonal' : undefined"
            >
              <VImg v-if="props.supplier.avatar" :src="props.supplier.avatar" />
              <span v-else class="text-5xl font-weight-medium">
                {{ avatarText(props.supplier.name) }}
              </span>
            </VAvatar>
          </div>

          <div class="user-profile-info w-100 mt-16 pt-6 pt-sm-0 mt-sm-0">
            <h4 class="text-h4 text-center text-sm-start font-weight-medium mb-2">
              {{ props.supplier.name }}
            </h4>

            <div class="d-flex align-center justify-center justify-sm-space-between flex-wrap gap-5">
              <div class="d-flex flex-wrap justify-center justify-sm-start flex-grow-1 gap-6">
                <!-- Vendas
                <div class="d-flex align-center me-8">
                  <VAvatar :size="40" rounded color="primary" variant="tonal" class="me-4">
                    <VIcon icon="mdi-shopping" size="24" />
                  </VAvatar>
                  <div>
                    <h5 class="text-h5 text-body-1">
                      {{ props.supplier.sales || 0 }}
                    </h5>
                    <span class="text-sm">Vendas</span>
                  </div>
                </div> -->

                <!-- Status -->
                <span class="d-flex align-center me-4">
                  <VAvatar :size="40" rounded color="primary" variant="tonal" class="me-4">
                    <VIcon icon="mdi-account-check" size="24" />
                  </VAvatar>
                  <div>
                    <h5 class="text-h5 text-body-1" :class="'text-' + `${_getStatusColor(props.supplier.status)}`">
                      {{ _getStatus(props.supplier.status) }}
                    </h5>
                    <span class="text-sm">Status</span>
                  </div>
                </span>
              </div>
              <VBtn prepend-icon="mdi-delete" color="warning" variant="flat" @click="deleteSupplier(props.supplier)"> Deletar Fornecedor </VBtn>
            </div>
          </div>
        </VCardText>
      </VCard>
    </VCol>
    <!-- Detalhes -->
    <v-col cols="12" sm="6" md="5" lg="4" xl="3">
      <!-- Informações Pessoais -->
      <v-card class="mx-auto">
        <VCardItem>
          <template #prepend>
            <VIcon icon="mdi-account-details" size="24" class="me-2" />
          </template>

          <VCardTitle>Informações Pessoais</VCardTitle>
        </VCardItem>
        <v-card-text>
          <VList class="card-list">
            <!-- CPF/CNPJ -->
            <VListItem>
              <VListItemTitle>
                <span class="d-flex align-center">
                  <div class="text-body-1 font-weight-medium me-2">CPF/CNPJ:</div>
                  <div class="d-inline-block text-body-1">
                    {{ formatToCPFOrCNPJ(props.supplier.cpf_cnpj) }}
                  </div>
                </span>
              </VListItemTitle>
            </VListItem>
            <!-- Nome Fantasia -->
            <VListItem>
              <VListItemTitle>
                <span class="d-flex align-center">
                  <div class="text-body-1 font-weight-medium me-2">Nome Fantasia:</div>
                  <div class="d-inline-block text-body-1">
                    {{ props.supplier.nick_name }}
                  </div>
                </span>
              </VListItemTitle>
            </VListItem>
            <p class="text-body-1 text-disabled mt-3">DATAS</p>
            <!-- Cadastrado em -->
            <VListItem>
              <VListItemTitle>
                <span class="d-flex align-center">
                  <div class="text-body-1 font-weight-medium me-2">Cadastro em:</div>
                  <div class="d-inline-block text-body-1">
                    {{ props.supplier.created_at }}
                  </div>
                </span>
              </VListItemTitle>
            </VListItem>
            <!-- Atualizado em -->
            <VListItem>
              <VListItemTitle>
                <span class="d-flex align-center">
                  <div class="text-body-1 font-weight-medium me-2">Atualizado em:</div>
                  <div class="d-inline-block text-body-1">
                    {{ props.supplier.updated_at }}
                  </div>
                </span>
              </VListItemTitle>
            </VListItem>
            <!-- Última Venda -->
            <VListItem>
              <VListItemTitle>
                <span class="d-flex align-center">
                  <div class="text-body-1 font-weight-medium me-2">Última Venda:</div>
                  <div class="d-inline-block text-body-1">
                    {{ props.supplier.last_sale }}
                  </div>
                </span>
              </VListItemTitle>
            </VListItem>
          </VList>
        </v-card-text>
        <v-card-text>
          <span class="d-flex align-center">
            <v-btn color="primary" prepend-icon="mdi-pencil" variant="flat">
              Editar Informações
              <supplier-informations-edit :data="supplier" />
            </v-btn>
          </span>
        </v-card-text>
      </v-card>
    </v-col>
    <v-col cols="12" sm="6" md="7" lg="8" xl="9">
      <v-row>
        <!-- Telefones -->
        <app-forms-phones :phones="props.phones" route-store="registers.supplier.phone.store" :data-id="props.supplier.id" />
        <!-- Endereços -->
        <app-form-addresses :addresses="props.addresses" route-store="registers.supplier.address.store" :data-id="props.supplier.id"></app-form-addresses>
        <!-- Mais Detalhes -->
        <v-col cols="12">
          <v-card class="mx-auto">
            <VCardItem>
              <template #prepend>
                <VIcon icon="mdi-account-details" size="24" class="me-2" />
              </template>

              <VCardTitle>Notas</VCardTitle>
            </VCardItem>
            <v-card-text v-if="props.supplier.note">
              <p class="text-body-1">{{ props.supplier.note }}</p>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-col>
  </v-row>
</template>

<style lang="scss" scoped>
.user-profile-avatar {
  border: 5px solid rgb(var(--v-theme-surface));
  background-color: rgb(var(--v-theme-surface)) !important;
  inset-block-start: -3rem;

  .v-img__img {
    border-radius: 0.125rem;
  }
}
.card-list {
  --v-card-list-gap: 0.5rem;
}

.text-capitalize {
  text-transform: capitalize !important;
}
</style>
