<script setup>
import { useThemeStore } from '@/Stores/themeStore'
const themeStore = useThemeStore()
</script>

<template>
  <v-app :theme="themeStore.themeMode">
    <v-main>
      <v-container fluid>
        <slot />
      </v-container>
    </v-main>
  </v-app>
</template>
