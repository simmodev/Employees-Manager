<template>
    <div>
        <div>
            <button type="button" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target='#add'><i class="bi bi-plus"></i>Add Project</button>
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
                        <th class="py-3" scope="col">#</th>
                        <th class="py-3" scope="col">Title</th>
                        <th class="py-3" scope="col">Description</th>
                        <th class="py-3" scope="col">actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(project, index) in projects" :key='index'>
                        <th class="py-3" scope="row">{{ project.id }}</th>
                        <td class="py-3">{{ project.title }}</td>
                        <td class="py-3"> {{project.description}} </td>
                        <td class="py-3">
                            <button class="btn btn-primary btn-sm text-white mx-1" data-bs-toggle="modal" data-bs-target='#show' @click="show(project)">Show</button>
                            <button class="btn btn-info btn-sm text-white mx-1" data-bs-toggle="modal" data-bs-target='#edit' @click="init_edit(project)">Edit</button>
                            <button class="btn btn-danger btn-sm text-white mx-1" @click="destroy(project.id)">Delete</button>
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
                            <h5 class="modal-title" id="staticBackdropLabel">Add Project</h5>
                        </div>
                        <div class="modal-body"> 
                            <div class="alert alert-danger" v-if="errors">
                                All fields should me filled!
                            </div>
                            <form action=""> 
                                <label class="mt-2">Title</label>
                                <input v-model="project.title" type="text" class="form-control mt-1" :class="errors && errors.title?'border-danger':''"> 
                                <label class="mt-2">Description</label>
                                <textarea v-model="project.description" class="form-control mt-1" :class="errors && errors.description?'border-danger':''"></textarea>
                                <label class="mt-2">Employees in charge of the project</label>
                                <div>
                                    <Multiselect
                                        mode="tags"
                                        :closeOnSelect="false"
                                        :searchable="true"
                                        :createTag="false"
                                        v-model="project.selected_users"
                                        :options="users"
                                        valueProp='id'
                                        :required="true"
                                        :class="errors && errors.selected_users?'border-danger':''"
                                        label='first_name'
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
                            <h5 class="modal-title" id="staticBackdropLabel">Edit Project</h5>
                        </div>
                        <div class="modal-body"> 
                            <div class="alert alert-danger" v-if="errors">
                                All fields should me filled!
                            </div>
                            <form action=""> 
                                <label class="mt-2">Title</label>
                                <input v-model="edited_project.title" type="text" class="form-control mt-1" :class="errors && errors.title?'border-danger':''"> 
                                <label class="mt-2">Description</label>
                                <textarea v-model="edited_project.description" class="form-control mt-1" :class="errors && errors.description?'border-danger':''"></textarea>
                                <label class="mt-2">Employees in charge of the project</label>
                                <div>
                                    <Multiselect
                                        mode="tags"
                                        :closeOnSelect="false"
                                        :searchable="true"
                                        :createTag="false"
                                        v-model="edited_project.selected_users"
                                        :options="users"
                                        valueProp='id'
                                        :required="true"
                                        :class="errors && errors.selected_users?'border-danger':''"
                                        label='first_name'
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
                                    <strong>Project Title:</strong>
                                </div>
                                <div class="col-9">
                                    <p>{{show_project.title}}</p>
                                </div>
                                <hr>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <strong>Description:</strong>
                                </div>
                                <div class="col-9">
                                    <p>{{show_project.description}}</p>
                                </div>
                                <hr>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <strong>Employees in charge:</strong>
                                </div>
                                <div class="col-9">
                                    <label v-for="(user, index) in show_project_users" :key="index">[{{user.first_name}} {{user.last_name}}]&nbsp;</label>
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
                project:{
                    title: '',
                    description: '',
                    selected_users: null,
                },
                projects: null,
                users:null,
                errors: null,
                disabled: true,
                index: null,
                show_project:[{
                    title: '',
                    description: '',
                }],
                show_project_users:{
                    first_name:'',
                    last_name:'',
                },
                edited_project:{
                    id: null,
                    title: '',
                    description: '',
                    selected_users: [],
                },
            }
        },
        methods:{
            add(){
                this.disabled = true
                axios.post('/api/admin/project/add', this.project)
                    .then(response=>{})
                    .catch(error=>{
                        if(error.response.status === 422){
                            this.errors = error.response.data.errors
                            console.log(this.errors)
                        }
                    })
                this.getProjects()
            },
            getProjects(){
                this.disabled = true
                axios.post('/api/admin/projects')
                    .then(response=>{
                        this.projects = response.data.data
                        this.disabled = false
                    })
            },
            getUsers(){
                axios.post('/api/admin/users')
                    .then(response=>{
                        this.users = response.data.data
                    })
            },
            show(project){
                this.disabled=true
                axios.post('/api/admin/project/users/'+project.id)
                    .then(response=>{
                        this.show_project_users = response.data.data
                        this.disabled=false
                    })
                this.show_project=project
            },
            init_edit(project){
                this.disabled=true
                this.edited_project.selected_users=[]
                axios.post('/api/admin/project/users/'+project.id)
                    .then(response=>{
                        this.show_project_users = response.data.data
                        this.show_project_users.forEach((user, index) => {
                            this.edited_project.selected_users.push(user.id);
                            this.disabled=false
                        });
                        this.disabled=false
                    })
                this.edited_project.id=project.id
                this.edited_project.title=project.title
                this.edited_project.description= project.description
            },
            edit(){
                this.disabled = true
                axios.post('/api/admin/project/edit/'+this.edited_project.id, this.edited_project)
                    .then(response=>{})
                    .catch(error=>{
                        if(error.response.status === 422){
                            this.errors = error.response.data.errors
                            this.disabled=false
                        }
                    })
                this.getProjects()
            },
            destroy(project_id){
                this.disabled = true
                axios.post('/api/admin/project/delete/'+project_id)
                    .then(response=>{})
                this.getProjects()
            }
        },
        mounted(){
            this.getProjects()
            this.getUsers()
        },

    }
</script>

<style></style>