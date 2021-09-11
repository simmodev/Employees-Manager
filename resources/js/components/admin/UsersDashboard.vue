<template>
    <div>
        <div>
            <button type="button" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target='#add'><i class="bi bi-plus"></i>إضافة موظف</button>
        </div>
        <div>
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">الاسم</th>
                    <th scope="col">الوظيفة</th>
                    <th scope="col">البريد الالكتروني</th>
                    <th scope="col">العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(user, index) in users" :key=index>
                        <th scope="row">{{ user.id }}</th>
                        <td>{{ user.first_name }} {{user.last_name}}</td>
                        <td>{{ user.job_name }}</td>
                        <td>{{ user.email }}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="modals">
            <div id="add" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">إضافة موظف</h5>
                        </div>
                        <div class="modal-body"> 
                            <div class="alert alert-danger" v-if="errors">
                                يجب ملء جميع الخانات بمعلومات صحيحة !
                            </div>
                            <form action=""> 
                                <div class="row g-3">
                                    <div class="col">
                                        <label>الاسم</label>
                                        <input v-model='user.first_name' type="text" class="form-control" :class="errors && errors.first_name?'border-danger':''">
                                    </div>
                                    <div class="col">
                                        <label>الاسم العائلي</label> 
                                        <input v-model='user.last_name' type="text" class="form-control" :class="errors && errors.last_name?'border-danger':''">
                                    </div>
                                </div>
                                <label class="mt-2">الاسم الوظيفي</label>
                                <input v-model="user.job_name" type="text" class="form-control" :class="errors && errors.job_name?'border-danger':''"> 
                                <label class="mt-2">رقم الهاتف</label>
                                <input v-model="user.phone_number" type="number" class="form-control" :class="errors && errors.phone_number?'border-danger':''">
                                <label class="mt-2">البريد الإلكتروني</label>
                                <input v-model="user.email" type="email" class="form-control" :class="errors && errors.email?'border-danger':''">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary text-white" @click="add">إضافة</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
</template>

<script>
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
            }
        },
        methods:{
            add(){
                axios.post('/api/add', this.user)
                .then()
                .catch(error =>{
                    if(error.response.status === 422){
                        this.errors = error.response.data.errors
                    }
                })
                this.getUsers()
            },
            getUsers(){
                axios.post('/api/users')
                .then(response=>{
                    this.users = response.data.data
                    console.log(this.users)
                })
            }
        },
        mounted(){
            console.log('users dashboard is mounted')
            this.getUsers()
        }
    }
</script>

<style scoped>

</style>