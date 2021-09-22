<template>
    <div>
        <div>
            <button type="button" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target='#add'><i class="bi bi-plus"></i>Add Task</button>
        </div>
        <div>
            <vue-element-loading 
                color="#0275d8" 
                :active="disabled" 
                spinner="line-scale" 
                is-full-screen
                background-color = 'rgba(255, 255, 255, .4)'
            />
            <table class="table">
                <thead>
                    <tr>
                        <th class="py-3" scope="col">isCompleted</th>
                        <th class="py-3" scope="col">#</th>
                        <th class="py-3" scope="col">Taks Title</th>
                        <th class="py-3" scope="col">description</th>
                        <th class="py-3" scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(task, index) in tasks" :key='index'>
                        <th class="py-1">
                            <input :checked="task.completed" @change="updateCheck(task.id)" type="checkbox" class="form-check-input" style="width: 30px; height: 30px;">
                        </th>
                        <th class="py-3" scope="row">{{ task.id }}</th>
                        <td class="py-3">{{ task.title }}</td>
                        <td class="py-3">{{ task.description }}</td>
                        <td class="py-3">
                            <button class="btn btn-primary btn-sm text-white mx-1" data-bs-toggle="modal" data-bs-target='#show' @click="show_task(task.project_id, task.user_id, task.title, task.description)">Show</button>
                            <button class="btn btn-info btn-sm text-white mx-1" data-bs-toggle="modal" data-bs-target='#edit' @click="init_edit(task)">Edit</button>
                            <button class="btn btn-danger btn-sm text-white mx-1" @click="destroy(task.id)">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="modals">
            <div id="add" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Add Task</h5>
                        </div>
                        <div class="modal-body"> 
                            <div class="alert alert-danger" v-if="errors">
                                All fields must be filled
                            </div>
                            <form action=""> 
                                <label class="mt-2">Task title</label>
                                <input v-model="task.title" type="text" class="form-control" :class="errors && errors.title?'border-danger':''"> 
                                <label class="mt-2">Description</label>
                                <textarea v-model="task.description" class="form-control" :class="errors && errors.description?'border-danger':''"></textarea>
                                <label class="mt-2">Project</label>
                                <div class="mt-1">
                                    <Multiselect
                                        mode='single'
                                        v-model="task.project_id"
                                        placeholder="Select your project"
                                        :options="projects"
                                        :searchable="true"
                                        label='title'
                                        valueProp='id'
                                        @select='getUsers'
                                        @clear='hideUsers'
                                    ></Multiselect>
                                </div>
                                <div class="mt-2" v-if='project_selected'>
                                    <label class="mb-1">Employee</label>
                                    <Multiselect
                                        mode='single'
                                        v-model="task.user_id"
                                        placeholder="Select an employee"
                                        :options="users"
                                        :searchable="true"
                                        label='first_name'
                                        valueProp='id'
                                    ></Multiselect>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary text-white" @click='add'>Add</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="edit" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Edit Task</h5>
                        </div>
                        <div class="modal-body"> 
                            <div class="alert alert-danger" v-if="errors">
                                All fields must be filled
                            </div>
                            <form action=""> 
                                <label class="mt-2">Task title</label>
                                <input v-model="edited_task.title" type="text" class="form-control" :class="errors && errors.title?'border-danger':''"> 
                                <label class="mt-2">Description</label>
                                <textarea v-model="edited_task.description" class="form-control" :class="errors && errors.description?'border-danger':''"></textarea>
                                <label class="mt-2">Project</label>
                                <div class="mt-1">
                                    <Multiselect
                                        mode='single'
                                        v-model="edited_task.project_id"
                                        placeholder="Select your project"
                                        :options="projects"
                                        :searchable="true"
                                        label='title'
                                        valueProp='id'
                                        @select='get_edit_users'
                                        @clear='hide_edit_users'
                                    ></Multiselect>
                                </div>
                                <div class="mt-2" v-if='project_selected'>
                                    <label class="mb-1">Employee</label>
                                    <Multiselect
                                        mode='single'
                                        v-model="edited_task.user_id"
                                        placeholder="Select an employee"
                                        :options="users"
                                        :searchable="true"
                                        label='first_name'
                                        valueProp='id'
                                    ></Multiselect>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary text-white" @click='edit'>Edit</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="show" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Task infos</h5>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-3">
                                    <strong>Task Title:</strong>
                                </div>
                                <div class="col-9">
                                    <p>{{task_info.title}}</p>
                                </div>
                                <hr>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <strong>Description:</strong>
                                </div>
                                <div class="col-9">
                                    <p>{{task_info.description}}</p>
                                </div>
                                <hr>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <strong>Employee in charge:</strong>
                                </div>
                                <div class="col-9">
                                    <p>{{task_info.user_name}}</p>
                                </div>
                                <hr>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <strong>Project Title</strong>
                                </div>
                                <div class="col-9">
                                    <p>{{task_info.project_title}}</p>
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default{
        data(){
            return {
                task : {
                    title: '',
                    description: '',
                    user_id: null,
                    project_id: null
                },
                projects:null,
                users:null,
                tasks: null,
                errors: null,
                disabled: true,
                project_selected: false,
                task_info:{
                    title:'',
                    description:'',
                    user_name:'',
                    project_title:'',
                },
                edited_task:{
                    id: null,
                    title: '',
                    description: '',
                    user_id: null,
                    project_id: null
                },
                
            }
        },
        methods:{
            add(){
                this.disabled = true
                axios.post('/api/admin/task/add', this.task)
                    .then(response=>{})
                    .catch(error=>{
                        if(error.response.status === 422){
                            this.errors = error.response.data.errors
                        }
                    })
                this.getTasks()
            },
            getTasks(){
                this.disabled = true
                axios.post('/api/admin/tasks')
                    .then(response=>{
                        this.tasks = response.data.data
                        this.disabled = false
                    })
            },
            getProjects(){
                axios.post('/api/admin/projects')
                    .then(response=>{
                        this.projects = response.data.data
                    })
            },
            getUsers(){
                this.project_selected = true
                this.disabled = true
                this.task.user_id = null
                axios.post('/api/admin/task/users', this.task)
                    .then(response=>{
                        this.users = response.data.data
                        this.disabled = false
                    })
            },
            hideUsers(){
                this.project_selected = false
                this.task.user_id = null
                this.users = null
            },
            show_task(project_id, user_id, task_title, task_description){
                this.disabled=true
                this.task_info.project_title=null
                this.task_info.user_name=null
                this.task_info.title=task_title
                this.task_info.description=task_description
                axios.post('/api/admin/task/user/'+user_id)
                    .then(response=>{
                        this.task_info.user_name = response.data.first_name+' '+response.data.last_name
                    })

                axios.post('/api/admin/task/project/'+project_id)
                    .then(response=>{
                        console.log(response.data)
                        this.task_info.project_title = response.data.title
                        this.disabled= false
                    })
            },
            
            init_edit(task){
                this.disabled = true
                this.project_selected = true

                this.edited_task.id = task.id
                this.edited_task.title = task.title
                this.edited_task.description = task.description
                this.edited_task.user_id = task.user_id
                this.edited_task.project_id = task.project_id
                
                this.project_selected = true
                axios.post('/api/admin/task/users', this.edited_task)
                    .then(response=>{
                        this.users = response.data.data
                        this.disabled = false
                    })
            },
            get_edit_users(){
                this.project_selected = true
                this.disabled = true
                this.edited_task.user_id = null
                axios.post('/api/admin/task/users', this.edited_task)
                    .then(response=>{
                        this.users = response.data.data
                        this.disabled = false
                    })
            },
            hide_edit_users(){
                this.project_selected = false
                this.edited_task.user_id = null
                this.users = null
            },
            edit(){
                this.disabled = true
                axios.post('/api/admin/task/edit/'+this.edited_task.id, this.edited_task)
                    .then(response=>{})
                    .catch(error=>{
                        if(error.response.status === 422){
                            this.errors = error.response.data.errors
                        }
                    })
                this.getTasks()
            },
            destroy(task_id){
                this.disabled = true
                axios.post('/api/admin/task/delete/'+task_id)
                    .then(response=>{})
                this.getTasks()
            },
            updateCheck(task_id){
                axios.post('/api/admin/task/check/'+task_id)
                    .then(response=>{})
                this.getTasks()
            }
        },
        mounted(){
            this.getTasks()
            this.getProjects()
        }
    }
</script>

<style scoped>

</style>