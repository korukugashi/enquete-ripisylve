import { createApp } from "vue";
import { createWebHashHistory, createRouter } from "vue-router";

import App from "./App.vue";
import HomePage from './components/HomePage.vue';
import ObservationStep from './components/ObservationStep.vue';
import ConfirmStep from './components/ConfirmStep.vue';
/* font awesome */
import { library } from "@fortawesome/fontawesome-svg-core";
import {
  faExclamationTriangle,
} from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
library.add(
  faExclamationTriangle,
);
/* end font awsome */

import "./index.scss";

const routes = [
  { name: 'home', path: '/', component: HomePage },
  { name: 'observation', path: '/observation', component: ObservationStep },
  { name: 'confirm', path: '/confirm', component: ConfirmStep },
]

const router = createRouter({
  history: createWebHashHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    return { top: 0 }
  },
})

const app = createApp(App)
app.component("font-awesome-icon", FontAwesomeIcon);
app.use(router)
app.mount('#app')