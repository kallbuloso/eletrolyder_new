<template>
  <VLabel class="custom-input custom-checkbox rounded" :class="[isChecked ? 'active' : '', !props.disabled ? 'cursor-pointer' : '']" :disabled="props.disabled">
    <div>
      <VCheckbox :model-value="isChecked" :disabled="props.disabled" :true-icon="props.trueIcon" :false-icon="props.falseIcon" @update:model-value="updateSelectedOption" />
    </div>
    <div class="flex-grow-1">
      <div class="d-flex align-center">
        <h6 class="cr-title text-base">{{ title }}</h6>
        <VSpacer v-if="subtitle" />
        <span v-if="subtitle" class="text-body-2" :class="isChecked ? 'text-primary' : 'text-disabled'">{{ subtitle }}</span>
      </div>
      <p v-if="desc" class="text-sm mb-0">{{ desc }}</p>
    </div>
  </VLabel>
</template>

<script setup>
const props = defineProps({
  modelValue: {
    type: Boolean,
    required: true
  },
  title: {
    type: String,
    required: true
  },
  subtitle: {
    type: String,
    required: false
  },
  desc: {
    type: String,
    required: false
  },
  trueIcon: {
    type: String,
    default: 'mdi-check'
  },
  falseIcon: {
    type: String,
    default: 'mdi-close'
  },
  disabled: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['update:modelValue'])

const isChecked = computed({
  get: () => props.modelValue,
  set: (value) => emit('update:modelValue', value)
})

const updateSelectedOption = (value) => {
  isChecked.value = value
}
</script>

<style lang="scss" scoped>
.v-label.custom-input {
  border: none;
  color: rgb(var(--v-theme-on-surface));
  outline: 1px solid rgba(var(--v-border-color), var(--v-border-opacity));
}
.custom-checkbox {
  display: flex;
  align-items: flex-start;
  gap: 0.5rem;

  .v-checkbox {
    margin-block-start: -0.375rem;
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

.v-label.custom-input:not(.active):hover {
  border-color: rgba(var(--v-border-color), 0.22);
}
</style>
