import FilmList from './components/FilmList.vue';
import FilmDetail from './components/FilmDetail.vue';
import Login from './components/Login.vue';
import Register from './components/Register.vue';
export const routes = [{
        name: 'home',
        path: '/',
        redirect: '/films',
        meta: {
            middleware:"guest"
        }
    },
    {
        name: 'films',
        path: '/films',
        component: FilmList,
        meta: {
            middleware:"guest"
        }
    },
    {
        name: 'film-detail',
        path: '/films/:id',
        component: FilmDetail,
        meta: {
            middleware:"guest"
        }
    },
    {
        name: 'login',
        path: '/login',
        component: Login,
        meta: {
            middleware:"guest"
        }
    },
    {
        name: 'register',
        path: '/register',
        component: Register,
        meta: {
            middleware:"guest"
        }
    }
];