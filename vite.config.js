import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
       
    ], css: {
            postcss: './postcss.config.js', // Путь к вашему файлу конфигурации postcss
          },
});
