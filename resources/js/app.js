import './bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
import { createApp } from 'vue';
import App from './components/App.vue';
import { createRouter, createWebHistory } from "vue-router";
import { routes } from "./router";


const app = createApp(App);

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
})

app.use(router);
app.mount('#app');