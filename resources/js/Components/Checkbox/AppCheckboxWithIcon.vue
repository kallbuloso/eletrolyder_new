<!--
  <script setup>
  const checkboxContent = [
    {
      title: 'Backup',
      desc: 'Backup every file from your project.',
      value: 'backup',
      icon: {
        icon: 'mdi-server',
        size: '28',
      },
    },
    {
      title: 'Encrypt',
      desc: 'Translate your data to encrypted text.',
      value: 'encrypt',
      icon: {
        icon: 'tabler-ban',
        size: '28',
      },
    },
    {
      title: 'Site Lock',
      desc: 'Security tool to protect your website.',
      value: 'site-lock',
      icon: {
        icon: 'tabler-lock',
        size: '28',
      },
    },
  ]

const selectedCheckbox = ref(['backup'])
</script>

<template>
  <AppCheckboxesWithIcon
    v-model:selected-checkbox="selectedCheckbox"
    :checkbox-content="checkboxContent"
    :grid-column="{ sm: '4', cols: '12' }"
  />
</template>

-->
<script setup>
const props = defineProps({
  modelValue: {
    type: Boolean,
    default: false,
    required: false
  },
  title: {
    type: String,
    required: false,
    default: 'Title'
  },
  desc: {
    type: String,
    required: false,
    default: 'Descrição'
  },
  icon: {
    type: Object,
    required: false,
    default: () => ({
      icon: 'mdi-server',
      size: '28'
    })
  }
})

const emit = defineEmits(['update:modelValue'])

const checked = computed({
  get: () => props.modelValue,
  set: (checked) => {
    emit('update:modelValue', checked)
  }
})
</script>

<template>
  <VLabel class="custom-input custom-checkbox-icon rounded cursor-pointer" :class="checked ? 'active' : ''">
    <div class="d-flex flex-column align-center text-center gap-2">
      <v-icon v-bind="props.icon" class="text-high-emphasis" :color="checked ? 'active' : ''" />
      <h6 class="cr-title text-base">{{ props.title }}</h6>
      <p class="text-sm clamp-text mb-0">{{ props.desc }}</p>
    </div>
    <div>
      <VCheckbox v-model="checked" />
    </div>
  </VLabel>
  <!-- <pre>{{ checked }}</pre> -->
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

.custom-checkbox-icon {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;

  .v-checkbox {
    margin-block-end: -0.375rem;

    .v-selection-control__wrapper {
      margin-inline-start: 0;
    }
  }

  .cr-title {
    font-weight: 500;
    line-height: 1.375rem;
  }
}
</style>
