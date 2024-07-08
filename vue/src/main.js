import { createApp } from 'vue';
import Login from './components/Login.vue'; // Путь к вашему компоненту Login.vue
import router from './router/index.js';
import App from "./App.vue";

const app = createApp(App);

app.use(router).mount('#app');
