<script setup>
const props = defineProps({
  required: {
    type: Boolean,
    default: false
  }
})
defineOptions({
  name: 'AppTextarea',
  inheritAttrs: false
})

// const { class: _class, label, variant: _, ...restAttrs } = useAttrs()
const elementId = computed(() => {
  const attrs = useAttrs()
  const _elementIdToken = attrs.id || attrs.label

  return _elementIdToken ? `app-textarea-${_elementIdToken}-${Math.random().toString(36).slice(2, 7)}` : undefined
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
  <div class="app-textarea flex-grow-1" :class="$attrs.class">
    <VLabel v-if="label" :for="elementId" class="mb-1 text-body-2" :text="label" />
    <VTextarea
      v-bind="{
        ...$attrs,
        class: null,
        label: undefined,
        variant: 'outlined',
        id: elementId
      }"
      :required="props.required"
      :rules="rules"
    >
      <template v-for="(_, name) in $slots" #[name]="slotProps">
        <slot :name="name" v-bind="slotProps || {}" />
      </template>
    </VTextarea>
  </div>
</template>
