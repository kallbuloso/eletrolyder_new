<script setup>
const props = defineProps({
  email: {
    type: String,
    required: true
  },
  token: {
    type: String,
    required: true
  }
})

const form = useForm({
  token: props.token,
  email: props.email,
  password: '',
  password_confirmation: ''
})

const submit = () => {
  form.post(route('password.store'), {
    onFinish: () => form.reset('password', 'password_confirmation')
  })
}

const showPassword = ref(false)
</script>

<template layout="AuthLayout">
  <Head title="Redefinir senha" />
  <v-form-auth>
    <template #title> Redefinição de senha. 🔒 </template>
    <template #description>Sua nova senha deve ser diferente das senhas usadas anteriormente.</template>
    <v-card-text>
      <v-form @submit.prevent="submit">
        <v-row>
          <v-col cols="12">
            <app-text-field
              v-model="form.email"
              type="email"
              label="E-mail de cadastrado"
              placeholder="Digite seu email"
              prepend-inner-icon="mdi-email-outline"
              :error-messages="form.errors.email"
              disabled
            />
          </v-col>
          <v-col cols="12">
            <app-text-field
              v-model="form.password"
              label="Nova Senha"
              placeholder="Digite sua nova senha"
              prepend-inner-icon="mdi-lock-outline"
              :append-inner-icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'"
              :type="showPassword ? 'text' : 'password'"
              :error-messages="form.errors.password"
              @click:append-inner="showPassword = !showPassword"
            />
          </v-col>
          <v-col cols="12">
            <app-text-field
              v-model="form.password_confirmation"
              label="Confirme a nova senha"
              placeholder="Repita sua nova senha"
              prepend-inner-icon="mdi-lock-outline"
              :append-inner-icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'"
              :type="showPassword ? 'text' : 'password'"
              :error-messages="form.errors.password_confirmation"
              @click:append-inner="showPassword = !showPassword"
            />
          </v-col>
        </v-row>
        <v-btn :loading="form.processing" class="mt-6 mb-sm-6" type="submit" block color="primary"> Redefinir senha </v-btn>
        <div class="d-flex justify-center flex-wrap">
          <Link class="text-body-1 text-decoration-none text-primary" :href="route('login')" rel="noreferrer">
            <VIcon icon="mdi-chevron-left" size="22" class="me-1 flip-in-rtl" />
            <span>Voltar para login</span>
          </Link>
        </div>
      </v-form>
    </v-card-text>
  </v-form-auth>
</template>
