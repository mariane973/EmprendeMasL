<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Vendedore;
use Illuminate\Support\Facades\Auth;

class Emprendimientoslist extends Component
{
    public $vendedorCont;

    public function render()
    {
        $user = Auth::user();

        if (Auth::check() && $user->hasRole('Vendedor')) {
            $this->vendedorCont = Vendedore::where('user_id', $user->id)->get();
        } else {
            $this->vendedorCont = Vendedore::all();
        }

        return view('livewire.emprendimientoslist');
    }

    public $id_eliminacion;

    protected $listeners = ['confirmacionEliminacion'=>'eliminarEmprendimiento'];

    public function eliminacion($id) {
        $this->id_eliminacion = $id;
        $this->dispatchBrowserEvent('eliminacion-emprendimiento');
    }

    public function eliminarEmprendimiento() {
        $emprendimiento = Vendedore::where('id', $this->id_eliminacion)->first();
        $emprendimiento->delete();

        $this->dispatchBrowserEvent('emprendimientoEliminado');
    }
}