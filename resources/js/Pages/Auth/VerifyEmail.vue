<script setup>
const props = defineProps({
  status: {
    type: String
  }
})

const form = useForm({})

const logout = () => {
  form.post(route('logout'))
}

const submit = () => {
  form.post(route('verification.send'))
}
const verificationLinkSent = computed(() => props.status === 'verification-link-sent')
</script>

<template layout="AuthLayout">
  <Head title="Verificação de e-mail" />
  <v-form-auth>
    <template #title> Verifique seu e-mail ✉️ </template>
    <v-card-text>
      <v-form @submit.prevent="submit">
        <div v-if="verificationLinkSent" class="text-body-1 mb-4">
          <p>Um novo link de verificação foi enviado para o endereço de e-mail que você forneceu durante o registro.</p>
        </div>
        <div v-else class="text-body-1 text-medium-emphasis mb-4">
          <p>Link de ativação da conta enviado para o endereço de e-mail que você acabou de cadastrar. Siga o link para continuar.</p>
        </div>

        <v-btn class="my-5" block :loading="form.processing" @click="logout">Sair por enquanto </v-btn>

        <div class="d-flex align-center justify-center">
          <span class="me-1">Não recebeu o e-mail?</span>
          <v-btn type="submit" :loading="form.processing" variant="plain">Reenviar</v-btn>
        </div>
      </v-form>
    </v-card-text>
  </v-form-auth>
</template>
