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

//plugin
import { abilitiesPlugin } from '@casl/vue'
// vue good table plugin
import VueGoodTablePlugin from "vue-good-table-next";
import { VueGoodTable } from "vue-good-table-next";

//scss group
import '@core-scss/template/index.scss'
import '@styles/styles.scss'
import "vue-good-table-next/dist/vue-good-table-next.css";

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
      .use(VueGoodTablePlugin)
      .use(i18n)
      .use(abilitiesPlugin, ability, {
        useGlobalProperties: true,
      })
      .mixin({
        methods:{route},
      components:{
        VueGoodTable
      }
      })
      .mount(el);
  },
})

