<template>
  <v-dialog v-model="show" :theme="theme" :width="width" persistent @after-leave="redirect">
    <AppDialogCloseBtn @click="show = false" />
    <slot />
  </v-dialog>
</template>

<script setup>
import { useModal } from 'momentum-modal'
import { useThemeStore } from '@/Stores/themeStore'

defineProps({
  width: {
    type: String,
    default: '500'
  }
})

const { show, redirect } = useModal()

const themeStore = useThemeStore()

const theme = computed(() => {
  return themeStore.themeMode
})
</script>
