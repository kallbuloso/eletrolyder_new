<script setup>
import { useThemeStore } from '@/Stores/themeStore'

const themeStore = useThemeStore()
const toggleDrawer = () => {
  themeStore.toggleDrawer()
}
const toggleTheme = () => {
  themeStore.toggleTheme()
}

onMounted(() => {
  // TODO: Adicionar responsividade mobile
  // https://vuetifyjs.com/en/features/display-and-platform/#interface
})
</script>

<template>
  <v-app :theme="themeStore.themeMode">
    <!-- Navigation drawer -->
    <v-navigation-drawer v-model="themeStore.isOpen">
      <!-- Logo and app name -->
      <v-list class="ml-1 bg-background">
        <v-list-item>
          <template #prepend>
            <v-icon>
              <Link href="/" as="a">
                <ApplicationLogo style="height: 35" />
              </Link>
            </v-icon>
          </template>
          <v-list-item-title>{{ $page.props.appName }}</v-list-item-title>
          <v-list-item-subtitle>{{ $page.props.auth.user.name }}</v-list-item-subtitle>
        </v-list-item>
      </v-list>
      <!-- Navigation links -->
      <app-navigation />
    </v-navigation-drawer>
    <!-- App bar -->
    <v-app-bar class="bg-background">
      <template #prepend>
        <v-app-bar-nav-icon @click.stop="toggleDrawer">
          <i-ri-menu-unfold-4-line-2 v-if="themeStore.isOpen" />
          <i-ri-menu-unfold-3-line-2 v-else />
        </v-app-bar-nav-icon>
      </template>
      <v-app-bar-title>
        <v-list class="bg-background" lines="one">
          <v-list-item>
            <v-list-item-title class="ml-1">{{ $page.props.title }}</v-list-item-title>
            <v-list-item-subtitle v-if="$page.props.breadcrumbs" class="mb-0">
              <app-breadcrumbs :items="$page.props.breadcrumbs" class="pa-0" />
            </v-list-item-subtitle>
          </v-list-item>
        </v-list>
      </v-app-bar-title>
      <v-spacer />
      <v-btn icon class="mr-4" @click.stop="toggleTheme">
        <i-line-md-light-dark-loop />
      </v-btn>
    </v-app-bar>
    <!-- Main content -->
    <v-main>
      <!-- Page content -->
      <v-container>
        <!-- Page title -->
        <Head :title="$page.props.title" />
        <slot />
        <scroll-to-top />
        <!-- Footer -->
        <app-footer />
      </v-container>
    </v-main>
  </v-app>
</template>
