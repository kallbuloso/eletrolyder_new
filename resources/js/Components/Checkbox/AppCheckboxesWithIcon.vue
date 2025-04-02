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
  <CustomCheckboxesWithIcon
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
    <VCol v-for="item in props.checkboxContent" :key="item.title" v-bind="gridColumn">
      <VLabel class="custom-input custom-checkbox-icon rounded cursor-pointer" :class="props.selectedCheckbox.includes(item.value) ? 'active' : ''">
        <slot :item="item">
          <div class="d-flex flex-column align-center text-center gap-2">
            <VIcon v-bind="item.icon" class="text-high-emphasis" :color="props.selectedCheckbox.includes(item.value) ? 'active' : ''" />

            <h6 class="cr-title text-base">
              {{ item.title }}
            </h6>
            <p v-if="item.desc" class="text-sm clamp-text mb-0">
              {{ item.desc }}
            </p>
          </div>
        </slot>
        <div>
          <VCheckbox :model-value="props.selectedCheckbox" :value="item.value" @update:model-value="updateSelectedOption" />
        </div>
      </VLabel>
    </VCol>
  </VRow>
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
