<template>
    <div>
        <div>
            <button type="button" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target='#add'><i class="bi bi-plus"></i>إضافة موظف</button>
        </div>
        <div>

        </div>
        <div id="modals">
            <div id="add" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">إضافة موظف</h5>
                        </div>
                        <div class="modal-body"> 
                            <form action=""> 
                                <div class="row g-3">
                                    <div class="col">
                                        <label>الاسم</label>
                                        <input v-model='employee.first_name' type="text" class="form-control">
                                    </div>
                                    <div class="col">
                                        <label>الاسم العائلي</label> 
                                        <input v-model='employee.last_name' type="text" class="form-control">
                                    </div>
                                </div>
                                <label class="mt-2">الاسم الوظيفي</label>
                                <input v-model="employee.job_name" type="text" class="form-control"> 
                                <label class="mt-2">رقم الهاتف</label>
                                <input v-model="employee.phone_number" type="number" class="form-control">
                                <label class="mt-2">البريد الإلكتروني</label>
                                <input v-model="employee.email" type="email" class="form-control">
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
                employee: {
                    first_name:'',
                    last_name:'',
                    job_name:'',
                    phone_number:'',
                    email:'',
                }
            }
        },
        methods:{
            add(){
                axios.post('/api/add', this.employee)
            }
        },
        mounted(){
            console.log('mounted')
        }
    }
</script>

<style scoped>

</style>