<script setup>
import { useGoTo } from 'vuetify'

const goTo = useGoTo()
const fab = ref(false)
const onScroll = (e) => {
  fab.value = window.scrollY > 150
}

// const toTop = () => {
//   goTo(0)
// }
</script>

<template>
  <VScaleTransition name="app-transition-zoom-fade" style="transform-origin: center">
    <IconBtn v-show="fab" v-scroll="onScroll" :ripple="false" class="scroll-to-top d-print-none" color="primary" @click="goTo(0)">
      <VIcon size="22" icon="$collapse" />
    </IconBtn>
  </VScaleTransition>
</template>

<style lang="scss">
.scroll-to-top {
  position: fixed !important;

  // To keep button on top of v-layout. E.g. Email app
  z-index: 999;
  inset-block-end: 2%;
  inset-inline-end: 20px;
}
</style>
