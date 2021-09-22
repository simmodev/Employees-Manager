<template>
    <div>
        <div>
            <button type="button" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target='#add'><i class="bi bi-plus"></i>Add Employee</button>
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
                        <th class="py-3" scope="col">Name</th>
                        <th class="py-3" scope="col">Job name</th>
                        <th class="py-3" scope="col">Email</th>
                        <th class="py-3" scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(user, index) in users" :key='index'>
                        <th class="py-3" scope="row">{{ user.id }}</th>
                        <td class="py-3">{{ user.first_name }} {{user.last_name}}</td>
                        <td class="py-3">{{ user.job_name }}</td>
                        <td class="py-3">{{ user.email }}</td>
                        <td class="py-3">
                            <button class="btn btn-primary btn-sm text-white mx-1" data-bs-toggle="modal" data-bs-target='#show' @click="show(user)">Show</button>
                            <button class="btn btn-info btn-sm text-white mx-1" data-bs-toggle="modal" data-bs-target='#edit' @click="init_edit(user)">Edit</button>
                            <button class="btn btn-danger btn-sm text-white mx-1" @click="destroy(user.id)">Delete</button>
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
                            <h5 class="modal-title" id="staticBackdropLabel">Add Employee</h5>
                        </div>
                        <div class="modal-body"> 
                            <div class="alert alert-danger" v-if="errors">
                                All fields must be filled!
                            </div>
                            <form action=""> 
                                <div class="row g-3">
                                    <div class="col">
                                        <label>First name</label>
                                        <input v-model='user.first_name' type="text" class="form-control" :class="errors && errors.first_name?'border-danger':''">
                                    </div>
                                    <div class="col">
                                        <label>Last name</label> 
                                        <input v-model='user.last_name' type="text" class="form-control" :class="errors && errors.last_name?'border-danger':''">
                                    </div>
                                </div>
                                <label class="mt-2">Job Name</label>
                                <input v-model="user.job_name" type="text" class="form-control" :class="errors && errors.job_name?'border-danger':''"> 
                                <label class="mt-2">Phone Number</label>
                                <input v-model="user.phone_number" type="number" class="form-control" :class="errors && errors.phone_number?'border-danger':''">
                                <label class="mt-2">Email</label>
                                <input v-model="user.email" type="email" class="form-control" :class="errors && errors.email?'border-danger':''">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary text-white" @click="add">Add</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="edit" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Edit Employee</h5>
                    </div>
                    <div class="modal-body"> 
                        <div class="alert alert-danger" v-if="errors">
                            All fields must be filled!
                        </div>
                        <form action=""> 
                            <div class="row g-3">
                                <div class="col">
                                    <label>First name</label>
                                    <input v-model='edited_user.first_name' type="text" class="form-control" :class="errors && errors.first_name?'border-danger':''">
                                </div>
                                <div class="col">
                                    <label>Last name</label> 
                                    <input v-model='edited_user.last_name' type="text" class="form-control" :class="errors && errors.last_name?'border-danger':''">
                                </div>
                            </div>
                            <label class="mt-2">Job Name</label>
                            <input v-model="edited_user.job_name" type="text" class="form-control" :class="errors && errors.job_name?'border-danger':''"> 
                            <label class="mt-2">Phone Number</label>
                            <input v-model="edited_user.phone_number" type="number" class="form-control" :class="errors && errors.phone_number?'border-danger':''">
                            <label class="mt-2">Email</label>
                            <input v-model="edited_user.email" type="email" class="form-control" :class="errors && errors.email?'border-danger':''">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary text-white" @click="edit">Edit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="show" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Employee Info</h5>
                    </div>
                    <div class="modal-body"> 
                        <div class="row">
                            <div class="col-3">
                                <strong>Name:</strong>
                            </div>
                            <div class="col-9">
                                <p>{{show_user.first_name}} {{show_user.last_name}}</p>
                            </div>
                            <hr>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <strong>Job Name:</strong>
                            </div>
                            <div class="col-9">
                                <p>{{show_user.job_name}}</p>
                            </div>
                            <hr>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <strong>Phone Number:</strong>
                            </div>
                            <div class="col-9">
                                <p>{{show_user.phone_number}}</p>
                            </div>
                            <hr>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <strong>Email:</strong>
                            </div>
                            <div class="col-9">
                                <p>{{show_user.email}}</p>
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
</template>

<script>
import VueElementLoading from "vue-element-loading";
    export default {
        data(){
            return{
                user: {
                    first_name:'',
                    last_name:'',
                    job_name:'',
                    phone_number:'',
                    email:'',
                },
                users: [],
                errors:null,
                disabled: true,
                show_user:{
                    id:null,
                    first_name:'',
                    last_name:'',
                    job_name:'',
                    phone_number:'',
                    email:'',
                },
                edited_user:{
                    id:null,
                    first_name:'',
                    last_name:'',
                    job_name:'',
                    phone_number:'',
                    email:'',
                },
            }
        },
        methods:{
            add(){
                this.disabled = true
                axios.post('/api/admin/user/add', this.user)
                .then(response=>{})
                .catch(error =>{
                    if(error.response.status === 422){
                        this.errors = error.response.data.errors
                    }
                })
                this.getUsers()
            },
            getUsers(){
                this.disabled = true
                axios.post('/api/admin/users')
                .then(response=>{
                    this.users = response.data.data
                    this.disabled = false
                })
            },
            show(user){
                this.disabled=true
                this.show_user=user
                this.disabled= false
            },
            init_edit(user){
                this.edited_user.id = user.id
                this.edited_user.first_name = user.first_name
                this.edited_user.last_name = user.last_name
                this.edited_user.job_name = user.job_name
                this.edited_user.phone_number = user.phone_number
                this.edited_user.email = user.email
            },
            edit(){
                this.disabled=true
                axios.post('/api/admin/user/edit/'+this.edited_user.id, this.edited_user)
                    .then(response=>{
                        this.getUsers()
                    })
                    .catch(error=>{
                        if(error.response.status === 422){
                            this.errors = error.response.data.errors
                        }
                        this.disabled=false
                    })
            },
            destroy(user_id){
                this.disabled = true
                axios.post('/api/admin/user/delete/'+user_id)
                    .then(response=>{})
                this.getUsers()
            
            }
        },
        mounted(){
            console.log('users dashboard is mounted')
            this.getUsers()
        },
        components: {
            VueElementLoading
        }
    }
</script>

<style scoped>

</style>