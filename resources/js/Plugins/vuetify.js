import '../../css/app.css'
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'
import '@core-scss/template/libs/vuetify/index.scss'
import '@styles/@core/base/_index.scss'

import { h } from 'vue'

import { createVuetify } from 'vuetify'
import { VBtn } from 'vuetify/components/VBtn'
import { aliases, mdi } from 'vuetify/iconsets/mdi'
import Iconify from '@iconify/iconify'
import themes from './theme'
import defaults from './defaults'
import pt from './i18n/pt'

const customIconifySet = {
  component: (props) => {
    return h('span', {
      class: 'iconify',
      'data-icon': props.icon,
      'data-inline': 'false'
    })
  }
}

const vuetify = createVuetify({
  ssr: true,
  theme: { themes },
  aliases: {
    IconBtn: VBtn
  },
  locale: {
    locale: 'pt',
    fallback: 'tp',
    messages: { pt }
  },
  //   components: {
  //     ...components,
  //     ...labsComponents
  //   },
  directives: {
    // ...directives,
    // focus: {
    //   // definição da diretiva
    //   // mounted(element, binding) {
    //   //   binding.instance.$nextTick(() => element.focus())
    //   // }
    //   inserted: function (el) {
    //     el.focus()
    //   }
    // }
  },
  defaults,
  icons: {
    defaultSet: 'mdi',
    aliases: {
      ...aliases,
      Iconify
    },
    sets: {
      mdi,
      iconify: customIconifySet
    }
  }
})

export default vuetify
