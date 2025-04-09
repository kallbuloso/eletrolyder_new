<script setup>
import ClientInformationsEdit from '@/Pages/Registers/Client/ClientInformationsEdit.vue'
import { formatToCPFOrCNPJ } from 'brazilian-values'
import parallax from '@images/pages/user-profile-header-bg.png'
const props = defineProps({
  client: {
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

// function historyGoback() {
//   // if (window.history.length > 1) window.history.back()
//   // else window.location.href = route('registers.client.index')

//   window.history.go(-1)
// }

// Função para retornar o gênero
function _getGender(gender) {
  const genderList = {
    M: 'Masculino',
    F: 'Feminino',
    L: 'LGBTQIA+',
    NB: 'Ñ Binário',
    O: 'Outros'
  }
  return genderList[gender]
}

// Função para retornar o gênero
function _setIconGender(gender) {
  const genderList = {
    M: 'mdi-gender-male',
    F: 'mdi-gender-female',
    L: 'mdi-gender-male-female',
    NB: 'mdi-gender-non-binary',
    O: 'mdi-gender-transgender'
  }
  return genderList[gender]
}

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

function deleteClient(item) {
  if (can('client', 'excluir')) {
    swDeleteQuestion(`o(a) cliente<br>${item.name}`, route('registers.client.destroy', item.id))
  } else {
    swToast('Você não tem permissão para excluir Clientes.', 'error', 3000)
  }
}
</script>

<template layout="AppShell,AuthenticatedLayout">
  <!-- class="match-height" (alinha as colunas na vertical)-->
  <v-row>
    <!-- 👉 Client Header  -->
    <VCol cols="12">
      <VCard>
        <VImg :src="parallax" min-height="90" max-height="120" cover />
        <VCardText class="d-flex align-bottom flex-sm-row flex-column justify-center gap-x-6">
          <div class="d-flex h-0">
            <!-- <VAvatar rounded size="130" :image="props.client.avatar" class="user-profile-avatar mx-auto" /> -->
            <!-- Avatar -->
            <VAvatar
              class="user-profile-avatar mx-auto"
              rounded
              :size="130"
              :color="!props.client.avatar ? 'primary' : undefined"
              :variant="!props.client.avatar ? 'tonal' : undefined"
            >
              <VImg v-if="props.client.avatar" :src="props.client.avatar" />
              <span v-else class="text-5xl font-weight-medium">
                {{ avatarText(props.client.name) }}
              </span>
            </VAvatar>
          </div>

          <div class="user-profile-info w-100 mt-16 pt-6 pt-sm-0 mt-sm-0">
            <h4 class="text-h4 text-center text-sm-start font-weight-medium mb-2">
              {{ props.client.name }}
            </h4>

            <div class="d-flex align-center justify-center justify-sm-space-between flex-wrap gap-5">
              <div class="d-flex flex-wrap justify-center justify-sm-start flex-grow-1 gap-6">
                <!-- Compras -->
                <div class="d-flex align-center me-8">
                  <VAvatar :size="40" rounded color="primary" variant="tonal" class="me-4">
                    <VIcon icon="mdi-shopping" size="24" />
                  </VAvatar>
                  <div>
                    <h5 class="text-h5 text-body-1">
                      {{ props.client.shopping || 0 }}
                      <!-- {{ props.client.taskDone ? `${(props.client.taskDone / 1000).toFixed(2)}k` : 0 }} -->
                    </h5>

                    <span class="text-sm">Compras</span>
                  </div>
                </div>

                <!-- Consertos -->
                <div class="d-flex align-center me-4">
                  <VAvatar :size="40" rounded color="primary" variant="tonal" class="me-4">
                    <VIcon icon="mdi-wrench" size="24" />
                  </VAvatar>
                  <div>
                    <h5 class="text-h5 text-body-1">
                      {{ props.client.repair || 0 }}
                      <!-- {{ props.client.projectDone ? `${(props.client.projectDone / 1000).toFixed(2)}k` : 0 }} -->
                    </h5>
                    <span class="text-sm">Consertos</span>
                  </div>
                </div>

                <!-- Status -->
                <span class="d-flex align-center me-4">
                  <VAvatar :size="40" rounded color="primary" variant="tonal" class="me-4">
                    <VIcon icon="mdi-account-check" size="24" />
                  </VAvatar>
                  <div>
                    <h5 class="text-h5 text-body-1" :class="'text-' + `${_getStatusColor(props.client.status)}`">
                      {{ _getStatus(props.client.status) }}
                    </h5>
                    <span class="text-sm">Status</span>
                  </div>
                </span>
              </div>
              <VBtn prepend-icon="mdi-delete" color="warning" variant="flat" @click="deleteClient(props.client)"> Deletar Cliente </VBtn>
              <!--
                <VBtn prepend-icon="mdi-chevron-left" @click="historyGoback()"> Retornar </VBtn>
              -->
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
          <!-- 👉 Lista de detalhes do usuário -->
          <VList class="card-list text-medium-emphasis">
            <!-- Tipo Pessoa -->
            <VListItem>
              <VListItemTitle>
                <span class="d-flex align-center">
                  <VIcon :icon="props.client.person === 'F' ? 'mdi-account' : 'mdi-office-building'" size="24" class="me-2" />
                  <div class="text-body-1 font-weight-medium me-2">Pessoa:</div>
                  <div class="d-inline-block text-body-1">
                    {{ props.client.person === 'F' ? 'Física' : 'Jurídica' }}
                  </div>
                </span>
              </VListItemTitle>
            </VListItem>
            <!-- CPF / CNPJ -->
            <VListItem>
              <VListItemTitle>
                <span class="d-flex align-center">
                  <VIcon icon="mdi-card-account-details" size="24" class="me-2" />
                  <div class="text-body-1 font-weight-medium me-2">{{ props.client.person === 'F' ? 'CPF:' : 'CNPJ:' }}</div>
                  <div class="d-inline-block text-body-1">
                    {{ props.client.cpf_cnpj ? formatToCPFOrCNPJ(props.client.cpf_cnpj) : 'Não informado' }}
                  </div>
                </span>
              </VListItemTitle>
            </VListItem>
            <!-- Apelido -->
            <VListItem>
              <VListItemTitle>
                <span class="d-flex align-center">
                  <VIcon :icon="props.client.person === 'F' ? 'mdi-account-star' : 'mdi-office-building'" size="24" class="me-2" />
                  <div class="text-body-1 font-weight-medium me-2">{{ props.client.person === 'F' ? 'Apelido:' : 'Nome Fantasia:' }}</div>
                  <div class="d-inline-block text-body-1">
                    {{ props.client.nick_name }}
                  </div>
                </span>
              </VListItemTitle>
            </VListItem>
            <!-- Contato -->
            <VListItem>
              <VListItemTitle>
                <span class="d-flex align-center">
                  <VIcon icon="mdi-contacts" size="24" class="me-2" />
                  <div class="text-body-1 font-weight-medium me-2">{{ props.client.person === 'F' ? 'Contato:' : 'Responsável:' }}</div>
                  <div class="d-inline-block text-body-1">
                    {{ props.client.contact }}
                  </div>
                </span>
              </VListItemTitle>
            </VListItem>
            <!-- Gênero -->
            <VListItem v-if="props.client.person === 'F'">
              <VListItemTitle>
                <span class="d-flex align-center">
                  <VIcon :icon="_setIconGender(props.client.gender)" size="24" class="me-2" />
                  <div class="text-body-1 font-weight-medium me-2">Gênero:</div>
                  <div class="d-inline-block text-body-1">
                    {{ _getGender(props.client.gender) }}
                  </div>
                </span>
              </VListItemTitle>
            </VListItem>
            <!-- Data de Nascimento -->
            <VListItem>
              <VListItemTitle>
                <span class="d-flex align-center">
                  <v-icon icon="mdi-calendar-account" size="24" class="me-2" />
                  <div class="text-body-1 font-weight-medium me-2">{{ props.client.person === 'F' ? 'Aniverssário:' : 'Data de Fundação:' }}</div>
                  <div class="d-inline-block text-body-1">
                    {{ props.client.birth_date }}
                  </div>
                </span>
              </VListItemTitle>
            </VListItem>
            <!-- Datas -->
            <p class="text-body-1 text-disabled mt-3">DATAS</p>
            <!-- Cadastrado em -->
            <VListItem>
              <VListItemTitle>
                <span class="d-flex align-center">
                  <div class="text-body-1 font-weight-medium me-2">Cadastro em:</div>
                  <div class="d-inline-block text-body-1">
                    {{ props.client.created_at }}
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
                    {{ props.client.updated_at }}
                  </div>
                </span>
              </VListItemTitle>
            </VListItem>
            <!-- Última Compra -->
            <VListItem>
              <VListItemTitle>
                <span class="d-flex align-center">
                  <div class="text-body-1 font-weight-medium me-2">Última Compra:</div>
                  <div class="d-inline-block text-body-1">
                    {{ props.client.last_purchase }}
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
              <client-informations-edit :data="client" />
            </v-btn>
          </span>
          <!-- <v-btn color="error" @click="form.reset">Cancelar</v-btn> -->
        </v-card-text>
      </v-card>
    </v-col>
    <v-col cols="12" sm="6" md="7" lg="8" xl="9">
      <v-row>
        <!-- Telefones -->
        <app-forms-phones :phones="props.phones" route-store="registers.client.storePhone" :data-id="props.client.id" />
        <!-- Endereços -->
        <app-form-addresses :addresses="props.addresses" route-store="registers.client.storeAddress" :data-id="props.client.id"></app-form-addresses>
        <!-- Mais Detalhes -->
        <v-col cols="12">
          <v-card class="mx-auto">
            <VCardItem>
              <template #prepend>
                <VIcon icon="mdi-account-details" size="24" class="me-2" />
              </template>

              <VCardTitle>Mais Detalhes</VCardTitle>
            </VCardItem>
            <v-card-text>
              <VList class="card-list text-medium-emphasis">
                <!-- E-mail -->
                <VListItem>
                  <VListItemTitle>
                    <span class="d-flex align-center">
                      <v-icon icon="mdi-email" size="24" class="me-2" />
                      <div class="text-body-1 font-weight-medium me-2">E-mail:</div>
                      <a v-if="props.client.email" class="d-inline-block text-body-1 text-primary" :href="'mailto:' + props.client.email">
                        {{ props.client.email }}
                      </a>
                    </span>
                  </VListItemTitle>
                </VListItem>
                <!-- Site -->
                <VListItem>
                  <VListItemTitle>
                    <span class="d-flex align-center">
                      <v-icon icon="mdi-link-variant" size="24" class="me-2" />
                      <div class="text-body-1 font-weight-medium me-2">Site:</div>
                      <a v-if="props.client.site" class="d-inline-block text-body-1 text-primary" :href="props.client.site" target="_blanck">
                        {{ stringLimit(props.client.site, 95) }}
                      </a>
                    </span>
                  </VListItemTitle>
                </VListItem>
              </VList>
            </v-card-text>
            <v-card-text v-if="props.client.note">
              <!-- 👉 Details -->
              <p class="text-body-1 text-disabled">OBSERVAÇÕES</p>
              <p class="text-body-1">{{ props.client.note }}</p>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-col>
  </v-row>
  <!-- <pre>{{ props.client }}</pre> -->
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
