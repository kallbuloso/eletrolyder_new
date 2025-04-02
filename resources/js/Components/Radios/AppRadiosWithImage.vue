<!--
  <script setup>
  import bg1 from '@images/pages/custom-radio-img-1.png'
  import bg2 from '@images/pages/custom-radio-img-2.png'
  import bg3 from '@images/pages/custom-radio-img-3.png'

  const radioContent = [
    {
      bgImage: bg1,
      value: 'basic',
    },
    {
      bgImage: bg2,
      value: 'premium',
    },
    {
      bgImage: bg3,
      value: 'enterprise',
    },
  ]

  const selectedRadio = ref('basic')
  </script>

  <template>
    <CustomRadiosWithImage
      v-model:selected-radio="selectedRadio"
      :radio-content="radioContent"
      :grid-column="{ sm: '4', cols: '12' }"
    />
  </template>

-->
<script setup>
const props = defineProps({
  selectedRadio: {
    type: String,
    required: true
  },
  radioContent: {
    type: Array,
    required: true
  },
  gridColumn: {
    type: null,
    required: false
  }
})

const emit = defineEmits(['update:selectedRadio'])

const updateSelectedOption = (value) => {
  if (value !== null) emit('update:selectedRadio', value)
}
</script>

<template>
  <VRadioGroup v-if="props.radioContent" :model-value="props.selectedRadio" class="custom-input-wrapper" @update:model-value="updateSelectedOption">
    <VRow>
      <VCol v-for="item in props.radioContent" :key="item.bgImage" v-bind="gridColumn">
        <VLabel class="custom-input custom-radio rounded cursor-pointer w-100" :class="props.selectedRadio === item.value ? 'active' : ''">
          <slot name="content" :item="item">
            <template v-if="typeof item.bgImage === 'object'">
              <Component :is="item.bgImage" class="custom-radio-image" />
            </template>
            <img v-else :src="item.bgImage" alt="bg-img" class="custom-radio-image" />
          </slot>

          <VRadio :id="`custom-radio-with-img-${item.value}`" :value="item.value" />
        </VLabel>

        <VLabel v-if="item.label || $slots.label" :for="`custom-radio-with-img-${item.value}`" class="cursor-pointer">
          <slot name="label" :label="item.label">
            {{ item.label }}
          </slot>
        </VLabel>
      </VCol>
    </VRow>
  </VRadioGroup>
</template>

<style lang="scss" scoped>
.custom-radio {
  position: relative;
  padding: 0 !important;

  .custom-radio-image {
    block-size: 100%;
    inline-size: 100%;
    min-inline-size: 100%;
  }

  .v-radio {
    position: absolute;
    inset-block-start: 0;
    inset-inline-end: 0;
    visibility: hidden;
  }

  &:hover,
  &.active {
    visibility: visible;
  }
}

.v-label.custom-input {
  border: 1px solid rgba(var(--v-border-color), var(--v-border-opacity));
  opacity: 0.35;
  white-space: normal;

  + .v-label {
    letter-spacing: normal;
  }

  &:hover {
    border-color: rgba(var(--v-border-color), 0.75);
  }

  &.active {
    border-color: transparent;
    outline: 3px solid rgb(var(--v-theme-primary));

    .v-radio {
      visibility: visible;
    }
  }
}
</style>
