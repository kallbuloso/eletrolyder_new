<script setup>
const props = defineProps({
  required: {
    type: Boolean,
    default: false
  }
})
defineOptions({
  name: 'AppAutocomplete',
  inheritAttrs: false
})

// const { class: _class, label, variant: _, ...restAttrs } = useAttrs()
const elementId = computed(() => {
  const attrs = useAttrs()
  const _elementIdToken = attrs.id || attrs.label

  return _elementIdToken ? `app-autocomplete-${_elementIdToken}-${Math.random().toString(36).slice(2, 7)}` : undefined
})

const label = computed(() => useAttrs().label)

const rules = computed(() => {
  const rules = []
  if (props.required) {
    rules.push((v) => !!v || 'Selecione uma opção')
  }
  return rules
})
</script>

<template>
  <div class="app-autocomplete flex-grow-1" :class="$attrs.class">
    <VLabel v-if="label" :for="elementId" class="mb-1 text-body-2" :text="label" />
    <VAutocomplete
      v-bind="{
        ...$attrs,
        class: null,
        label: undefined,
        id: elementId,
        variant: 'outlined',
        menuProps: {
          contentClass: ['app-inner-list', 'app-autocomplete__content', 'v-autocomplete__content']
        }
      }"
      :required="props.required"
      :rules="rules"
    >
      <template v-for="(_, name) in $slots" #[name]="slotProps">
        <slot :name="name" v-bind="slotProps || {}" />
      </template>
    </VAutocomplete>
  </div>
</template>
