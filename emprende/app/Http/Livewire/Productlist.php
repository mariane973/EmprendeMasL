<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Producto;
use App\Models\CarritoCompra;
use Illuminate\Support\Facades\Auth;

class Productlist extends Component
{
    public $productoCont;

    public function render()
    {
        $user = Auth::user();

        if (Auth::check() && $user->hasRole('Vendedor')) {
            $this->productoCont = Producto::where('vendedor_id', $user->id)->get();
        } else {
            $this->productoCont = Producto::all();
        }

        return view('livewire.productlist');
    }

    public function agregarCarro($id){
        if(auth()->user()){
            $data = [
                'user_id' => auth()->user()->id,
                'producto_id' => $id,
            ];
            CarritoCompra::updateOrCreate($data);
            
            $this->emit('updateCartCount');

            session()->flash('success','Producto agregado al carrito exitosamente.');
        }
    }
}
