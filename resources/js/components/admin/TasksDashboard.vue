<template>
    <div>
        <div>
            <button type="button" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target='#add'><i class="bi bi-plus"></i>إضافة مشروع</button>
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
                        <th class="py-3" scope="col">المشروع</th>
                        <th class="py-3" scope="col">عنوان المهمة</th>
                        <th class="py-3" scope="col">الوصف</th>
                        <th class="py-3" scope="col">الموظف</th>
                        <th class="py-3" scope="col">العمليات</th>
                    </tr>
                </thead>
                
            </table>
        </div>
        <div id="modals">
            <div id="add" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">إضافة مهمة</h5>
                        </div>
                        <div class="modal-body"> 
                            <div class="alert alert-danger" v-if="errors">
                                يجب ملء جميع الخانات بمعلومات صحيحة !
                            </div>
                            <form action=""> 
                                <label class="mt-2">عنوان المشروع</label>
                                <input v-model="project.title" type="text" class="form-control" :class="errors && errors.title?'border-danger':''"> 
                                <label class="mt-2">الوصف</label>
                                <textarea v-model="project.description" class="form-control" :class="errors && errors.description?'border-danger':''"></textarea>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary text-white" @click='add'>إضافة</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
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
                project : {
                    title: '',
                    description: '',
                },
                projects: null,
                users:null,
                errors: null,
                disabled: true,
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
            
        },
        mounted(){
            this.getProjects()
            
        }
    }
</script>

<style scoped>

</style>