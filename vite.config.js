import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/sass/app.scss",
                "resources/js/app.js",
                "resources/js/product/create.js",
                "resources/js/product/index.js",
                "resources/js/product/edit.js",
            ],
            // refresh: true,
        }),
    ],
});
