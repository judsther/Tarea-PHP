<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /*
     * Obtener usuarios y pedidos
     */
    public function index()
    {
        return User::with('pedidos')->get();
    }

    /*
     * Registrar nuevo usuario
     */
    public function register(Request $request)
    {
        try {
            //validacion
            $request->validate([
                'name' => 'required|string|max:100',
                'email' => 'required|string|email|max:150|unique:users',
                'password' => 'required|string|min:8'
            ]);

            //guardando al nuevo usuario con los datos requeridos
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'message' => 'Te has registrado con éxito!',
                'data' => $user,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'mesage' => "Error al registrar usuario :( {$e->getMessage()}",
            ], 409);
        };
    }

    /*
     * iniciar sesion
     */
    public function login(Request $request)
    {
        try {
            //validamos la solicitud
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string'
            ]);
            $credentials = $request->only('email', 'password');

            //verificamos y si las credenciales no son correctas mostramos un mensaje
            if (!Auth::attempt($credentials)) {
                throw new Exception('Credenciales invalidas');
            }

            //si si son correctas obtenemos el usuario
            $user = $request->user();
            //le damos un token para su sesion
            $token = $user->createToken('token')->plainTextToken;

            //devolvemos los datos del usuario y su token
            return response()->json([
                'message' => 'Inició sesión con éxito',
                'user' => $user,
                'token' => $token
            ]);
        } catch (Exception $error) {
            return response()->json([
                'message' => "Lo sentimos, sucedió un error al intentar iniciar sesión. Intenta de nuevo más tarde {$error->getMessage()}"
            ], 409);
        }
    }

    /*
     * Cerrar sesion
     */
    public function logout(Request $request)
    {
        try {
            //Eliminamos el token
            $request->user()->tokens()->delete();
            //devolvemos un mensaje de éxito
            return response()->json([
                'message' => "Sesión cerrada con éxito. Vuelve pronto!"
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => "Error al intentar cerrar sesión {$e->getMessage()}"
            ]);
        }
    }

    /*
     * Encuentra todos los usuarios cuyos nombres comiencen con la letra "R". (metodo para buscar con cualquer inicial con Query Builder)
     */
    public function buscarInicial(string $inicial)
    {
        $resultado =
            DB::table('users')
            ->where('name', 'LIKE', $inicial . '%')
            ->get();

        return response()->json([
            'message' => 'Usuarios encontrados',
            'data' => $resultado
        ]);
    }


    /*
     * Calcula el total de registros en la tabla de pedidos para el usuario con ID 5. (Query Builder, cualquier ID)
     */
    public function registrosXusuario(string $userId)
    {

        //validando que haya pedidos con ese usuario
        if (DB::table('pedidos')->where('user_id', null)) {
            return response()->json([
                'message' => 'Usuario sin registros o no existe'
            ]);
        }

        //calculando registros con metodo count()
        try {
            $totalRegistros = DB::table('pedidos')->where('user_id', $userId)->count();

            return response()->json([
                'message' => "Total de pedidos del usuario {$userId}:",
                'total' => $totalRegistros
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error al buscar registro' . $e->getMessage()
            ]);
        }
    }
}
