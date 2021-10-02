<template>
    <div>
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
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="modals">
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
            return{
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
            }
        },
        methods:{
            getTasks(){
                this.disabled = true
                axios.post('/api/user/tasks')
                    .then(response=>{
                        this.tasks = response.data.data
                        console.log(response.data.data);
                        this.disabled = false
                    })
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
            updateCheck(task_id){
                axios.post('/api/admin/task/check/'+task_id)
                    .then(response=>{})
                this.getTasks()
            }
        },
        mounted(){
            this.getTasks()
        }
    }
</script>