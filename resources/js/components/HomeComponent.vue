<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h1>Bienvenido {{ currentUser.name}}!</h1>
                        <h2>Dashboard</h2>
                        <div class="float-end">
                             <button class="btn btn-success" @click="createUser" v-if="edit==false">
                                <i class="fa fa-plus"></i> Nuevo usuari'o
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12" v-if="newUser || edit">
                <div class="card">
                    <div class="card-body bg-default">
                        <h2>Nuevo usuario</h2>
                        <div class="row">
                            <div class="mb-3 col-6">
                                <label class="form-label">Nombre:</label>
                                <input class="form-control" type="text" v-model="user.name">
                            </div>
                            <div class="mb-3 col-6">
                                <label class="form-label">Email:</label>
                                <input class="form-control" type="email" v-model="user.email" :disabled="edit">
                            </div>
                            <div class="mb-3 col-12">
                                <div class="float-end">
                                     <button class="btn btn-success mb-1" @click="addUser" v-if="newUser">
                                        <i class="fa fa-plus"></i> Crear
                                    </button>
                                    <button class="btn btn-warning mb-1" @click="editUser" v-if="edit">
                                        <i class="fa fa-pencil"></i> Editar
                                    </button>
                                    <button class="btn btn-danger mb-1" @click="cleanForm">
                                        <i class="fa fa-times"></i> Cancelar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table v-if="users.length>0" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in users" :key="item.id">
                                    <td>{{ item.name }}</td>
                                    <td>{{ item.email }}</td>
                                    <td>
                                        <div class="mb-3 text-center">
                                            <button class="btn btn-warning" title="Editar"  @click="startEdit(item)">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <button class="btn btn-danger" title="Eliminar" @click="deleteUser(item)" v-if="currentUser.id!=item.id">
                                                <i class="fa fa-trash-o"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Swal from 'sweetalert2'
    import axios from 'axios'
    export default {
        props:['currentUser'],
        data(){
            return {
                edit: false,
                error: null,
                newUser: false,
                users: [],
                user:{
                    id: null,
                    name: "",
                    email: ""
                }
            }
        },
        async mounted() {
            await this.getUsers()
        },
        methods:{
            createUser(){
                this.newUser = true
                this.edit = false
            },
            startEdit(user){
                this.newUser = false
                this.edit = true
                this.user = user
            },
            async getUsers(){
                await axios
                    .get('/user')
                    .then(response => {
                        this.users = response.data
                    })
            },
            async addUser(){
                const user = { name: this.user.name, email: this.user.email }
                const response = await this.postUser(user)
                if( response && response.data){
                    this.notify("Exito!", "success", "Usuario creado correctamente")
                    this.cleanForm()
                    await this.getUsers()
                }
            },
            async editUser(){
                const user = { id: this.user.id, name: this.user.name }
                const response = await this.putUser(user)
                if( response && response.data){
                    this.notify("Exito!", "success", "Usuario actualizado correctamente")
                    this.cleanForm()
                    await this.getUsers()
                }
            },
            async postUser(user){
                return await axios.post("/user", user)
                    .then(response => {
                        return response
                    })
                    .catch(error => {
                        this.notify("Ocurrio un error", "error", error.message)
                        console.error("There was an error in creation user: !", error)
                    });
            },
            async putUser(user){
                return await axios.put(`/user/${user.id}`, user)
                    .then(response => {
                        return response
                    })
                    .catch(error => {
                        this.notify("Ocurrio un error actualizando usuario", "error", error.message)
                        console.error("There was an error in creation user: !", error)
                    });
            },
            async deleteUser(user){
                Swal.fire({
                    title: `¿Esta seguro de eliminar al usuario ${user.name}?`,
                    showCancelButton: true,
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Eliminar',
                    denyButtonText: `Cancelar`,
                }).then(async (result) => {
                    if (result.isConfirmed) {
                       await axios
                        .delete(`/user/${user.id}`)
                        .then(async response => {
                            await this.getUsers()
                            this.notify("Usuario eliminado!", "success", "Exito al eiminar el usuario")
                        })
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info')
                    }
                })

            },
            async notify(title, status, message){
                Swal.fire({
                    title,
                    text: message,
                    icon: status,
                })
            },
            cleanForm(){
                this.edit = false
                this.newUser = false
                this.user = {
                    id: null,
                    name: "",
                    email: ""
                }
            }
        }
    }
</script>
