@extends('layouts.navbar')
@section('titulo', 'Productos')
@section('content')
<section>
    <div class="Section_Nav container">
        <div class="row text-center">
            <div class="Sec_Pro offset-lg-2 col-lg-2 col-sm-6 mb-sm-1">
                <img src="imagenes/caja.png" alt="">
                <a href="/productos">Productos</a>
                <hr>
            </div>
            <div class="Sec_Emp col-lg-2 col-sm-6 mb-sm-1">
                <img src="imagenes/cohete.png" alt="">
                <a href="/emprendimientos">Emprendimientos</a>
            </div>
            <div class="Sec_Ofe col-lg-2  col-sm-6 mb-sm-5">
                <img src="imagenes/oferta.png" alt="">
                <a href="/ofertas">Ofertas</a>
            </div>
            <div class="Sec_Zona col-lg-2  col-sm-6 mb-sm-5">
                <img src="imagenes/mapa.png" alt="">
                <a href="">En tu Zona</a>
            </div>
        </div>
    </div>
</section>

<livewire:productlist />

@endsection