// https://vitejs.dev/config/
import { fileURLToPath, URL } from 'node:url';
import { PrimeVueResolver } from '@primevue/auto-import-resolver';
import vue from '@vitejs/plugin-vue';
import Components from 'unplugin-vue-components/vite';
import { defineConfig, loadEnv } from 'vite';

export default ({ mode }) => {
    Object.assign(process.env, loadEnv(mode, process.cwd()))
    return defineConfig({
        optimizeDeps: {
            //noDiscovery: true
        },
        plugins: [
            vue(),
            Components({
                resolvers: [PrimeVueResolver()]
            })
        ],
        resolve: {
            alias: {
                '@': fileURLToPath(new URL('./src', import.meta.url)),
                'src': fileURLToPath(new URL('./src', import.meta.url)),
            }
        },
        server: {
            open: true,
            port: parseInt(process.env.VITE_PORT)
        },
        css: {
            preprocessorOptions: {
                scss: {
                    api: 'modern-compiler', // or "modern", "legacy"
                    // silenceDeprecations: ["legacy-js-api"]
                },
            },
        }
    });
}


