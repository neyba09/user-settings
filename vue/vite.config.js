import { fileURLToPath, URL } from "node:url";
import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';

// https://vitejs.dev/config/
export default defineConfig({
    plugins: [vue()],
    //fix reload config
    server: {
        watch: {
            usePolling: true,
        },
        port: 5173,
        host: '0.0.0.0', // важно для доступа снаружи контейнера
    },
    resolve: {
        alias: [
            { find: '@', replacement: fileURLToPath(new URL('./src', import.meta.url)) },
        ],
    }
});
