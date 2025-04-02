<script setup>
const props = defineProps({
  icon: {
    type: String,
    required: false,
    default: 'mdi-close'
  },
  iconSize: {
    type: String,
    required: false,
    default: '20'
  }
})
</script>

<template>
  <IconBtn v-tooltip="'Fechar'" variant="elevated" size="30" :ripple="false" class="v-dialog-close-btn bg-background">
    <VIcon :icon="props.icon" :size="props.iconSize" />
  </IconBtn>
</template>
