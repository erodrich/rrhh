import Vue from 'vue'
import Router from 'vue-router'
import Occasion from '../components/Occasion'

Vue.use(Router)

export default new Router({
    mode: 'history',
    routes: [
        {
            name: 'occasions',
            path: '/',
            component: Occasion,
        },
    ]
})
