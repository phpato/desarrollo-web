<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\User;
use  App\Models\Post;
use Exception;
use Validator;

class UserController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('user');
    }

    public function getUsers()
    {
        try {
            $users = User::orderBy("created_At", "DESC")->get();
            return response()->json($users);
        } catch ( Exception $e ) {
            throw $e;
        }
    }

    public function create(Request $request)
    {
        try {
            //validacion formulario con mensajes custom
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:1|max:200',
                'email' => 'required|email|unique:users',
            ], [
                'name.required' => 'Debe ingresar un nombre',
                'email.required' => 'Debe ingresar un email',
                'email.email' => 'Debe ingresar un email valido',
                'email.unique' => 'El email ingresado ya se encuentre en uso'
            ]);
            //si la validacion del formulario falla no hace nada
            if( $validator->fails() ){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validator->errors()
                ], 401);
            }
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt("12345678");
            $user->save();
            return response()->json($user);
        } catch ( Exception $e ) {
            throw $e;
        }
    }

    public function update(Request $request, int $postId)
    {
        try {
            //validacion formulario con mensajes custom
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:1|max:200',
            ], [
                'name.required' => 'Debe ingresar un nombre',
            ]);
            //si la validacion del formulario falla no hace nada
            if( $validator->fails() ){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validator->errors()
                ], 401);
            }
            $user = User::find($postId);
            $user->name = $request->name;
            $user->save();
            return response()->json($user);
        } catch ( Exception $e ) {
            throw $e;
        }
    }

    public function delete(Request $request, Int $userId)
    {
        try {
            $user = User::find($userId);
            if($user){
                $user->delete();
            }
            return response()->json(["status" => true]);
        } catch ( Exception $e ) {
            throw $e;
        }
    }
}
