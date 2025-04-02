import { createInertiaApp } from '@inertiajs/vue3'
import { createPinia } from 'pinia'
import createServer from '@inertiajs/vue3/server'
import { renderToString } from '@vue/server-renderer'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { createSSRApp, h } from 'vue'
import { ZiggyVue } from '../../vendor/tightenco/ziggy'
import piniaPluginPersist from 'pinia-plugin-persist'
import axios from './Plugins/axios'
import vuetify from './Plugins/vuetify'
import { modal } from 'momentum-modal'
import { staticPrimaryColor } from '@/Plugins/theme'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'

createServer((page) =>
  createInertiaApp({
    page,
    render: renderToString,
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ App, props, plugin }) {
      return createSSRApp({ render: () => h(App, props) })
        .use(createPinia().use(piniaPluginPersist))
        .use(vuetify)
        .use(modal, {
          resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue'))
        })
        .use(axios)
        .use(plugin)
        .use(ZiggyVue, {
          ...page.props.ziggy,
          location: new URL(page.props.ziggy.location)
        })
    },
    progress: {
      // The delay after which the progress bar will appear, in milliseconds...
      delay: 150,
      // The color of the progress bar...
      color: staticPrimaryColor,
      // Whether to include the default NProgress styles...
      includeCSS: true,
      // Whether the NProgress spinner will be shown...
      showSpinner: false
    }
  })
)
