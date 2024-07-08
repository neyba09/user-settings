// router/index.js

import { createRouter, createWebHistory } from 'vue-router';
import ConfirmationProcess from '../components/ConfirmationProcess.vue';
import Login from '../components/Login.vue';

const routes = [
    {
        path: '/',
        redirect: '/login' // По умолчанию редиректим на страницу входа
    },
    {
        path: '/login',
        name: 'Login',
        component: Login
    },
    {
        path: '/confirmation-process',
        name: 'ConfirmationProcess',
        component: ConfirmationProcess
    },
    // Добавьте другие маршруты здесь
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
