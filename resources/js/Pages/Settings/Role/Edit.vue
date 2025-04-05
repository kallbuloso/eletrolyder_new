<script setup>
const props = defineProps({
  data: {
    type: Object,
    required: true
  },
  permissions: {
    type: Array,
    required: true
  }
})

const form = useForm({
  tenant_id: usePage().props.auth.user.tenant_id,
  name: null,
  description: null,
  guard_name: 'web',
  permissions: []
})

const isSelectAll = ref(false)
const checkedCount = computed(() => form.permissions.length)
const isIndeterminate = computed(() => {
  const totalPermissions = props.permissions.length
  const result = checkedCount.value > 0 && checkedCount.value < totalPermissions
  return result
})

const groupedPermissions = computed(() => {
  return props.permissions.reduce((acc, permission) => {
    const groupName = permission.name.split(' ')[0]
    if (!acc[groupName]) {
      acc[groupName] = []
    }
    acc[groupName].push(permission)
    return acc
  }, {})
})

// select all
watch(isSelectAll, (newVal) => {
  // Aplica mudanças somente se o novo estado realmente refletir a intenção de selecionar ou desmarcar todos
  const currentIds = new Set(form.permissions)
  if (newVal && form.permissions.length !== props.permissions.length) {
    form.permissions = props.permissions.map((permission) => permission.id)
  } else if (!newVal && currentIds.size > 0) {
    form.permissions = []
  }
})

const submit = () => {
  form.put(route('settings.roles.update', props.data.id), {
    onSuccess() {
      form.reset()
    }
  })
}

onMounted(() => {
  form.name = props.data.name
  form.description = props.data.description
  form.guard_name = props.data.guard_name
  form.permissions = props.data.permissions.map((permission) => permission.id)
  const totalPermissions = props.permissions.length
  const selectedCount = form.permissions.length
  if (selectedCount === totalPermissions) {
    isSelectAll.value = true
  }

  // console.log('Role page mounted', form)
})
</script>

<template>
  <app-modal width="600">
    <v-form @submit.prevent="submit">
      <v-card prepend-icon="mdi-account-key" :title="$page.props.title">
        <v-card-text>
          <app-name-field
            v-model="form.name"
            type="text"
            label="Nome"
            placeholder="Nome da Alçada"
            :error-messages="form.errors.name"
            :disabled="form.name === 'Administrador'"
            autofocus
          />
          <app-name-field v-model="form.description" type="text" label="Descrição" placeholder="Descrição do acesso" :error-messages="form.errors.description" />
        </v-card-text>
        <v-card-text>
          <p class="font-weight-medium">Permissões</p>
          <v-divider />
          <v-col cols="12" class="d-flex">
            <v-spacer />
            <v-checkbox v-model="isSelectAll" :indeterminate="isIndeterminate" label="Selecionar Tudo" />
          </v-col>
          <v-table density="compact">
            <tbody>
              <tr v-for="group in Object.keys(groupedPermissions)" :key="group">
                <td class="text-capitalize">{{ group }}</td>
                <td class="d-flex">
                  <v-spacer />
                  <v-checkbox
                    v-for="permission in groupedPermissions[group]"
                    :key="permission.id"
                    v-model="form.permissions"
                    :label="permission.name.split(' ')[1]"
                    :value="permission.id"
                    class="text-capitalize"
                    hide-details
                  />
                </td>
              </tr>
            </tbody>
          </v-table>
        </v-card-text>
        <v-card-actions>
          <v-spacer />
          <Link :href="route('settings.roles.index')" as="div">
            <v-btn variant="text">Cancelar</v-btn>
          </Link>
          <v-btn type="submit" prepend-icon="mdi-shield-edit-outline" :loading="form.processing">Atualizar</v-btn>
        </v-card-actions>
      </v-card>
    </v-form>
  </app-modal>
</template>
