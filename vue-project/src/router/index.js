import {createRouter,createWebHistory} from 'vue-router'
import menuPage from '../views/menuPage.vue'
import notePage from '../views/notePage.vue'

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'mainmenu',
            component : menuPage,
        },
        {
            path: '/notes/:slug',
            name: 'note page',
            component : notePage,
        },
    ]
})

export default router