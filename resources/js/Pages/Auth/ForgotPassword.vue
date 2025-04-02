<script setup>
defineProps({
  status: {
    type: String
  }
})

const form = useForm({
  email: ''
})

const submit = () => {
  form.post(route('password.email'))
}
</script>

<template layout="AuthLayout">
  <Head title="Esqueceu sua senha" />
  <v-form-auth>
    <template #title>{{ status ? 'Redefinir a senha.' : 'Esqueceu sua senha? 🔒' }}</template>
    <template #description>{{ status ? '' : 'Sem problemas!' }}</template>
    <v-card-text>
      <div v-if="!status" class="text-body-1 text-medium-emphasis mb-4">
        Basta nos informar seu endereço de e-mail e enviaremos um link de redefinição que permitirá que você escolha uma nova senha.
      </div>
      <v-form @submit.prevent="submit">
        <v-row>
          <div v-if="status">
            <v-col cols="12">
              <div class="text-body-1 mb-4">
                {{ status }}
              </div>
            </v-col>
            <v-col cols="12">
              <v-alert density="compact" type="info" icon="mdi-information-outline">
                <span class="text-body-1">Nota:</span> O link de redefinição de senha será válido somente por 60 minutos.
              </v-alert>
            </v-col>
          </div>
          <v-col v-if="!status" cols="12">
            <app-text-field
              v-model="form.email"
              type="email"
              label="Email"
              placeholder="Digite seu endereço de email"
              prepend-inner-icon="mdi-email-outline"
              hint="Atenção! O link de redefinição será válido somente por 60 minutos."
              :error-messages="form.errors.email"
            />
          </v-col>
        </v-row>
        <v-btn v-if="!status" :loading="form.processing" class="mt-4" type="submit" block color="primary"> Enviar redefinição de senha </v-btn>
      </v-form>
      <v-col cols="12">
        <div class="d-flex justify-center flex-wrap">
          <Link class="text-body-1 text-decoration-none text-primary" :href="route('login')" rel="noreferrer">
            <VIcon icon="mdi-chevron-left" size="22" class="me-1 flip-in-rtl" />
            <span>Voltar para login</span>
          </Link>
        </div>
      </v-col>
    </v-card-text>
  </v-form-auth>
</template>
