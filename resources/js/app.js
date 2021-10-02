require('./bootstrap');

//admin
import { createApp } from 'vue';
import UsersDashboard from './components/admin/UsersDashboard.vue';
import ProjectsDashboard from './components/admin/ProjectsDashboard.vue';
import TasksDashboard from './components/admin/TasksDashboard.vue';

//user
import ProjectDashboard from './components/user/ProjectsDashboard.vue';
import TaskDashboard from './components/user/TasksDashboard.vue';

//packages
import VueElementLoading from "vue-element-loading";
import Multiselect from '@vueform/multiselect'
import '@vueform/multiselect/themes/default.css'



let app=createApp({})
//admin
app.component('users-dashboard' , UsersDashboard);
app.component('projects-dashboard' , ProjectsDashboard);
app.component('tasks-dashboard' , TasksDashboard);

//user
app.component('project-dashboard' , ProjectDashboard);
app.component('task-dashboard' , TaskDashboard);

//packages
app.component("VueElementLoading", VueElementLoading);
app.component('Multiselect' , Multiselect);

app.mount("#app")





