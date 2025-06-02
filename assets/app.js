import { createApp } from 'vue';
import { createPinia } from 'pinia';

import '../public/css/steam.css';
import '../public/css/style.css';

import App from './App.vue';
import router from './router/router.js';

const app = createApp(App)

app.use(router)
app.use(createPinia())
app.use(store)

app.mount('#vue-app')