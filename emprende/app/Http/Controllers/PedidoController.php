<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Vendedore;
use App\Models\Producto;
use App\Models\Servicio;
use App\Models\CarritoCompra;
use App\Models\User;


class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $userId = $user->id;

        if ($user->hasRole('Vendedor')){
            $pedidos = Pedido::where('id_vendedor', $userId)->get();
        }elseif($user->hasRole('Cliente')){
            $pedidos = Pedido::where('id_cliente', $userId)->get();
        }

        return view('pedidos.index', compact('pedidos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
{
    $productoId = $request->input('producto_id');
    $servicioId = $request->input('servicio_id');
    $cantidad = $request->input('cantidad'); 
    $total = $request->input('total');

    $producto = Producto::find($productoId);
    $servicio = Servicio::find($servicioId);
    
    if (!$producto && !$servicio) {
        return redirect()->back()->with('error', 'Ni el producto ni el servicio seleccionados existen.');
    }

    $vendedor = null;
    $precioProducto = 0;
    $precioServicio = 0;

    if ($producto) {
        $vendedor = $producto->vendedor;
        $precioProducto = $producto->precio;
    }

    if ($servicio) {
        $vendedor = $servicio->vendedor;
        $precioServicio = $servicio->precio;
    }

    if (!$vendedor) {
        return redirect()->back()->with('error', 'El vendedor asociado no existe.');
    }

    $valorTotalProducto = 0;
    $valorTotalServicio = 0;

    if ($producto) {
        $valorTotalProducto = $producto->valor_final * $cantidad;
    }

    if ($servicio) {
        $valorTotalServicio = $servicio->valor_final * $cantidad;
    }

    return view('pedidos.create', [
        'producto' => $producto,
        'servicio' => $servicio,
        'cantidad' => $cantidad,
        'valorTotalProducto' => $valorTotalProducto,
        'valorTotalServicio' => $valorTotalServicio,
        'total' => $total,
        'id_vendedor' => $vendedor->id,
    ]);
}
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string',
        'email' => 'required|email',
        'direccion' => 'required|string',
        'telefono' => 'required|integer|min:1',
        'ciudad' => 'required|string',
        'cantidad' => 'required|integer|min:1',
        'valor' => 'required|numeric|min:0',
        'producto' => 'required|string',
        'id_vendedor' => 'required|integer',
    ]);

    
    $producto = Producto::where('nombre', $request->get('producto'))->first();

    if (!$producto) {
        return redirect()->back()->with('error', 'El producto seleccionado no existe.');
    }

    $vendedor = $producto->vendedor;

    if (!$vendedor) {
        return redirect()->back()->with('error', 'El producto seleccionado no tiene un vendedor asociado.');
    }

    $id_vendedor = $vendedor->user_id;
    $cliente = auth()->user(); 

    $pedido = new Pedido();
    $pedido->nombre_cl = $request->get('nombre');
    $pedido->email_cl = $request->get('email');
    $pedido->direccion = $request->get('direccion');
    $pedido->ciudad = $request->get('ciudad');
    $pedido->telefono = $request->get('telefono');
    $pedido->nombre_producto = $producto->nombre;
    $pedido->cantidad = $request->get('cantidad');
    $pedido->estado = 'Pedido Recibido';
    $pedido->precio = $request->get('precio');
    $pedido->total = $request->get('valor');

   
    $pedido->id_vendedor = $id_vendedor; 
    $pedido->id_cliente = $cliente->id;  

    $pedido->save();

    $producto->stock -= $request->get('cantidad');
    $producto->save();

    $this->eliminarItemDelCarrito($cliente->id);

    return redirect()->route('productos.index')->with('success', 'Pedido realizado con éxito');
}

    private function eliminarItemDelCarrito($clienteId)
    {
        CarritoCompra::where('user_id', $clienteId)->delete();
    }

    public function actualizarEstado(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido -> estado = $request->get('estado');

        $pedido -> save();

        return redirect()->route('pedidos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
