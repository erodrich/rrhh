import Vue from 'vue'
import Router from 'vue-router'
import Occasion from '../components/Occasion'
import Article from '../components/Article'
import Document from '../components/Document'
import ArticleForm from '../components/ArticleForm'

Vue.use(Router);

export default new Router({
    mode: 'history',
    routes: [
        {
            name: 'home',
            path: '/',
            component: Article,
        },
        {
            name: 'eventos',
            path: '/eventos',
            component: Occasion,
        },
        {
            name: 'noticias',
            path: '/noticias',
            component: Article,
        },
        {
            name: 'noticiasForm',
            path: '/noticias/edit',
            component: ArticleForm,
            props: true,
        },
        {
            name: 'documentos',
            path: '/documentos',
            component: Document,
        },
    ]
})
