<template>
  <v-breadcrumbs :items="items">
    <template #title="{ item }">
      <Link v-if="!item.disabled" :href="item.href" class="v-breadcrumbs-item--link">
        {{ item.title }}
      </Link>
      <span v-else>{{ item.title }}</span>
    </template>
  </v-breadcrumbs>
</template>

<script>
export default {
  name: 'AppBreadcrumbs',
  props: {
    items: {
      type: Array,
      required: true
    }
  }
}
</script>
