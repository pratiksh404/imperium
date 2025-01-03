import './bootstrap';
import '../css/app.css';
import 'primeicons/primeicons.css';

import { createApp, h } from 'vue';
import { createInertiaApp, Head, Link } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

import { createPinia } from 'pinia'

import PrimeVue from 'primevue/config';
import ToastService from 'primevue/toastservice';
import ConfirmationService from 'primevue/confirmationservice';
import Tooltip from 'primevue/tooltip';
import FocusTrap from 'primevue/focustrap';

import customThemePreset from '@/theme-preset.js';
import { useDark } from '@vueuse/core';

import Container from './Components/Container.vue';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
const darkMode = useDark(); // set Light/Dark Mode

// App Layout
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const pinia = createPinia()

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue')
        ).then((page) => {
            // Set the default layout if not explicitly defined
            if (name.startsWith('Admin/')) {
                page.default.layout = page.default.layout || AuthenticatedLayout;
            }
            return page;
        }),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .provide('darkMode', darkMode)
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(pinia)
            .use(PrimeVue, {
                theme: customThemePreset,
            })
            .use(ToastService)
            .use(ConfirmationService)
            .component('Head', Head)
            .component('Link', Link)
            .component('Container', Container)
            .directive('tooltip', Tooltip)
            .directive('focustrap', FocusTrap)
            .mount(el);
    },
    progress: {
        color: 'var(--p-primary-500)',
    },
});
