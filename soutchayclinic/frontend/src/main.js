import { createPinia } from 'pinia';
import { createApp } from 'vue';
import App from 'src/App.vue';
import Router from 'src/router';

import PrimeTheme from '@primevue/themes/aura';
import { definePreset } from '@primevue/themes';
import PrimeVue from 'primevue/config';
import ConfirmationService from 'primevue/confirmationservice';
import ToastService from 'primevue/toastservice';

import { useAppStore } from 'src/store/app';
import { useStorageService } from 'src/services/storage';
import { useApiService } from 'src/services/api';
import { useAppMenus } from 'src/menus';
import { $t, i18n } from 'src/services/i18n';
import { utils } from 'src/utils';

import 'src/assets/styles.scss';
import 'src/assets/tailwind.css';

(async () => {
    const app = createApp(App);

    // setup app theme
    const themePreset = definePreset(PrimeTheme, {
        semantic: {
            primary:{
                50: '{indigo.50}',
                100: '{indigo.100}',
                200: '{indigo.200}',
                300: '{indigo.300}',
                400: '{indigo.400}',
                500: '{indigo.500}',
                600: '{indigo.600}',
                700: '{indigo.700}',
                800: '{indigo.800}',
                900: '{indigo.900}',
                950: '{indigo.950}'
            },
            colorScheme: {
                light: {
                    surface: {
                        0: '#ffffff',
                        50: '{slate.50}',
                        100: '{slate.100}',
                        200: '{slate.200}',
                        300: '{slate.300}',
                        400: '{slate.400}',
                        500: '{slate.500}',
                        600: '{slate.600}',
                        700: '{slate.700}',
                        800: '{slate.800}',
                        900: '{slate.900}',
                        950: '{slate.950}'
                    }
                },
                dark: {
                    surface: {
                        0: '#ffffff',
                        50: '{slate.50}',
                        100: '{slate.100}',
                        200: '{slate.200}',
                        300: '{slate.300}',
                        400: '{slate.400}',
                        500: '{slate.500}',
                        600: '{slate.600}',
                        700: '{slate.700}',
                        800: '{slate.800}',
                        900: '{slate.900}',
                        950: '{slate.950}'
                    }
                }
            }
        }
    });

    app.use(PrimeVue, {
        ripple: true,
        locale: i18n.messages,
        theme: {
            preset: themePreset,
            options: {
                prefix: 'p',
                darkModeSelector: '.app-dark'
            }
        }
    });

    app.use(ConfirmationService);
    app.use(ToastService);

    /*
        init pinia store (appStore and pageStore)
        appStore holds global application state
        pageStore holds each page specific state
    */
    const pinia = createPinia();
    app.use(pinia);

    //make app name available in any component
    app.config.globalProperties.$appName = import.meta.env.VITE_APP_NAME;

    //app api base url e.g http://localhost:8060/
    app.config.globalProperties.$apiUrl = import.meta.env.VITE_APP_API_URL;

    /*
        app api path. e.g http://localhost:8060/api/
        include trailing slash
        for production publish, change this value from .env
    */
    app.config.globalProperties.$apiPath = import.meta.env.VITE_APP_API_PATH;

    //axios api service use for making api request
    const apiService = useApiService();
    apiService.init();
    app.config.globalProperties.$apiService = apiService;

    //save data to localstorage
    app.config.globalProperties.$localStore = useStorageService();

    //all application menu
    app.config.globalProperties.$menus = useAppMenus();

    //utility functions
    app.config.globalProperties.$utils = utils;

    //locale translation
    app.config.globalProperties.$i18n = i18n;
    app.config.globalProperties.$t = $t;

    

    /*
         init router after services and properties are initialized
         this helps to access services from router
    */
    const router = Router();
    app.use(router);

    const appStore = useAppStore();
    router.beforeEach((to, from, next) => {
        appStore.closeDialogs(); // close any open dialogs before navigating to a new route
        next(); // continue to the next route
    });

    app.mount('#app');

})();
