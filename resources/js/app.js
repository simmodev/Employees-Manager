require('./bootstrap');

import { createApp } from 'vue';
import UsersDashboard from './components/admin/UsersDashboard.vue';
import exampleComponent from './components/ExampleComponent.vue';

let app=createApp({})
app.component('users-dashboard' , UsersDashboard);
app.component('example-component' , exampleComponent);
app.mount("#app")





