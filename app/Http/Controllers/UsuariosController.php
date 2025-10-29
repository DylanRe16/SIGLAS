<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
//use App\Models\Sucursales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\Facades\DB;

class UsuariosController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth');
    }
    // public function PrimerUsuario()
    // {
    //     //$usuario = User::first();
    //     //return view('usuarios.primer-usuario', ['usuario' => $usuario]);
    //     User::create([
    //         'name' => 'Felix Medina',
    //         'email' => 'admin@gmail.com',
    //         'foto'=> '',
    //         'estado'=> '1',
    //         'ultimo_login'=> '',
    //         'rol'=> 'Administrador',
    //         'password'=> Hash::make('12345678'),
    //         'id_sucursal'=> 0,
    //     ]);
    // }
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     if (auth()->user()->rol != 'Administrador') {
    //         return redirect('inicio');
    //     }

    //     $usuarios = User::all();
    //     $sucursales = Sucursales::where('estado', 1)->get();

    //     return view('modulos.users.usuarios', compact('usuarios', 'sucursales'));
    // }

    public function actualizarMisDatos(Request $request)
    {
        // $datos = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255',
        //     'password' => 'nullable|string|min:8',
        // ]);
        /**
         * Actualiza la información del perfil del usuario autenticado.
         *
         * Este método maneja la solicitud para actualizar la información del perfil del usuario autenticado,
         * incluyendo nombre, correo electrónico, contraseña y foto de perfil. Realiza la validación de los datos
         * de entrada y actualiza la información del usuario en la base de datos.
         *
         * @return \Illuminate\Http\RedirectResponse Redirige a la ruta 'mis-datos' después de actualizar la información del usuario.
         */
         
        // Recupera los datos de la solicitud
        $datos = $request;

        // Verifica si el correo electrónico del usuario autenticado es diferente del correo solicitado
        if(auth()->user()->email != $request->email){

            // Si se proporciona una contraseña en la solicitud
            if($request->password){
            
            // Valida los datos de la solicitud con contraseña
            // $request->validate([
            //     'name' => ['required', 'string', 'max:50'],
            //     'email' => ['required', 'string', 'email', 'unique:users'],
            //     'password' => ['required', 'string', 'min:8'],
            // ]);
            
            } else {

            // Valida los datos de la solicitud sin contraseña
            // $request->validate([
            //     'name' => ['required', 'string', 'max:50'],
            //     'email' => ['required', 'string', 'email', 'unique:users']
            // ]);
            
            }
        } else {

            // Si el correo electrónico del usuario autenticado es el mismo que el correo solicitado
            if($request->password){
            
            // Valida los datos de la solicitud con contraseña
            // $request->validate([
            //     'name' => ['required', 'string', 'max:50'],
            //     'email' => ['required', 'string', 'email'],
            //     'password' => ['required', 'string', 'min:8'],
            // ]);
            
            // } else {

            // // Valida los datos de la solicitud sin contraseña
            // $request->validate([
            //     'name' => ['required', 'string', 'max:50'],
            //     'email' => ['required', 'string', 'email']
            // ]);
            
             }
        }
        //$rutaImg="foto";
        // Verifica si se proporciona una foto de perfil en la solicitud
        if($request->fotoPerfil){

            // Si el usuario autenticado ya tiene una foto de perfil, elimina la antigua
            if(auth()->user()->foto){
                $path = storage_path('app/public/users/'.basename(auth()->user()->foto));
                if (file_exists($path)) {
                    unlink($path);
                }
            }
        
            // Almacena la nueva foto de perfil y obtiene su ruta
            $rutaImg = $request->file('fotoPerfil')->store('users', 'public');
            $rutaImg = 'storage/' . $rutaImg; // Obtener la URL correcta del archivo almacenado
        
        } else {
            // Si no se proporciona una nueva foto de perfil, mantiene la antigua
            $rutaImg = auth()->user()->foto;
        }

        // Verifica si se proporciona una contraseña en los datos de la solicitud
        if (isset($request->password)) {

            // Actualiza la información del usuario en la base de datos con contraseña
            // DB::table('users')
            // ->where('id', auth()->user()->id)
            // ->update([
            //     'name' => $datos['name'],
            //     'email' => $datos['email'],
            //     'password' => Hash::make($datos['password']),
            //     'foto' => $rutaImg
            // ]);
            User::where('id', auth()->user()->id)
                ->update([
                    'name' => $request->nombre,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'foto' => $rutaImg
                ]);

        } else {

            // Actualiza la información del usuario en la base de datos sin contraseña
            // DB::table('users')
            // ->where('id', auth()->user()->id)
            // ->update([
            //     'name' => $datos['name'],
            //     'email' => $datos['email'],
            //     'foto' => $rutaImg
            // ]);

            User::where('id', auth()->user()->id)
                ->update([
                    'name' => $request->nombre,
                    'email' => $request->email,
                    'foto' => $rutaImg
                ]);
        }
        


        /*User::where('id', auth()->user()->id)
        ->update([
            'name' => $request->nombre,
            'email' => $request->email
        ]);*/


        return redirect('mis-datos')->with('success', 'Mis Datos fueron actualizados correctamente');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validarEmail= request()->validate([
            //'email' => 'required|string|email|max:255|unique:users',
            'email' => 'unique:users',
        ]);

        // $datos = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255',
        //     'password' => 'required|string|min:8',
        //     'rol' => 'required|string',
        //     'id_sucursal' => 'required|integer',
        // ]);
        $datos = request();
        //print_r($datos);
        if ($datos->rol == 'Administrador') {
            
            $id_sucursal = 0;
        }else{
            $id_sucursal = $datos->id_sucursal;
        }

        User::create([
            'name' => $datos->name,
            'email' => $validarEmail['email'],
            'id_sucursal'=> $id_sucursal,
            'foto'=> '',
            'password'=> Hash::make($datos->password),
            'estado'=> '1',
            'ultimo_login'=> null,
            'rol'=> $datos->rol
        ]);

        return redirect('usuarios')->with('success', 'El Usuario ha sido Creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    //public function show(string $id)
    public function cambiarEstado($id_usuario, $estado)
    {
        
        User::find($id_usuario)->update([
            'estado' => $estado
        ]);
        
        //return redirect('usuarios');
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_usuario)
    {
        $usuario = User::find($id_usuario);
        return response()->json($usuario);
    }
   
    public function verificarUsuario(Request $request)
    {
        //$usuario = User::where('email', $request->email)->first();
        $user = User::find($request->id);

        if ($request->email != $user["email"]) {
            
            $emailExiste = User::where('email', $request->email)->exists();

            if($emailExiste != null){
                $verificacion = false;
            }else {
                $verificacion = true;
            }
        }else {
            $verificacion = true;
        }
        
        return response()->json(['emailVerificacion' => $verificacion]);
        //return response()->json($verificacion);

    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if (request('password')) {

            $validarPass = request()->validate([
                'password' => ["string", "min:8"],
            ]);
           
            $pass = true;

        }else {
            $pass = false;
        }
        

        $datos = request();

        if ($datos["rol"] == 'Administrador') {
            
            $id_sucursal = 0;
        }else{
            $id_sucursal = $datos['id_sucursal'];
        }

        $User = User::find($datos["id"]);
        $User->name = $datos["name"];
        $User->email = $datos["email"];
        $User->id_sucursal = $id_sucursal;
        $User->rol = $datos["rol"];

        if ($pass != false) {
            $User->password = Hash::make($datos["password"]);
        }

        $User->save();

        return redirect('usuarios')->with('success', 'El Usuario ha sido Actualizado correctamente');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $usuario = User::find($id);
        if($usuario->foto){
            $path = storage_path('app/public/users/'.basename($usuario->foto));
            if (file_exists($path)) {
                unlink($path);
            }
        }

        User::destroy($id);

        return redirect('usuarios')->with('success', 'El Usuario ha sido Eliminado correctamente');
    }
}
