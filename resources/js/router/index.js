import Vue from 'vue'
import Router from 'vue-router'

import FilmComponent from '../components/FilmComponent.vue';
import IndexComponent from '../components/IndexComponent.vue';
import ModeratorReviews from '../components/ModeratorReviews.vue';
import BrowseFilms from '../components/BrowseFilms.vue';
import ProfileComponent from '../components/ProfileComponent.vue';
import AdminComponent from '../components/admin/AdminComponent.vue'

Vue.use(Router)

export default new Router({
    mode: 'history',
    linkExactActiveClass: 'is-active',
    routes: [{
            path: '/film/:id',
            component: FilmComponent,
            name: 'film'
        },
        {
            path: '/',
            component: IndexComponent,
            name: 'index'
        },
        {
            path: '/reviews',
            component: ModeratorReviews,
            name: 'reviews',
            beforeEnter: (to, from, next) => {
                if (Vue.prototype.$userId == null) {
                    next('/');
                } else {
                    if (Vue.prototype.$userId.role_id != 2 && Vue.prototype.$userId.role_id != 1) {
                        next('/');
                    } else next();
                }
            }
        },
        {
            path: '/browse-movies/:search?',
            component: BrowseFilms,
            name: 'browse-movies'
        },
        {
            path: '/user',
            component: ProfileComponent,
            name: 'user'
        },
        {
            path: '/admin',
            component: AdminComponent,
            name: 'admin',
            beforeEnter: (to, from, next) => {
                if (Vue.prototype.$userId == null) {
                    next('/');
                } else {
                    if (Vue.prototype.$userId.role_id != 1) {
                        next('/');
                    } else next();
                }
            }
        },
    ]
});
