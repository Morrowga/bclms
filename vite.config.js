import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import dynamicImport from 'vite-plugin-dynamic-import'
const path = require('path')

export default defineConfig({
    resolve:{
        alias:{
            "@Composables": path.resolve(__dirname , "./src/Common/Layouts/Composables"),
            "@Layouts": path.resolve(__dirname , "./src/Common/Layouts"),
            "@dashboard" : path.resolve(__dirname,'./src/Common/Layouts/Dashboard'),
            "@" : path.resolve(__dirname,"./src")
        }
    },

    plugins: [
        dynamicImport(),
        vue(),
        laravel({
            input: ["resources/js/app.js",'resources/css/app.css',],
            // ssr: 'resources/js/ssr.js',
            refresh: true,
        }),
    ],
});
