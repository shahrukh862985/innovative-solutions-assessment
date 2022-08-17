import FilmList from './components/FilmList.vue';
import FilmDetail from './components/FilmDetail.vue';
import Login from './components/Login.vue';
import Register from './components/Register.vue';
import AddFilm from './components/AddFilm.vue';

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
        name: 'film-details',
        path: '/film-details/:id',
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
    },
    {
        name: 'films-create',
        path: '/films/create',
        component: AddFilm,
        meta: {
            middleware:"auth"
        }
    }
];