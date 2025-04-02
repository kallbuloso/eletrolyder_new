<template>
  <v-row>
    <v-col v-if="props.title" cols="12">
      <div>
        <p class="font-weight-medium"><v-icon v-if="props.icon" :icon="props.icon" /> {{ props.title }}</p>
        <v-divider />
      </div>
    </v-col>
    <!-- <v-col cols="3">
      <slot name="left" />
    </v-col> -->
    <v-col cols="12">
      <v-row>
        <slot />
      </v-row>
    </v-col>
  </v-row>
</template>

<script setup>
const props = defineProps({
  icon: {
    type: String,
    required: false
  },
  title: {
    type: String,
    required: false
  }
})
</script>
