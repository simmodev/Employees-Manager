require('./bootstrap');

import { createApp } from 'vue';
import UsersDashboard from './components/admin/UsersDashboard.vue';
import ProjectsDashboard from './components/admin/ProjectsDashboard.vue';
import TasksDashboard from './components/admin/TasksDashboard.vue';


import VueElementLoading from "vue-element-loading";
import Multiselect from '@vueform/multiselect'



let app=createApp({})
app.component('users-dashboard' , UsersDashboard);
app.component('projects-dashboard' , ProjectsDashboard);
app.component('tasks-dashboard' , TasksDashboard);


app.component("VueElementLoading", VueElementLoading);
app.component('Multiselect' , Multiselect);

app.mount("#app")





