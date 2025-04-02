<script setup>
import { computed } from 'vue'

const props = defineProps({ status: Number })

const icon = computed(() => {
  return {
    403: 'iconify:tabler:face-id-error',
    404: 'iconify:tabler:error-404',
    500: 'iconify:mdi:server-network-off',
    503: 'iconify:gravity-ui:person-worker'
  }[props.status]
})

const headline = computed(() => {
  return {
    403: 'Erro, 403',
    404: 'Erro, 404',
    500: 'Erro, 500',
    503: 'Erro, 503'
  }[props.status]
})

const title = computed(() => {
  return {
    403: 'Acesso Proibido',
    404: 'Página não encontrada',
    500: 'Erro de servidor',
    503: 'Serviço não indisponível'
  }[props.status]
})

const description = computed(() => {
  return {
    403: 'Desculpe, você não pode acessar esta página.',
    404: 'Desculpe, a página que você está procurando não foi encontrada.',
    500: 'Opa, algo deu errado em nossos servidores.',
    503: 'Desculpe, estamos fazendo alguma manutenção. Por favor, volte em breve.'
  }[props.status]
})
</script>

<template layout="GuestLayout">
  <Head :title="title" />

  <v-row align="center" justify="center" style="height: 100vh">
    <v-col cols="12" sm="7" md="5" lg="4" xl="3" xxl="2">
      <v-empty-state>
        <template #media>
          <v-icon color="surface-variant">{{ icon }}</v-icon>
        </template>

        <template #headline>
          <div class="text-h4">{{ headline }}</div>
        </template>

        <template #title>
          <div class="text-h6">{{ title }}</div>
        </template>

        <template #text>
          <div class="text-medium-emphasis text-caption">
            {{ description }}
          </div>
        </template>
      </v-empty-state>
    </v-col>
  </v-row>
</template>
