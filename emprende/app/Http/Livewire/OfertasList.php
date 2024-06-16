<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\CarritoCompra;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;

class OfertasList extends Component
{
    public $ofertaCont;

    public function render()
    {
        $this -> ofertaCont = Producto::where('oferta', true)->get();
        
        return view('livewire.ofertas-list');
    }

    public function agregarCarro($id)
    {
        if (auth()->user()) {

            $data = [
                'user_id' => auth()->user()->id,
                'producto_id' => $id,
            ];
            
            CarritoCompra::updateOrCreate($data);

            $this->emit('updateCartCount');

            session()->flash('success', 'Oferta agregada al carrito exitosamente.');
        }
    }
    public $id_eliminacion;

    protected $listeners = ['confirmacionEliminacion'=>'eliminarProducto'];

    public function eliminacion($id) {
        $this->id_eliminacion = $id;
        $this->dispatchBrowserEvent('eliminacion-producto');
    }

    public function eliminarProducto() {
        $producto = Producto::where('id', $this->id_eliminacion)->first();
        $producto->delete();

        $this->dispatchBrowserEvent('productoEliminado');
    }    
}
