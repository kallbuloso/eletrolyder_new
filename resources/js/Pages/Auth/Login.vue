<script setup>
const form = useForm({
  email: 'karl@admim.com',
  password: 'password',
  remember: true
})
const showPassword = ref(false)

const submit = () => {
  form.post(route('login'), {
    onFinish: () => form.reset('password')
  })
}
</script>

<template layout="AuthLayout">
  <Head title="Login" />
  <v-form-auth>
    <template #title> Fazer login 🔒 </template>
    <template #description>Informe suas credenciais para acessar o sistema.</template>
    <v-card-text>
      <v-form @submit.prevent="submit">
        <v-row>
          <v-col cols="12">
            <app-text-field
              v-model="form.email"
              type="email"
              label="Email"
              placeholder="Endereço de email"
              prepend-inner-icon="mdi-email-outline"
              :error-messages="form.errors.email"
            />
          </v-col>
          <v-col cols="12">
            <app-text-field
              v-model="form.password"
              label="Senha"
              placeholder="Digite sua senha"
              prepend-inner-icon="mdi-lock-outline"
              :append-inner-icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'"
              :type="showPassword ? 'text' : 'password'"
              :error-messages="form.errors.password"
              @click:append-inner="showPassword = !showPassword"
            />
          </v-col>
          <v-col cols="12">
            <div class="d-flex align-center justify-space-between flex-wrap">
              <v-checkbox v-model="form.remember" label="Lembre de mim" />
              <Link class="text-caption text-decoration-none text-blue" href="/forgot-password" rel="noreferrer" target="_blank"> Esqueceu sua senha?</Link>
            </div>
          </v-col>
        </v-row>

        <v-btn :loading="form.processing" type="submit" block color="primary" class="mt-2">Entrar</v-btn>
      </v-form>
    </v-card-text>
    <v-card-text class="text-center">
      <span class="d-inline-block"> Novo por aqui? </span>
      <Link class="text-blue text-decoration-none" :href="route('register')"> Cadastrar uma conta <v-icon icon="mdi-chevron-right" /> </Link>
    </v-card-text>
  </v-form-auth>
</template>
