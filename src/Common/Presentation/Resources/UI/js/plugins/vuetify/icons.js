import { Icon } from '@iconify/vue'
import { aliases } from 'vuetify/lib/iconsets/mdi'
import { fa } from 'vuetify/iconsets/fa4'

const alertTypeIcon = {
  success: 'mdi-check-circle-outline',
  info: 'mdi-information-outline',
  warning: 'mdi-alert-outline',
  error: 'mdi-alert-circle-outline',
}

// const modifiedAliases = Object.assign(aliases, alertTypeIcon)
export const iconify = {
  component: props => h(Icon, props),
}
export const icons = {
  defaultSet: 'iconify',
  aliases,
  sets: {
    iconify,
    fa
  },
}
