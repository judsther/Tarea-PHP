<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidosController extends Controller
{
    /*
     * Obtén la información detallada de los pedidos, incluyendo el nombre y correo electrónico de los usuarios. (con Eloquent)
     */
    public function index()
    {
        return Pedido::with('user')->get();
    }

    /*
     * Recuperar todos los pedidos asociados al usuario con ID 2. (con cualquier ID con Eloquent)
     */
    public function pedidosId(string $userIdPedidos)
    {
        try {
            $userIdPedidos = Pedido::where('user_id', $userIdPedidos)->get();

            return response()->json([
                'message' => 'Pedidos de usuario encontrados',
                'data' => $userIdPedidos
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => "Usuario no encontrado {$e->getMessage()}"
            ]);
        }
    }

    /*
     * funcion para crear nuevos pedidos
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'producto' => 'required|string|max:225',
                'cantidad' => 'required|integer',
                'total' => 'required|numeric',
            ]);

            //guardando el pedido
            $pedido = Pedido::create([
                'producto' => $request->producto,
                'cantidad' => $request->cantidad,
                'total' => $request->total,
                'user_id' => $request->user()->id
            ]);

            return response()->json([
                'message' => 'Pedido creado con éxito!',
                'pedido' => $pedido
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error:' . $e->getMessage()
            ], 400);
        }
    }

    /*
     * 4. Recupera todos los pedidos cuyo total esté en el rango de $100 a $250.
     */
    public function buscarRango(Request $request)
    {
        try {
            //validacion de datos requeridos
            $request->validate([
                'min' => 'required|numeric',
                'max' => 'required|numeric'
            ]);
            //Buscando los datos solicitados con Eloquent y guardandolo en la variable resultado
            $resultado = Pedido::where('total', '>=', $request->min)->where('total', '<=', $request->max)->get();

            //respuesta a mostrar al usuario
            return response()->json([
                'message' => 'Pedidos encontrados',
                'data' => $resultado
            ]);
        } catch (Exception $error) {
            return response()->json([
                'message' => "No se encontraron pedidos en el rango ingresado {$error->getMessage()}"
            ]);
        }
    }

    /*
     * Recupera todos los pedidos junto con la información de los usuarios, ordenándolos de forma descendente según el total del pedido. (usando query builder)
     */
    public function pedidosDescendente()
    {
        //con Join llamamos a la tabla users y con select los campos que queremos de cada tabla, y con el metodo orderBy ordenamos descendento o ascendente
        $resultado = DB::table('pedidos')->join('users', 'pedidos.user_id', '=', 'users.id')->select('pedidos.*', 'users.name as user_name')->orderBy('pedidos.total', 'desc')->get();

        return response()->json([
            'message' => "Todos los pedidos de usuario de mayor a menor:",
            'resultado' => $resultado
        ]);
    }

    /*
     * Obtén la suma total del campo "total" en la tabla de pedidos. (con Eloquent)
     */
    public function sumaTotal()
    {
        //método sum()
        $sumaTotal = Pedido::sum('total');

        return response()->json([
            'message' => 'Suma de total de pedidos ejecutada con éxito!',
            'suma total' => $sumaTotal
        ]);
    }

    /*
     * Encuentra el pedido más económico, junto con el nombre del usuario asociado. (con Query Builder)
     */
    public function pedidoMenor()
    {
        //primero guardamos en una variable el pedido con total minimo con el metodo min
        $pedidoMinimo = DB::table('pedidos')->min('total');
        //luego en otra variable buscamos los datos asociados al pedido con total minimo guardado
        $pedidoMinUsuario = DB::table('pedidos')
            ->where('total', $pedidoMinimo)
            ->join('users', 'pedidos.user_id', '=', 'users.id')
            ->select('pedidos.*', 'users.name as usuario')
            ->get();

        return response()->json([
            'message' => 'Pedido mínimo registrado:',
            'data' => $pedidoMinUsuario
        ]);
    }

    /*
    * Obtén el producto, la cantidad y el total de cada pedido, agrupándolos por usuario. (Query Builder)
    */
    public function agrupadoXusuario()
    {
        //usando metodos directos de MySQL especificos
        $respuesta = DB::table('users')
            ->join('pedidos', 'users.id', '=', 'pedidos.user_id')
            ->select('users.name', DB::raw('GROUP_CONCAT(pedidos.producto) as productos'), DB::raw('GROUP_CONCAT(pedidos.cantidad) as cantidad_por_producto'), DB::raw('GROUP_CONCAT(pedidos.total) as total_por_producto'), DB::raw('SUM(pedidos.total) as total_pago'))
            ->groupBy('users.id', 'users.name')
            ->get();

        return response()->json([
            'message' => 'pedidos agrupados por usuario',
            'result' => $respuesta
        ]);
    }
}
