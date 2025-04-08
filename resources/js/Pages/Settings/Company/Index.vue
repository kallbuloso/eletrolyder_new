<script setup>
import parallax from '@images/pages/user-profile-header-bg.png'
import { formatToCPFOrCNPJ } from 'brazilian-values'
import CompanyInformationsEdit from './CompanyInformationsEdit.vue'

const props = defineProps({
  company: {
    type: [Object, Array],
    required: true
  },
  phones: {
    type: [Object, Array],
    required: false
  },
  addresses: {
    type: [Object, Array],
    required: false
  }
})

// Função para retornar o texto do avatar
const loadPerson = (param, value) => {
  return props.company.person === 'F' ? param : value
}
</script>

<template layout="AppShell,AuthenticatedLayout">
  <v-row>
    <v-col cols="12">
      <!-- 👉 Company Header  -->
      <VCard class="mx-auto">
        <VImg :src="parallax" min-height="90" max-height="120" cover />
        <VCardText class="d-flex align-bottom flex-sm-row flex-column justify-center gap-x-6">
          <div class="d-flex h-0">
            <!-- Avatar -->
            <VAvatar
              class="user-profile-avatar mx-auto"
              rounded
              :size="120"
              :color="!props.company.logo ? 'primary' : undefined"
              :variant="!props.company.logo ? 'tonal' : undefined"
            >
              <VImg v-if="!props.company.logo === null" :src="props.company.logo" />
              <span v-else class="text-3xl font-weight-medium text-primary">
                {{ avatarText(props.company.name) }}
              </span>
            </VAvatar>
          </div>

          <div class="user-profile-info w-100 mt-16 pt-6 pt-sm-0 mt-sm-0">
            <h4 class="text-h4 text-center text-sm-start font-weight-medium mb-2">
              {{ props.company.name }}
            </h4>
          </div>
        </VCardText>
      </VCard>
    </v-col>
    <v-col cols="12" sm="6" md="5" lg="4" xl="3">
      <v-card class="mx-auto">
        <VCardItem>
          <template #prepend>
            <VIcon icon="mdi-office-building" size="24" class="me-2" />
          </template>
          <VCardTitle>Informações da Empresa</VCardTitle>
        </VCardItem>
        <v-card-text>
          <!-- 👉 Lista de detalhes do usuário -->
          <VList class="card-list text-medium-emphasis">
            <!-- Nome Fantasia / apelido -->
            <VListItem>
              <VListItemTitle>
                <span class="d-flex align-center">
                  <VIcon :icon="loadPerson('mdi-account-star', 'mdi-office-building')" size="24" class="me-2" />
                  <div class="text-body-1 font-weight-medium me-2">{{ props.company.person === 'F' ? 'Apelido:' : 'Nome Fantasia:' }}</div>
                  <div class="d-inline-block text-body-1">
                    {{ props.company.fantasy_name }}
                  </div>
                </span>
              </VListItemTitle>
            </VListItem>
            <!-- Contato -->
            <VListItem>
              <VListItemTitle>
                <span class="d-flex align-center">
                  <VIcon icon="mdi-contacts" size="24" class="me-2" />
                  <div class="text-body-1 font-weight-medium me-2">{{ props.company.person === 'F' ? 'Contato:' : 'Responsável:' }}</div>
                  <div class="d-inline-block text-body-1">
                    {{ props.company.contact_name }}
                  </div>
                </span>
              </VListItemTitle>
            </VListItem>
            <!-- Tipo Pessoa -->
            <v-list-item>
              <v-list-item-title>
                <span class="d-flex align-center">
                  <VIcon :icon="props.company.person === 'F' ? 'mdi-account' : 'mdi-office-building'" size="24" class="me-2" />
                  <div class="text-body-1 font-weight-medium me-2">Pessoa:</div>
                  <div class="d-inline-block text-body-1">
                    {{ props.company.person === 'F' ? 'Física' : 'Jurídica' }}
                  </div>
                </span>
              </v-list-item-title>
            </v-list-item>
            <!-- CPF / CNPJ -->
            <VListItem>
              <VListItemTitle>
                <span class="d-flex align-center">
                  <VIcon icon="mdi-card-account-details" size="24" class="me-2" />
                  <div class="text-body-1 font-weight-medium me-2">{{ props.company.person === 'F' ? 'CPF:' : 'CNPJ:' }}</div>
                  <div class="d-inline-block text-body-1">
                    {{ props.company.cpf_cnpj ? formatToCPFOrCNPJ(props.company.cpf_cnpj) : 'Não informado' }}
                  </div>
                </span>
              </VListItemTitle>
            </VListItem>
            <!-- CCM -->
            <VListItem v-if="props.company.person === 'J'">
              <VListItemTitle>
                <span class="d-flex align-center">
                  <VIcon icon="mdi-card-account-details" size="24" class="me-2" />
                  <div class="text-body-1 font-weight-medium me-2">CCM:</div>
                  <div class="d-inline-block text-body-1">
                    {{ props.company.ccm ?? 'Não informado' }}
                  </div>
                </span>
              </VListItemTitle>
            </VListItem>
            <!-- RG / Inscr. Estadual -->
            <VListItem>
              <VListItemTitle>
                <span class="d-flex align-center">
                  <VIcon icon="mdi-card-account-details" size="24" class="me-2" />
                  <div class="text-body-1 font-weight-medium me-2">{{ props.company.person === 'F' ? 'RG:' : 'Insc. Estadual:' }}</div>
                  <div class="d-inline-block text-body-1">
                    {{ props.company.rg_insc_est ?? 'Não informado' }}
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
                  <div class="text-body-1 font-weight-medium me-2">{{ props.company.person === 'F' ? 'Aniverssário:' : 'Inalguração:' }}</div>
                  <div class="d-inline-block text-body-1">
                    {{ props.company.birth_date }}
                  </div>
                </span>
              </VListItemTitle>
            </VListItem>
            <!-- Cadastrado em -->
            <VListItem>
              <VListItemTitle>
                <span class="d-flex align-center">
                  <div class="text-body-1 font-weight-medium me-2">Cadastro em:</div>
                  <div class="d-inline-block text-body-1">
                    {{ props.company.created_at }}
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
                    {{ props.company.updated_at }}
                  </div>
                </span>
              </VListItemTitle>
            </VListItem>
          </VList>
        </v-card-text>
        <v-card-text>
          <span class="d-flex align-center">
            <v-btn color="primary" prepend-icon="mdi-pencil" variant="flat">
              Editar dados da empresa
              <company-informations-edit :data="props.company" />
            </v-btn>
          </span>
        </v-card-text>
      </v-card>
    </v-col>
    <v-col cols="12" sm="6" md="7" lg="8" xl="9">
      <v-row>
        <!-- Telefones -->
        <app-forms-phones :phones="props.phones" route-store="settings.company.phone.store" :data-id="props.company.id" />
        <!-- Endereços -->
        <app-form-addresses :addresses="props.addresses" route-store="settings.company.address.store" :data-id="props.company.id" />
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
                      <a v-if="props.company.email" class="d-inline-block text-body-1 text-primary" :href="'mailto:' + props.company.email">
                        {{ props.company.email }}
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
                      <a v-if="props.company.website" class="d-inline-block text-body-1 text-primary" :href="props.company.website" target="_blanck">
                        {{ stringLimit(props.company.website, 85) }}
                      </a>
                    </span>
                  </VListItemTitle>
                </VListItem>
              </VList>
            </v-card-text>
            <v-card-text v-if="props.company.note">
              <!-- 👉 Details -->
              <p class="text-body-1 text-disabled">OBSERVAÇÕES</p>
              <p class="text-body-1">{{ props.company.note }}</p>
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
