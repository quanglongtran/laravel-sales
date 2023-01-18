import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
const path = require("path");

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // global
                "resources/sass/app.scss",
                "resources/js/app.js",

                // client side
                "resources/js/client/cart/index.js",
                "resources/js/client/cart/checkout.js",
                "resources/js/client/order/index.js",
                "resources/js/client/product/show.js",

                // admin side
                "resources/js/admin/order/index.js",
                "resources/js/admin/user/index.js",
                "resources/js/admin/category/index.js",
                "resources/js/admin/coupon/index.js",
                "resources/js/admin/product/index.js",
                "resources/js/admin/product/create.js",
                "resources/js/admin/product/edit.js",
                "resources/js/admin/role/index.js",
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            "@utilities": path.resolve(__dirname, "./resources/js/utilities"),
            "@config": path.resolve(__dirname, "./resources/js/config"),
        },
    },
});
