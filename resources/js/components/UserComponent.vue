<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12" >
                <div class="card">
                    <div class="card-header">
                        Usuarios
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                </tr>
                            </thead>   
                            <tbody>
                                <tr>
                                    <td>asda</td>
                                    <td>dasdaads</td>
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
    export default {
        props:['user'],
        data(){
            return {
                newPost: false,
                post: {
                    post: "",
                }
            }
        },
        mounted() {
            console.log('Componente montado.', this.user)
        },
        methods:{
            addPost(){
                const data = {
                    user_id: this.user.id,
                    post: this.post.post
                }
            },
        }
    }
</script>
