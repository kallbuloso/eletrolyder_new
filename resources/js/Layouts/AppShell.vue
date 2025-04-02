<template>
  <FadeTransition>
    <slot />
  </FadeTransition>
  <!-- <app-modal /> -->
  <Modal />
</template>

<script setup>
import { Modal } from 'momentum-modal'

const toast = computed(() => {
  return usePage().props.toasts
})

const renderToasts = (toastsSource) => {
  const toasts = toastsSource
  if (Array.isArray(toasts)) {
    toasts.forEach((toas) => {
      swToast(toas.text, toas.type, toas.duration)
      //   console.log('Toasts Source: ', toas)
    })
  }
}

onMounted(() => {
  nextTick(() => {
    renderToasts(toast)
  })
})

watch(toast, (newToasts) => {
  renderToasts(newToasts)
})
</script>
