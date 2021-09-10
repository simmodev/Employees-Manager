require('./bootstrap');

import { createApp } from 'vue';
import employeesDashboard from './components/employeesDashboard.vue';
import exampleComponent from './components/ExampleComponent.vue';

let app=createApp({})
app.component('employees-dashboard' , employeesDashboard);
app.component('example-component' , exampleComponent);
app.mount("#app")





