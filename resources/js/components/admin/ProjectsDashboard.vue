<template>
    <div>
        <div>
            <button type="button" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target='#add'><i class="bi bi-plus"></i>إضافة مشروع</button>
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
                        <td class="py-3"> </td>
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
        },
        mounted(){
            this.getProjects()
            this.getUsers()
        },

    }
</script>

<style></style>