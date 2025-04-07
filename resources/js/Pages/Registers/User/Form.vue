<script setup>
import { router } from '@inertiajs/vue3'

const props = defineProps({
  data: {
    type: Object,
    required: false
  },
  roles: {
    type: Object,
    required: true
  }
})

const showPassword = ref(false)

// group roles by resource
const groupedRoles = computed(() => {
  return props.roles.reduce((acc, role) => {
    // Verifica se a chave já existe; se não, inicializa como um array vazio
    if (!acc[role.name]) {
      acc[role.name] = []
    }
    // Agora adiciona o role ao array
    acc[role.name].push(role)
    return acc
  }, {})
})

const form = useForm({
  tenant_id: usePage().props.auth.user.tenant_id,
  name: null,
  email: null,
  profile_photo_path: null,
  password: null,
  password_confirmation: null,
  roles: []
})

const submit = () => {
  // Converte o role selecionado em um array antes de enviar
  if (form.roles && !Array.isArray(form.roles)) {
    form.roles = [form.roles]
  }

  if (props.data) {
    form.put(route('registers.user.update', props.data.id), {
      onSuccess() {
        form.reset()
        router.visit(route('registers.user.index'), {
          preserveScroll: true,
          preserveState: false
        })
      }
    })
  } else {
    form.post(route('registers.user.store'), {
      onSuccess() {
        form.reset()
        router.visit(route('registers.user.index'), {
          preserveScroll: true,
          preserveState: false
        })
      }
    })
  }
}

onMounted(() => {
  if (isObject(props.data)) {
    form.tenant_id = props.data.tenant_id
    form.name = props.data.name
    form.email = props.data.email
    form.profile_photo_path = props.data.profile_photo_path
    form.password = null
    form.password_confirmation = null
    form.roles = props.data.roles.length > 0 ? props.data.roles[0].id : null
  }
  // console.log('User page mounted: ', groupedRoles.value)
})
</script>

<template>
  <app-modal width="700">
    <v-form @submit.prevent="submit">
      <v-card class="mx-auto" prepend-icon="mdi-account" :title="$page.props.title">
        <v-card-text>
          <v-row class="d-flex justify-between">
            <v-col cols="12">
              <v-row>
                <v-col cols="6">
                  <app-name-field v-model="form.name" label="Nome" placeholder="Name" :error-messages="form.errors.name" />
                </v-col>
                <v-col cols="6">
                  <app-email-field v-model="form.email" label="E-mail" placeholder="Email" :error-messages="form.errors.email" />
                </v-col>
                <v-col cols="6">
                  <app-text-field
                    v-model="form.password"
                    label="Senha"
                    placeholder="Coloque sua senha"
                    prepend-inner-icon="mdi-lock-outline"
                    :append-inner-icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'"
                    :type="showPassword ? 'text' : 'password'"
                    :hint="props.data ? 'Deixe em branco para manter a senha atual' : ''"
                    :persistent-hint="props.data ? true : false"
                    :error-messages="form.errors.password"
                    @click:append-inner="showPassword = !showPassword"
                  />
                </v-col>
                <v-col cols="6">
                  <app-text-field
                    v-model="form.password_confirmation"
                    label="Confirme a senha"
                    placeholder="Repita a senha"
                    prepend-inner-icon="mdi-lock-outline"
                    :append-inner-icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'"
                    :type="showPassword ? 'text' : 'password'"
                    :hint="props.data ? 'Deixe em branco para manter a senha atual' : ''"
                    :persistent-hint="props.data ? true : false"
                    :error-messages="form.errors.password_confirmation"
                    @click:append-inner="showPassword = !showPassword"
                  />
                </v-col>
              </v-row>
            </v-col>
            <v-col cols="12">
              <v-list-item title="Permissões" />
              <v-divider />
              <v-table density="compact" hover>
                <tbody>
                  <tr v-for="group in Object.keys(groupedRoles)" :key="group">
                    <td>
                      <v-radio-group v-model="form.roles" :error-messages="form.errors.roles">
                        <v-radio v-for="role in groupedRoles[group]" :key="role.id" :label="role.name" :value="role.id" class="text-capitalize" hide-details />
                      </v-radio-group>
                    </td>
                  </tr>
                </tbody>
              </v-table>
            </v-col>
          </v-row>
        </v-card-text>
        <v-card-actions>
          <v-spacer />
          <Link :href="route('registers.user.index')" as="div">
            <v-btn variant="text">Cancelar</v-btn>
          </Link>
          <v-btn type="submit" color="primary" :loading="form.processing">{{ props.data ? 'Atualizar' : 'Criar' }}</v-btn>
        </v-card-actions>
      </v-card>
    </v-form>
  </app-modal>
</template>
