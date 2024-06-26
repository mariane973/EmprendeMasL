@extends('layouts.navbar')
@section('titulo', 'Inventario')
@section('content')
@can('accesoVendedor')
<section>
  <div class="InicioSesion container">
    <div class="row text-center mb-5">
      <div class="Sec_Emp col-lg-2 col-sm-6 col-md-12 d-flex align-items-center justify-content-center">
        <i class="fas fa-shirt icono me-1 me-1 font-size: 18px;"></i>
        <a href="/productos" class="fw-bold" style="color: #33B66C;  font-size: 18px;">Productos</a>
        <hr class="w-200">
      </div>
      <div class="Sec_Zona col-lg-2 col-sm-5 col-md-6 me-3 d-flex align-items-center justify-content-center">
        <i class="fas fa-guitar icono me-1" style="font-size: 20px; color: #33B66C;"></i>
        <a href="/servicios" class="fw-bold" style="color: #33B66C;  font-size: 18px;">Servicios</a>
      </div>
      <div class="Sec_Emp col-lg-2 col-sm-6 col-md-6 mb-sm-1 d-flex align-items-center justify-content-center">
        <i class="fas fa-shop icono me-1" style="font-size: 17px; color:  #33B66C;"></i>
        <a href="/emprendimientos" class="fw-bold" style="color:  #33B66C;  font-size: 18px;">Emprendimientos</a>
      </div>
      <div class="dropdown col-lg-2 me-2 d-flex align-items-center justify-content-center" id="userDropdown">
        <i class="fas fa-tag icono me-1" style="color: #33B66C;"></i>
        <a href="#" class="fw-bold" style="color: #33B66C;  font-size: 18px;">Ofertas</a>
        <div class="dropdown-content">
          <a href="/ofertas" class="fw-bold" style="color:#33B66C ;  font-size: 15px;">Ofertas productos</a>
          <a href="/ofertas_servicios" class="fw-bold" style="color: #33B66C;  font-size: 16px;">Ofertas servicios</a>
        </div>
      </div>
      <div class="Sec_Ofe col-lg-1 col-sm-6 col-md-6 me-4 d-flex align-items-center justify-content-center">
        <i class="fas fa-scroll icono me-1" style="color: #33B66C;"></i>
        <a href="/pedidos_index" class="fw-bold" style="color: #33B66C;  font-size: 18px;">Pedidos</a>
      </div>
      @can('agregarVendedor')
      <div class="Sec_Ofe col-lg-2 col-sm-6 col-md-6  d-flex align-items-center justify-content-center">
        <i class="fas fa-clipboard icono me-1" style="color: green; "></i>
        <a href="/inventario" class="fw-bold" style="color: green;  font-size: 18px;">Inventario</a>
      </div>
      @endcan
    </div>
  </div>
</section>

<div class="container">
    <h3 class="fw-semibold mb-5 text-center">Inventario</h3>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventario as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->nombre }}</td>
                <td>{{ $item->descripcion }}</td>
                <td>
                    <form action="{{ route('inventario.actualizarStock', $item->id) }}" method="POST">
                        @csrf
                        @method('put')
                        <input type="number" name="stock" value="{{ $item->stock }}" class="form-control">
                </td>
                <td>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
    <div class="alert alert-success text-center mx-5" role="alert">
    Acceso no Autorizado
    </div>
@endcan
@endsection
