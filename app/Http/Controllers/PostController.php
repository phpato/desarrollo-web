<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\Post;
use  App\Models\State;
use Exception;
use Validator;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function posts()
    {
        $states = State::all();
        return view("post", compact("states"));
    }

    public function index(int $userId)
    {
        $states = State::all();
        return view("my-post", compact("states"));

    }

    //obtiene los posts con el usuario que lo hizo y el state debe ser publicado, (llenado inicialmente con el StateSeeder)
    public function getPosts()
    {
        try {
            $posts = Post::with(["user", "state"])->where("state_id", 2)->orderBy("created_at", "DESC")->get();
            return response()->json($posts);
            
        } catch ( Exception $e ) {
            throw $e;
        }
    }

    //todos los posts del usuario logueado y con su respectivo state (solo el mismo usuario puede ver sus borradores y archivados) 
    public function getPostsFromUser(int $userId)
    {
        try {
            $posts = Post::with(["state"])->where("user_id", auth()->user()->id)->orderBy("created_at", "DESC")->get();
            return response()->json($posts);
        } catch ( Exception $e ) {
            throw $e;
        }
    }

    public function create(Request $request)
    {
        try {
            //validacion formulario con mensajes custom
            $validator = Validator::make($request->all(), [
                'post' => 'required|min:1|max:5000',
                'state_id' => 'required|integer',
            ], [
                'post.required' => 'Debe ingresar un post',
                'state_id.required' => 'Debe ingresar un estado del post'
            ]);
            //si la validacion del formulario falla no hace nada
            if( $validator->fails() ){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validator->errors()
                ], 401);
            }
            $post = new Post();
            $post->post = $request->post;
            $post->user_id = auth()->user()->id;
            $post->state_id = $request->state_id;
            $post->save();
            return response()->json($post);
        } catch ( Exception $e ) {
            throw $e;
        }
    }

    public function update(Request $request, int $postId)
    {
        try {
            //validacion formulario con mensajes custom
            $validator = Validator::make($request->all(), [
                'post' => 'required|min:1|max:5000',
                'state_id' => 'required|integer',
            ], [
                'post.required' => 'Debe ingresar un post',
                'state_id.required' => 'Debe ingresar un estado del post'
            ]);
            //si la validacion del formulario falla no hace nada
            if( $validator->fails() ){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validator->errors()
                ], 401);
            }
            $post = Post::find($postId);
            $post->post = $request->post;
            $post->state_id = $request->state_id;
            $post->save();
            return response()->json($post);
        } catch ( Exception $e ) {
            throw $e;
        }
    }

    public function delete(Request $request, int $postId)
    {
        try {
            $post = Post::find($postId);
            if($post){
                $post->delete();
            }
            return response()->json(["status" => true]);
        } catch ( Exception $e ) {
            throw $e;
        }
    }
}
