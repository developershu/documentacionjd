import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],

    server: {
        host: '0.0.0.0', // Permite que el servidor escuche en todas las interfaces de red
        hmr: {
            host: '172.22.117.159', // Especifica la dirección IP que usas para acceder
        },
        cors: true // Esto activa los encabezados CORS
    },
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
        }
    }
});

