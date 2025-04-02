<script setup>
const form = useForm({
  name: '',
  email: '',
  password: 'password',
  password_confirmation: 'password'
})
const showPassword = ref(false)

const submit = () => {
  form.post(route('register'), {
    onFinish: () => form.reset('password', 'password_confirmation')
  })
}
</script>

<template layout="AuthLayout">
  <Head title="Registrar" />
  <v-form-auth>
    <template #title> Cadastrar uma conta 🔒 </template>
    <template #description>Informe suas credenciais para se cadastrar no sistema.</template>
    <v-card-text>
      <v-form @submit.prevent="submit">
        <v-row>
          <v-col cols="12">
            <app-name-field
              v-model="form.name"
              type="name"
              label="Nome completo"
              placeholder="Nome completo"
              prepend-inner-icon="mdi-account"
              required
              :error-messages="form.errors.name"
            />
          </v-col>
          <v-col cols="12">
            <app-email-field
              v-model="form.email"
              type="email"
              label="Email"
              placeholder="Email address"
              required
              hint="Este email precisará ser válido e ativo."
              persistent-hint
              prepend-inner-icon="mdi-email-outline"
              :error-messages="form.errors.email"
            />
          </v-col>
          <v-col cols="12" sm="6">
            <app-text-field
              v-model="form.password"
              label="Senha"
              placeholder="Sua senha"
              prepend-inner-icon="mdi-lock-outline"
              :append-inner-icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'"
              :type="showPassword ? 'text' : 'password'"
              required
              :error-messages="form.errors.password"
              @click:append-inner="showPassword = !showPassword"
            />
          </v-col>
          <v-col cols="12" sm="6">
            <app-text-field
              v-model="form.password_confirmation"
              label="Confirme sua senha"
              placeholder="Repita a senha"
              prepend-inner-icon="mdi-lock-outline"
              :append-inner-icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'"
              :type="showPassword ? 'text' : 'password'"
              required
              :error-messages="form.errors.password_confirmation"
              @click:append-inner="showPassword = !showPassword"
            />
          </v-col>
        </v-row>
        <v-btn :loading="form.processing" type="submit" block color="primary" class="mt-7">Registrar</v-btn>
      </v-form>
    </v-card-text>
    <v-card-text class="text-center">
      <span class="d-inline-block"> Já tem cadastro? </span>
      <Link class="text-blue text-decoration-none" :href="route('login')"> Entrar </Link>
    </v-card-text>
  </v-form-auth>
</template>
