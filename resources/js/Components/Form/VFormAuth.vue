<script setup>
import authV1BottomShape from '@images/svg/auth-v1-bottom-shape.svg?raw'
import authV1TopShape from '@images/svg/auth-v1-top-shape.svg?raw'
</script>

<template>
  <div class="layout-blank">
    <div class="auth-wrapper d-flex align-center justify-center pa-6">
      <div class="position-relative my-sm-16">
        <!-- 👉 Top shape -->
        <VNodeRenderer :nodes="h('div', { innerHTML: authV1TopShape })" class="text-primary auth-v1-top-shape d-none d-sm-block" />

        <!-- 👉 Bottom shape -->
        <VNodeRenderer :nodes="h('div', { innerHTML: authV1BottomShape })" class="text-primary auth-v1-bottom-shape d-none d-sm-block" />

        <v-card class="auth-card" min-width="460" max-width="500" :class="$vuetify.display.smAndUp ? 'pa-2' : 'pa-0'">
          <VCardItem class="justify-center">
            <VCardTitle>
              <div class="app-logo d-flex">
                <Link href="/" as="a">
                  <ApplicationLogo style="height: 45" />
                </Link>
                <h1 class="auth-title mt-2 mx-3">
                  {{ $page.props.appName }}
                </h1>
              </div>
            </VCardTitle>
          </VCardItem>
          <v-card-text>
            <h4 class="text-h4 mt-0 mb-1">
              <slot name="title" />
            </h4>
            <p class="text-subtitle-2 mb-0">
              <slot name="description" />
            </p>
          </v-card-text>
          <slot />
        </v-card>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
.layout-blank {
  .auth-wrapper {
    min-block-size: 100dvh;
  }

  .auth-v1-top-shape,
  .auth-v1-bottom-shape {
    position: absolute;
  }

  .auth-footer-mask {
    position: absolute;
    inset-block-end: 0;
    min-inline-size: 100%;
  }

  .auth-card {
    z-index: 1 !important;
  }

  .auth-illustration {
    z-index: 1;
  }

  .auth-v1-top-shape {
    inset-block-start: -77px;
    inset-inline-start: -45px;
  }

  .auth-v1-bottom-shape {
    inset-block-end: -58px;
    inset-inline-end: -58px;
  }

  @media (min-width: 1264px), (max-width: 959px) and (min-width: 450px) {
    .v-otp-input .v-otp-input__content {
      gap: 1rem;
    }
  }
}

@media (min-width: 1264px), (max-width: 959px) and (min-width: 450px) {
  .v-otp-input .v-otp-input__content {
    gap: 1rem;
  }
}

@media (min-width: 960px) {
  .skin--bordered {
    .auth-card-v2 {
      border-inline-start: 1px solid rgba(var(--v-border-color), var(--v-border-opacity)) !important;
    }
  }
}

.auth-logo {
  position: absolute;
  z-index: 2;
  inset-block-start: 2rem;
  inset-inline-start: 2.3rem;
}

.auth-title {
  font-size: 1.375rem;
  font-weight: 700;
  letter-spacing: 0.25px;
  line-height: 1.5rem;
  text-transform: capitalize;
}
</style>
