import { breakpointsVuetify } from '@vueuse/core'
import { VIcon } from 'vuetify/components'

// ❗ Logo SVG must be imported with ?raw suffix
import logo from '@images/logo.svg?raw'
import { defineThemeConfig } from '@core'
import { RouteTransitions, Skins } from '@core/enums'
import { AppContentLayoutNav, ContentWidth, FooterType, NavbarType } from '@layouts/enums'


var themsCustomize = JSON.parse(localStorage.getItem("site_theme"));

export const { themeConfig, layoutConfig } = defineThemeConfig({

  app: {
    title: 'Blended Concept',
    // ❗ if you have SVG logo and want it to adapt according to theme color, you have to apply color as `color: rgb(var(--v-global-theme-primary))`
    logo: h('div', { innerHTML: logo, style: 'line-height:0; color: rgb(var(--v-global-theme-primary))' }),
    contentWidth: themsCustomize?.content_with ?? ContentWidth.Boxed,
    contentLayoutNav: AppContentLayoutNav.Horizontal,
    overlayNavFromBreakpoint: breakpointsVuetify.md + 16,
    enableI18n: false,
    theme: themsCustomize?.themes ?? 'light',
    isRtl: false,
    skin:themsCustomize?.skins ?? 'default',
    routeTransition: RouteTransitions.Fade,
    iconRenderer: VIcon,
  },
  navbar: {
    type:themsCustomize?.header_type ?? NavbarType.Sticky,
    navbarBlur: true,
  },
  footer: { type: themsCustomize?.footer_type ??  FooterType.Static },
  verticalNav: {
    isVerticalNavCollapsed: false,
    defaultNavItemIconProps: { icon: 'mdi-circle' },
    isVerticalNavSemiDark: false,
  },
  horizontalNav: {
    type: 'sticky',
    transition: 'slide-y-reverse-transition',
  },
  icons: {
    chevronDown: { icon: 'mdi-chevron-down' },
    chevronRight: { icon: 'mdi-chevron-right' },
    close: { icon: 'mdi-close' },
    verticalNavPinned: { icon: 'custom-vertical-nav-header-arrow', size: 22 },
    verticalNavUnPinned: { icon: 'custom-vertical-nav-header-arrow', size: 22 },
    sectionTitlePlaceholder: { icon: 'mdi-minus' },
  },
})
