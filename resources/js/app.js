import '../css/app.css'
import './bootstrap'

import { createInertiaApp } from '@inertiajs/vue3'
import { createPinia } from 'pinia'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { createApp, h } from 'vue'
import { ZiggyVue } from '../../vendor/tightenco/ziggy'
import piniaPluginPersist from 'pinia-plugin-persist'
import axios from './Plugins/axios'
import vuetify from './Plugins/vuetify'
import { modal } from 'momentum-modal'
import { staticPrimaryColor } from '@/Plugins/theme'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    return createApp({ render: () => h(App, props) })
      .use(createPinia().use(piniaPluginPersist))
      .use(modal, {
        resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue'))
      })
      .use(axios)
      .use(vuetify)
      .use(plugin)
      .use(ZiggyVue)
      .mount(el)
  },
  progress: {
    color: staticPrimaryColor
  }
})
