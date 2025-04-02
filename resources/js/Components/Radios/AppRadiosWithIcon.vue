<!--
  <script setup>
const radioContent = [
  {
    title: 'Starter',
    desc: 'For freelancers who work with multiple clients',
    value: 'starter',
    icon: {
      icon: 'tabler-rocket',
      size: '28',
    },
  },
  {
    title: 'Personal',
    desc: 'Join our talented community of talented digital agencies',
    value: 'personal',
    icon: {
      icon: 'tabler-star',
      size: '28',
    },
  },
  {
    title: 'Enterprise',
    desc: 'Team plan for free upto 15 seats',
    value: 'enterprise',
    icon: {
      icon: 'tabler-crown',
      size: '28',
    },
  },
]

const selectedRadio = ref('starter')
</script>

<template>
  <CustomRadiosWithIcon
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
      <VCol v-for="item in props.radioContent" :key="item.title" v-bind="gridColumn">
        <VLabel class="custom-input custom-radio-icon rounded cursor-pointer" :class="props.selectedRadio === item.value ? 'active' : ''">
          <slot :item="item">
            <div class="d-flex flex-column align-center text-center gap-2">
              <div>
                <VIcon v-bind="item.icon" class="text-high-emphasis" :color="props.selectedRadio === item.value ? 'primary' : ''" />
              </div>
              <h6 class="text-h6" :class="props.selectedRadio === item.value ? 'text-primary' : ''">
                {{ item.title }}
              </h6>
              <div>
                <p class="text-body-2 mb-0">{{ item.desc }}</p>
              </div>
            </div>
          </slot>

          <div>
            <VRadio :value="item.value" class="mb-0" />
          </div>
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

.v-label.custom-input.active {
  border-color: transparent;
  outline: 2px solid rgb(var(--v-theme-primary));
}

.v-label.custom-input:not(.active):hover {
  border-color: rgba(var(--v-border-color), 0.22);
}

.v-icon.text-high-emphasis {
  color: rgb(var(--v-theme-primary));
}

.custom-radio-icon {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;

  .v-radio {
    margin-block-end: -0.5rem;
  }
}
</style>
