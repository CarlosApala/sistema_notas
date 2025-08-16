
import '../css/app.css';
import '/public/assets/css/AdminLTE.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js'; // incluye Popper
import 'bootstrap'

import { createPinia } from 'pinia';
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'; // (Opcional)


import FloatingVue from 'floating-vue'
import 'floating-vue/dist/style.css'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

const pinia = createPinia();
pinia.use(piniaPluginPersistedstate)
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(pinia)
            .use(plugin)
            .use(FloatingVue)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
