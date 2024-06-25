@extends('administrador.admin')

@section('content')
<main class="d-flex w-100">
  <div class="container d-flex flex-column">
    <div class="row vh-110">
      <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
        <div class="d-table-cell align-middle">
          <div class="text-center mt-4">
            <h1 class="h2">Modificar Producto</h1>
            <p class="lead">
              Asegurese de ingresar los marcas correctos
            </p>
          </div>
          <div class="card">
            <div class="card-body">
              <div class="m-sm-4">
                <form action="{{ route('marca.update', $marca->id) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  <div class="mb-3">
                    <p class="form-label">Nombre</p>
                    <input class="form-control form-control-lg" type="text" name="nombre" value="{{ $marca->nombre }}" placeholder="Ingrese el nombre del producto" />
                    @error('nombre')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </div>
                  <div class="text-center mt-3">
                    <button type="submit" class="btn btn-lg btn-primary">Guardar</button>
                    <a href="{{ url('administrador/marca') }}" class="btn btn-primary float-end">Volver</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection
