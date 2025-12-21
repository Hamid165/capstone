import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true, // Pastikan ini tetap true
        }),
        tailwindcss(),
    ],
    server: {
        // Tambahkan block host ini:
        host: "127.0.0.1",
        watch: {
            ignored: ["**/storage/framework/views/**"],
        },
    },
});
