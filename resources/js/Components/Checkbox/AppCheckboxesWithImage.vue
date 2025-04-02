<!--
  <script setup>
import bg1 from '@images/pages/custom-checkbox-img-1.png'
import bg2 from '@images/pages/custom-checkbox-img-2.png'
import bg3 from '@images/pages/custom-checkbox-img-3.png'

const checkboxContent = [
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

const selectedCheckbox = ref(['basic'])
</script>

<template>
  <CustomCheckboxesWithImage
    v-model:selected-checkbox="selectedCheckbox"
    :checkbox-content="checkboxContent"
    :grid-column="{ sm: '4', cols: '12' }"
  />
</template>
-->
<script setup>
const props = defineProps({
  selectedCheckbox: {
    type: Array,
    required: true
  },
  checkboxContent: {
    type: Array,
    required: true
  },
  gridColumn: {
    type: null,
    required: false
  }
})

const emit = defineEmits(['update:selectedCheckbox'])

const updateSelectedOption = (value) => {
  if (typeof value !== 'boolean' && value !== null) emit('update:selectedCheckbox', value)
}
</script>

<template>
  <VRow v-if="props.checkboxContent && props.selectedCheckbox" class="custom-input-wrapper">
    <VCol v-for="item in props.checkboxContent" :key="item.value" v-bind="gridColumn">
      <VLabel class="custom-input custom-checkbox rounded cursor-pointer w-100" :class="props.selectedCheckbox.includes(item.value) ? 'active' : ''">
        <div>
          <VCheckbox :id="`custom-checkbox-with-img-${item.value}`" :model-value="props.selectedCheckbox" :value="item.value" @update:model-value="updateSelectedOption" />
        </div>
        <img :src="item.bgImage" alt="bg-img" class="custom-checkbox-image" />
      </VLabel>

      <VLabel
        v-if="item.label || $slots.label"
        :for="`custom-checkbox-with-img-${item.value}`"
        class="cursor-pointer"
        :class="props.selectedCheckbox.includes(item.value) ? 'active' : ''"
      >
        <slot name="label" :label="item.label">
          {{ item.label }}
        </slot>
      </VLabel>
    </VCol>
  </VRow>
</template>

<style lang="scss" scoped>
.custom-checkbox {
  position: relative;
  padding: 0;

  .custom-checkbox-image {
    block-size: 100%;
    inline-size: 100%;
    min-inline-size: 100%;
  }

  .v-checkbox {
    position: absolute;
    inset-block-start: 0;
    inset-inline-end: 0;
    visibility: hidden;
  }

  &:hover,
  &.active {
    .v-checkbox {
      visibility: visible;
    }
  }
}

.v-label.custom-input.active {
  border-color: transparent;
  outline: 2px solid rgb(var(--v-theme-primary));
}

.v-label.custom-input:not(.active):hover {
  border-color: rgba(var(--v-border-color), 0.22);
}
</style>
