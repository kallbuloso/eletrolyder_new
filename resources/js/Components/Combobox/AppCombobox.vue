<script setup>
const props = defineProps({
  required: {
    type: Boolean,
    default: false
  }
})
defineOptions({
  name: 'AppCombobox',
  inheritAttrs: false
})

const elementId = computed(() => {
  const attrs = useAttrs()
  const _elementIdToken = attrs.id || attrs.label

  return _elementIdToken ? `app-combobox-${_elementIdToken}-${Math.random().toString(36).slice(2, 7)}` : undefined
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
  <div class="app-combobox flex-grow-1" :class="$attrs.class">
    <VLabel v-if="label" :for="elementId" class="mb-1 text-body-2" :text="label" />

    <VCombobox
      v-bind="{
        ...$attrs,
        class: null,
        label: undefined,
        variant: 'outlined',
        id: elementId,
        menuProps: {
          contentClass: ['app-inner-list', 'app-combobox__content', 'v-combobox__content', $attrs.multiple !== undefined ? 'v-list-select-multiple' : '']
        }
      }"
      :required="props.required"
      :rules="rules"
    >
      <template v-for="(_, name) in $slots" #[name]="slotProps">
        <slot :name="name" v-bind="slotProps || {}" />
      </template>
    </VCombobox>
  </div>
</template>

//
<style lang="scss" scoped>
// .v-combobox {
//   .v-list-item {
//     padding: 0.5rem 1rem;
//     density: compact;
//   }
// }
//
</style>
