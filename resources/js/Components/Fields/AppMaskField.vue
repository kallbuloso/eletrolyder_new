<script setup>
// Ref: https://vuejs-tips.github.io/vue-the-mask/
// Ref: https://github.com/vuejs-tips/vue-the-mask/blob/master/src/component.vue
import { mask as vMask, tokens } from 'vue-the-mask'
import masker from 'vue-the-mask/src/masker.js'

const props = defineProps({
  modelValue: [String, Number],
  mask: {
    type: [String, Array],
    required: true
  },
  masked: {
    // por padrão emite o valor não formatado, mude para true para formatar com a máscara
    type: Boolean,
    default: false // raw
  }
})

defineOptions({
  name: 'AppMaskField',
  inheritAttrs: false
})

const config = computed(() => {
  return {
    mask: props.mask,
    tokens,
    masked: props.masked
  }
})
const emit = defineEmits(['update:modelValue'])

const display = computed({
  get: () => props.modelValue,
  set: (display) => {
    emit('update:modelValue', refresh(display))
  }
})

const refresh = (value) => masker(value, props.mask, props.masked, tokens)

const elementId = computed(() => {
  const attrs = useAttrs()
  const _elementIdToken = attrs.id || attrs.label

  return _elementIdToken ? `app-text-field-${_elementIdToken}-${Math.random().toString(36).slice(2, 7)}` : undefined
})

const label = computed(() => useAttrs().label)

// const rules = computed(() => {
//   const rules = []
//   if (props.required) {
//     rules.push((v) => !!v || 'Campo obrigatório')
//   }
//   return rules
// })

// Tokens
// '#': {pattern: /\d/},
// 'X': {pattern: /[0-9a-zA-Z]/},
// 'S': {pattern: /[a-zA-Z]/},
// 'A': {pattern: /[a-zA-Z]/, transform: v => v.toLocaleUpperCase()},
// 'a': {pattern: /[a-zA-Z]/, transform: v => v.toLocaleLowerCase()},
// '!': {escape: true}

// function keyPress(event) {
//   const key = event.keyCode
//   const value = event.target.value
//   // const mask = props.options.inputMask
//   // const outputMask = props.options.outputMask
//   // const empty = props.options.empty
//   // const maskLength = mask.length
//   // const valueLength = value.length
//   // const maskChar = mask[valueLength]
//   // const valueChar = value[valueLength]
//   // const isMaskChar = maskChar === '#'
//   // const isValueChar = valueChar === maskChar
//   // const isBackspace = key === 'Backspace'
//   // const isDelete = key === 'Delete'
//   // const isNumber = !isNaN(key)
//   // const isMask = isMaskChar && isNumber
//   // const isValue = isValueChar && isNumber
//   // const isMaskLength = valueLength < maskLength
//   // const isMaskCharLength = valueLength < maskLength && isMaskChar
//   // const isValueCharLength = valueLength < maskLength && isValueChar
//   // const isMaskCharLengthBackspace = valueLength < maskLength && isMaskChar && isBackspace
//   // const isValueCharLengthBackspace = valueLength < maskLength && isValueChar && isBackspace
//   // const isMaskCharLengthDelete = valueLength < maskLength && isMaskChar && isDelete
//   // const isValueCharLengthDelete = valueLength < maskLength && isValueChar && isDelete
//   // const isMaskCharLengthMask = valueLength < maskLength && isMaskChar && isMask
//   // const isValueCharLengthValue = valueLength < maskLength && isValueChar && isValue
//   // const isMaskCharLengthMaskBackspace = valueLength < maskLength && isMaskChar && isMask && isBackspace
//   // const isValueCharLengthValueBackspace = valueLength < maskLength && isValueChar && isValue && isBackspace
//   // const isMaskCharLengthMaskDelete = valueLength < maskLength && isMaskChar && isMask && isDelete
//   // const isValueCharLengthValueDelete = valueLength < maskLength && isValueChar && isValue && isDelete
//   // const isMaskCharLengthMaskValue = valueLength < maskLength && isMaskChar && isMask && isValue
//   // const isValueCharLengthValueMask = valueLength < maskLength && isValueChar && isValue && isMask
//   // const isMaskCharLengthMaskValueBackspace = valueLength
//   // const isValueCharLengthValueMaskBackspace = valueLength
//   // const isMaskCharLengthMaskValueDelete = valueLength
//   // const isValueCharLengthValueMaskDelete = valueLength
// }
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
      v-model="display"
      v-mask="config"
    >
      <template v-for="(_, name) in $slots" #[name]="slotProps">
        <slot :name="name" v-bind="slotProps || {}" />
      </template>
    </VTextField>
  </div>
</template>
