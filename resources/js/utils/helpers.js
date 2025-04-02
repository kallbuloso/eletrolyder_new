export const route = window.route
// 👉 IsEmpty
export const isEmpty = (value) => {
  if (value === null || value === undefined || value === '') return true

  return !!(Array.isArray(value) && value.length === 0)
}

export const isNotEmpty = (value) => {
  return !isEmpty(value)
}

// 👉 IsNullOrUndefined
export const isNullOrUndefined = (value) => {
  return value === null || value === undefined
}

// 👉 IsEmptyArray
export const isEmptyArray = (arr) => {
  return Array.isArray(arr) && arr.length === 0
}

export const isArrayOfObjects = (arr) => {
  return Array.isArray(arr) && arr.length > 0 && arr.every((item) => isObject(item))
}

// 👉 IsObject
export const isObject = (obj) => obj !== null && !!obj && typeof obj === 'object' && !Array.isArray(obj)

// 👉 IsToday
export const isToday = (date) => {
  const today = new Date()

  return date.getDate() === today.getDate() && date.getMonth() === today.getMonth() && date.getFullYear() === today.getFullYear()
}

// 👉 Sleep
// export const sleep = (seconds) => {
//   return new Promise((res) => setTimeout(res, seconds * 1000))
// }

export const onLoading = () => {
  const state = ref(false)
  router.on('start', () => (state.value = true))
  router.on('finish', () => (state.value = false))
  return state.value
}

// 👉 can
export const can = (value, n) => {
  let isPermitted = false
  const user = usePage().props.auth.user
  const perm = reactive({
    permission: user.permissions.indexOf(`${value} ${n}`) > -1,
    role: user.role.indexOf('Super-admin') > -1
  })
  if (perm.permission || perm.role) {
    return (isPermitted = true)
  }
  return isPermitted
}

// 👉 PermitDelete
export const permitDelete = (value) => {
  return can(value, 'excluir')
}

// 👉 PermitEdit
export const permitEdit = (value) => {
  return can(value, 'editar')
}

// 👉 PermitCreate
export const permitCreate = (value) => {
  return can(value, 'criar')
}

// 👉 PermitList
export const permitList = (value) => {
  return can(value, 'listar')
}

// 👉 PermitShow
export const permitShow = (value) => {
  return can(value, 'visualizar')
}

export const stringLimit = (string, limit = 20) => {
  return string.length > limit ? `${string.substring(0, limit)}...` : string
}
