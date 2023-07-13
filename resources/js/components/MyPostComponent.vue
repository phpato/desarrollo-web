<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h2>Mis posts</h2>
                        <div class="float-end">
                             <button class="btn btn-success" @click="createPost" v-if="edit==false">
                                <i class="fa fa-plus"></i> Nuevo post
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12" v-if="newPost || edit" ref="targetEdit">
                <div class="card">
                    <div class="card-body bg-default">
                        <h2>Nuevo post</h2>
                        <div class="row">
                            <div class="col-12" v-if="errors.length>0">
                                <div class="alert alert-danger" role="alert">
                                    <strong>Errores:</strong>
                                    <ul>
                                        <li v-for="error in errors" :key="error">{{ error }}</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="select-state" class="form-label">Estado:</label>
                                    <select id="select-state" class="form-control" required v-model="post.state_id">
                                        <option value="">Seleccione una opción</option>
                                        <option v-for="state in states" :key="state.id" :value="state.id">{{ state.name }}</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="post-user" class="form-label">Post:</label>
                                    <textarea id="post-user" class="form-control" type="text" rows="5" v-model="post.post" required></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="float-end">
                                     <button class="btn btn-success mb-1" @click="addPost" v-if="newPost">
                                        <i class="fa fa-plus"></i> Crear
                                    </button>
                                    <button class="btn btn-warning mb-1" @click="editPost" v-if="edit">
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
            <div class="col-12" v-if="posts.length==0">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Sin posts!</strong> Crea un post y visualizalo aqui.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
            <div class="col-12" v-if="posts.length>0">
                <div class="card">
                    <div class="row"> 
                        <div class="card-body bg-default">
                            <div class="row" v-for="item in posts" :key="item.id">
                                <div class="alert alert-dark" role="alert" >
                                    <div class="col-12">
                                        <h1 class="card-text text-bg-primary">{{ currentUser.name }}</h1>
                                        Estado: <h1 class="badge text-bg-success">{{ item.state.name }}</h1>
                                        <h2 class="card-text">{{ item.post }}</h2>
                                    </div>
                                    <div class="col-12">
                                        <div class="float-start">
                                            <p> Fecha: {{ parseDate(item.created_at) }}</p>
                                        </div>
                                        <div class="float-end">
                                            <button class="btn btn-warning" title="Editar"  @click="startEdit(item)">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <button class="btn btn-danger" title="Eliminar" @click="deletePost(item)" v-if="currentUser.id!=item.id">
                                                <i class="fa fa-trash-o"></i>
                                            </button>                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                         </div>
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
        props:['currentUser', 'states'],
        data(){
            return {
                ref: null,
                edit: false,
                errors: [],
                newPost: false,
                posts: [],
                post:{
                    id: null,
                    post: "",
                    state_id: ""
                }
            }
        },
        async mounted() {
            await this.getPosts()
        },
        methods:{
            validateForm(){
                let errors = []
                if( !this.post.post || this.post.post == "" ){
                    errors.push("Debe ingresar un post")
                }
                if( !this.post.state_id || this.post.state_id == "" ){
                    errors.push("Debe ingresar un estado del post")
                }
                if( errors.length > 0 ){
                    this.errors = errors;
                    return false
                }
                return true;
            },
            parseDate(date){
                const newDate = new Date(date)
                return newDate.toLocaleString()
            },
            createPost(){
                this.newPost = true
                this.edit = false
            },
            startEdit(post){
                this.newPost = false
                this.edit = true
                this.post = post
                this.$refs.targetEdit?.scrollIntoView({ behavior: 'smooth' });
            },
            async getPosts(){
                await axios
                    .get(`/posts/${this.currentUser.id}`)
                    .then(response => {
                        this.posts = response.data
                    })
            },
            async addPost(){
                const validatedForm = this.validateForm();
                if( validatedForm ){
                    const post = { post: this.post.post, state_id: this.post.state_id }
                    const response = await this.postPost(post)
                    if( response && response.data){
                        this.notify("Exito!", "success", "Post creado correctamente")
                        this.cleanForm()
                        await this.getPosts()
                    }
                }
            },
            async editPost(){
                const validatedForm = this.validateForm();
                if( validatedForm ){
                    const post = { id: this.post.id, post: this.post.post, state_id: this.post.state_id }
                    const response = await this.putPost(post)
                    if( response && response.data){
                        this.notify("Exito!", "success", "Post actualizado correctamente")
                        this.cleanForm()
                        await this.getPosts()
                    }
                }
            },
            async postPost(post){
                return await axios.post("/post", post)
                    .then(response => {
                        return response
                    })
                    .catch(error => {
                        this.notify("Ocurrio un error", "error", error.message)
                        console.error("There was an error in creation post: !", error)
                    });
            },
            async putPost(post){
                return await axios.put(`/post/${post.id}`, post)
                    .then(response => {
                        return response
                    })
                    .catch(error => {
                        this.notify("Ocurrio un error actualizando post", "error", error.message)
                        console.error("There was an error in update post: !", error)
                    });
            },
            async deletePost(post){
                Swal.fire({
                    title: `¿Esta seguro de eliminar al post ${post.id}?`,
                    showCancelButton: true,
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Eliminar',
                    denyButtonText: `Cancelar`,
                }).then(async (result) => {
                    if (result.isConfirmed) {
                       await axios
                        .delete(`/post/${post.id}`)
                        .then(async response => {
                            await this.getPosts()
                            this.notify("Post eliminado!", "success", "Exito al eliminar el post")
                        })
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
                this.errors = []
                this.edit = false
                this.newPost = false
                this.post = {
                    id: null,
                    post: "",
                    state_id: ""
                }
            }
        }
    }
</script>
