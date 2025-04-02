<script setup>
import { emailValidator } from '@/utils/validators'

const props = defineProps({
  domains: {
    type: Array,
    default: () => ['gmail.com', 'hotmail.com', 'outlook.com', 'ig.com.br', 'uol.com.br', 'bol.com.br', 'yahoo.com', 'icloud.com']
  },
  maxDomainsVisible: {
    type: Number,
    default: 10
  },
  modelValue: {
    type: String
  },
  count: {
    type: [String, Number],
    default: 100
  },
  required: {
    type: Boolean,
    default: false
  }
})

defineOptions({
  inheritAttrs: false
})

const elementId = computed(() => {
  const attrs = useAttrs()
  const _elementIdToken = attrs.id || attrs.label

  return _elementIdToken ? `app-text-field-${_elementIdToken}-${Math.random().toString(36).slice(2, 7)}` : undefined
})

const label = computed(() => useAttrs().label)

const rules = computed(() => {
  const rules = [emailValidator]
  if (props.required) {
    rules.push((v) => !!v || 'Email obrigatório')
  }
  return rules
})

const showSuggestionList = ref(false)
const selectedIndex = ref(-1)
const emailInput = ref(null)
const emit = defineEmits(['update:modelValue'])

const email = computed({
  get: () => props.modelValue,
  set: (email) => {
    emit('update:modelValue', email)
  }
})

watch(email, (newEmail) => {
  if (newEmail.includes('@') && !domainFilled.value) {
    showSuggestionList.value = true
  } else {
    showSuggestionList.value = false
  }
})

const domainFilled = computed(() => {
  const regex = /\.com(\.br)|\.top|\.ai|\.se|\.org(\.br)|\.site|\.it|\.net|\.co|\.gov(\.br)|\.online|\.blog|\.dev|\.local?$/i
  return regex.test(email.value)
})

const filteredDomains = computed(() => {
  if (props.domains.length && email.value.includes('@')) {
    const enteredDomain = email.value.split('@')[1]
    return props.domains.filter((domain) => domain.startsWith(enteredDomain)).slice(0, props.maxDomainsVisible)
  }
  return []
})

function selectSuggestion(suggestion) {
  email.value = `${email.value.split('@')[0]}@${suggestion}`
  showSuggestionList.value = false
  emailInput.value.focus()
}

function handleArrowKeys(event) {
  if (event.key === 'ArrowDown') {
    event.preventDefault()
    selectedIndex.value = (selectedIndex.value + 1) % filteredDomains.value.length
  } else if (event.key === 'ArrowUp') {
    event.preventDefault()
    selectedIndex.value = selectedIndex.value - 1 < 0 ? filteredDomains.value.length - 1 : selectedIndex.value - 1
  } else if (event.key === 'Enter' && selectedIndex.value !== -1) {
    event.preventDefault()
    selectSuggestion(filteredDomains.value[selectedIndex.value])
  }
}
</script>

<template>
  <div class="app-text-field flex-grow-1" :class="$attrs.class">
    <VLabel v-if="label" :for="elementId" class="mb-1 text-body-2 text-wrap" :text="label" />
    <VTextField
      v-bind="{
        ...$attrs,
        class: null,
        label: undefined,
        variant: 'outlined',
        id: elementId
      }"
      ref="emailInput"
      v-model="email"
      type="email"
      prepend-inner-icon="mdi-email-outline"
      :required="props.required"
      :rules="rules"
      :maxlength="count"
      @keydown="handleArrowKeys"
    >
      <v-menu v-model="showSuggestionList" :close-on-content-click="true" activator="parent">
        <v-list>
          <v-list-item v-for="(domain, index) in filteredDomains" :key="domain" :class="{ 'v-list-item--active': index === selectedIndex }" @click="selectSuggestion(domain)">
            <v-list-item-title>{{ domain }}</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
    </VTextField>
  </div>
</template>
