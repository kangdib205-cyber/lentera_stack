import { createApp } from 'vue';
import App from './App.vue';

const rootEl = document.getElementById('app');
if (rootEl) {
    const app = createApp(App, {
        laravelVersion: rootEl.dataset.laravelVersion,
        phpVersion: rootEl.dataset.phpVersion
    });
    app.mount('#app');
}
