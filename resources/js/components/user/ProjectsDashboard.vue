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
            return{
                projects: null,
                disabled: true,
                show_project:[{
                    title: '',
                    description: '',
                }],
                show_project_users:{
                    first_name:'',
                    last_name:'',
                },
            }
        },
        methods:{
            getProjects(){
                this.disabled = true
                axios.post('/api/user/projects')
                .then(response=>{
                    this.projects = response.data.data
                    this.disabled = false
                })
            },
            show(project){
                this.disabled=true
                axios.post('/api/user/project/users/'+project.id) 
                    .then(response=>{
                        this.show_project_users = response.data.data
                        this.disabled=false
                    })
                this.show_project=project
            },
        },
        mounted(){
            this.getProjects()
        }
    }
</script>