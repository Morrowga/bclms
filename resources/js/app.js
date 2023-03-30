import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { Ziggy } from './ziggy';
import PrimeVue from "primevue/config";

/***
 * configure lib
 *
 *
 */
// vue good table plugin
import VueGoodTablePlugin from "vue-good-table-next";
import { VueGoodTable } from "vue-good-table-next";

//primevue-components
import Button from 'primevue/button';
import Image from 'primevue/image';
import Card from 'primevue/card';
import Divider from 'primevue/divider';
import InputText from 'primevue/inputtext';
import Sidebar from 'primevue/sidebar';
import Dialog from 'primevue/dialog';
import PanelMenu from 'primevue/panelmenu';
import Accordion from 'primevue/accordion';
import AccordionTab from 'primevue/accordiontab';
import DataTable  from 'primevue/datatable';
import Column from 'primevue/column';
import IconButton from "@Composables/IconButton.vue";
import AddIcon from "@Composables/icons/AddIcon.vue";
import Badge from 'primevue/badge';
import Message from 'primevue/message';
import Menu from 'primevue/menu';
import Avatar from "primevue/avatar"
import BadgeDirective from 'primevue/badgedirective';
import DataView from 'primevue/dataview';
import DataViewLayoutOptions from 'primevue/dataviewlayoutoptions'   // optional
import Fieldset from 'primevue/fieldset';

import { Link, usePage } from "@inertiajs/vue3";
import OverlayPanel from 'primevue/overlaypanel';
//this is popup
import Toast from 'primevue/toast';
import ToastService from 'primevue/toastservice';

// confirm dialog

import ConfirmDialog from 'primevue/confirmdialog';
import ConfirmationService from 'primevue/confirmationservice';





//core
import "primevue/resources/primevue.min.css";
import "primeicons/primeicons.css";
import "animate.css";
import "vue-good-table-next/dist/vue-good-table-next.css";
import "primevue/resources/themes/lara-light-indigo/theme.css"


// import Button from "primevue/button

createInertiaApp({
    resolve: async (name) => {
        console.log(name)
        let page = null;
        let isModule=name.split("::");
        if (isModule.length > 1){
            let module =  isModule[0];
            let pathTo = isModule[1];
            page = await import(`../../src/${module}/${pathTo}.vue`,{
                /* @vite-ignore */
                eager: true,
            })
        }else{

        }
        return page.default;
    },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(VueGoodTablePlugin)
      .use(Ziggy)
      .use(PrimeVue)
      .use(ToastService)
      .use(Toast)
      .use(ConfirmDialog)
      .use(ConfirmationService)
      .mixin({
        methods:{route},
        components:
        { VueGoodTable,Button, Image, Card,
          Divider,InputText, PanelMenu, Accordion,Badge,Sidebar,Dialog,Menu,Avatar,
          AccordionTab,DataTable,Column,OverlayPanel,DataView,DataViewLayoutOptions,Message,Fieldset,IconButton,
          Link,usePage,AddIcon,Toast,ConfirmDialog}})
      .mount(el)
  },
})
