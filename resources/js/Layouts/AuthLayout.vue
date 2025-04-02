<script setup>
import { useThemeStore } from '@/Stores/themeStore'
const themeStore = useThemeStore()
</script>

<template>
  <v-app :theme="themeStore.themeMode">
    <slot />
  </v-app>
</template>
