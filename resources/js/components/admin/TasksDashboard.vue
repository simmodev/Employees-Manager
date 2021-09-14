<template>
    <div>
        <div>
            <button type="button" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target='#add'><i class="bi bi-plus"></i>Add Task</button>
        </div>
        <div>
            <vue-element-loading 
                color="#0275d8" 
                :active="false" 
                spinner="line-scale" 
                is-full-screen
                background-color = 'rgba(255, 255, 255, .4)'
            />
            <table class="table">
                <thead>
                    <tr>
                        <th class="py-3" scope="col">#</th>
                        <th class="py-3" scope="col">Project</th>
                        <th class="py-3" scope="col">Taks Title</th>
                        <th class="py-3" scope="col">description</th>
                        <th class="py-3" scope="col">Employee</th>
                        <th class="py-3" scope="col">Actions</th>
                    </tr>
                </thead>
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
                            console.log(this.errors)
                        }
                    })
                this.getProjects()
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
                console.log(this.project_selected)
            }
            
        },
        mounted(){
            this.getProjects()
        }
    }
</script>

<style scoped>

</style>