<script setup>
import { formatToCapitalized } from 'brazilian-values'

const props = defineProps({
  required: {
    type: Boolean,
    default: false
  }
})

defineOptions({
  name: 'AppNameField',
  inheritAttrs: false
})

const emit = defineEmits(['update:modelValue'])

const elementId = computed(() => {
  const attrs = useAttrs()
  const _elementIdToken = attrs.id || attrs.label

  return _elementIdToken ? `app-text-field-${_elementIdToken}-${Math.random().toString(36).slice(2, 7)}` : undefined
})

const label = computed(() => useAttrs().label)

const rules = computed(() => {
  const rules = []
  if (props.required) {
    rules.push((v) => !!v || 'Campo obrigatório')
  }
  return rules
})
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
        id: elementId,
        rules: rules
      }"
      @update:model-value="($event) => emit('update:modelValue', formatToCapitalized($event))"
    >
      <template v-for="(_, name) in $slots" #[name]="slotProps">
        <slot :name="name" v-bind="slotProps || {}" />
      </template>
    </VTextField>
  </div>
</template>
