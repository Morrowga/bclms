import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { Ziggy } from './ziggy';
import Swal from 'sweetalert2';
/* eslint-disable import/order */
// import '@/@fake-db/db'
import '@/@iconify/icons-bundle'
import ability from '@/plugins/casl/ability'
import i18n from '@/plugins/i18n'
import layoutsPlugin from '@/plugins/layouts'
import vuetify from '@/plugins/vuetify'

import { abilitiesPlugin } from '@casl/vue'

//scss group
import '@core-scss/template/index.scss'
import '@styles/styles.scss'

// loadFonts()
//this is popup

window.Swal = Swal;
// confirm dialog
import pages from './route';
//core

// import Button from "primevue/button
createInertiaApp({
    resolve: async (name) => {
        return pages[name];
    },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(Ziggy)
      .use(vuetify)
      .use(layoutsPlugin)
      .use(i18n)
      .use(abilitiesPlugin, ability, {
        useGlobalProperties: true,
      })
      .mixin({
        methods:{route},})
      .mount(el);
  },
})

