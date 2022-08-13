import FilmList from './components/FilmList.vue';
import FilmDetail from './components/FilmDetail.vue';
export const routes = [{
        name: 'home',
        path: '/',
        component: FilmList
    },
    {
        name: 'films',
        path: '/film',
        component: FilmList
    },
    {
        name: 'film-detail',
        path: '/films/:id',
        component: FilmDetail
    }
];