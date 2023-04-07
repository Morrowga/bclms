import { fileURLToPath } from 'url'
import VueI18nPlugin from '@intlify/unplugin-vue-i18n/vite'
import vue from '@vitejs/plugin-vue'
import AutoImport from 'unplugin-auto-import/vite'
import Components from 'unplugin-vue-components/vite'
import DefineOptions from 'unplugin-vue-define-options/vite'
import { defineConfig } from 'vite'
import vuetify from 'vite-plugin-vuetify'
import laravel from 'laravel-vite-plugin'
// https://vitejs.dev/config/
export default defineConfig({
  plugins: [
    laravel({
  input: ['resources/js/app.js'],
  refresh: true,
}),
    vue({
  template: {
    compilerOptions: {
        isCustomElement: (tag) => ['Vlabel'].includes(tag),
      },
      transformAssetUrls: {
          base: null,
          includeAbsolute: false,
      },
  },
}),
    // https://github.com/vuetifyjs/vuetify-loader/tree/next/packages/vite-plugin
    vuetify({
      styles: {
        configFile: './src/Common/UI/styles/variables/_vuetify.scss',
      },
    }),
    Components({
      dirs: ['./src/Common/UI/js/@core/components', './src/Common/UI/js/views/demos'],
      dts: true,
    }),
    AutoImport({
      eslintrc: {
        enabled: true,
        filepath: './.eslintrc-auto-import.json',
      },
      imports: ['vue', 'vue-router', '@vueuse/core', '@vueuse/math', 'vue-i18n', 'pinia'],
      vueTemplate: true,
    }),
    VueI18nPlugin({
      runtimeOnly: true,
      compositionOnly: true,
      include: [
        fileURLToPath(new URL('./resources/js/plugins/i18n/locales/**', import.meta.url)),
      ],
    }),
    DefineOptions(),
  ],
  define: { 'process.env': {} },
  resolve: {
    alias: {
      "@AppRoot":fileURLToPath(new URL("./resources/js", import.meta.url)),
      "@Composables":fileURLToPath(new URL("./src/Common/Layouts/Composables", import.meta.url)),
      "@Layouts": fileURLToPath(new URL("./src/Common/Layouts", import.meta.url)),
      "@dashboard" : fileURLToPath(new URL("./src/Common/Layouts/Dashboard", import.meta.url)),
      '@core-scss': fileURLToPath(new URL('./src/Common/UI/styles/@core', import.meta.url)),
      '@': fileURLToPath(new URL('./src/Common/UI/js', import.meta.url)),
      '@themeConfig': fileURLToPath(new URL('./themeConfig.js', import.meta.url)),
      '@core': fileURLToPath(new URL('./src/Common/UI/js/@core', import.meta.url)),
      '@layouts': fileURLToPath(new URL('./src/Common/UI/js/@layouts', import.meta.url)),
      '@images': fileURLToPath(new URL('./src/Common/UI/images/', import.meta.url)),
      '@styles': fileURLToPath(new URL('./src/Common/UI/styles/', import.meta.url)),
      '@configured-variables': fileURLToPath(new URL('./src/Common/UI/styles/variables/_template.scss', import.meta.url)),
      '@axios': fileURLToPath(new URL('./src/Common/UI/js/plugins/axios', import.meta.url)),
      '@validators': fileURLToPath(new URL('./src/Common/UI/js/@core/utils/validators', import.meta.url)),
      'apexcharts': fileURLToPath(new URL('node_modules/apexcharts-clevision', import.meta.url)),
    },
  }
})
