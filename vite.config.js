import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
const path = require("path");

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/sass/app.scss",
                "resources/js/app.js",
                "resources/js/product/create.js",
                "resources/js/product/index.js",
                "resources/js/product/show.js",
                "resources/js/product/edit.js",
                "resources/js/coupon/index.js",
                "resources/js/cart/index.js",
                "resources/js/cart/checkout.js",
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            "@utilities": path.resolve(__dirname, "./resources/js/utilities"),
        },
    },
});
