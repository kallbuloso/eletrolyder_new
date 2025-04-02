<!--
<script setup>
  const radioContent = [
    {
      title: 'Basic',
      subtitle: 'Free',
      desc: 'Get 1 project with 1 team member.',
      value: 'basic',
    },
    {
      title: 'Premium',
      subtitle: '$45.80',
      value: 'premium',
      desc: 'Get 5 projects with 5 team members.',
    },
  ]

  const selectedRadio = ref('basic')
</script>

<template>
  <CustomRadios
    v-model:selected-radio="selectedRadio"
    :radio-content="radioContent"
    :grid-column="{ sm: '6', cols: '12' }"
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
  <VRadioGroup v-if="props.radioContent" :model-value="props.selectedRadio" @update:model-value="updateSelectedOption">
    <VRow>
      <VCol v-for="item in props.radioContent" :key="item.title" v-bind="gridColumn">
        <VLabel class="custom-input custom-radio rounded cursor-pointer" :class="props.selectedRadio === item.value ? 'active' : ''">
          <div class="mt-auto ml-1 my-auto">
            <VRadio :value="item.value" />
          </div>
          <slot :item="item">
            <div class="flex-grow-1">
              <div class="d-flex align-center">
                <h6 class="cr-title text-base" :class="props.selectedRadio === item.value ? 'text-primary' : ''">
                  {{ item.title }}
                </h6>
                <VSpacer />
                <span v-if="item.subtitle" class="text-disabled text-body-2">{{ item.subtitle }}</span>
              </div>
              <p class="text-body-2 mb-0">
                {{ item.desc }}
              </p>
            </div>
          </slot>
        </VLabel>
      </VCol>
    </VRow>
  </VRadioGroup>
</template>

<style lang="scss" scoped>
.v-label.custom-input {
  border: none;
  color: rgb(var(--v-theme-on-surface));
  outline: 1px solid rgba(var(--v-border-color), var(--v-border-opacity));
}
.custom-radio {
  display: flex;
  align-items: flex-start;
  gap: 0.25rem;

  .v-radio {
    margin-block-start: -0.45rem;
  }

  .cr-title {
    font-weight: 500;
    line-height: 1.375rem;
  }
}
.v-label.custom-input.active {
  border-color: transparent;
  outline: 2px solid rgb(var(--v-theme-primary));
}
</style>
