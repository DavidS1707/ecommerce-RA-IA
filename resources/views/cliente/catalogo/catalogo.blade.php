@extends('cliente.cliente')
@yield('content')
<link rel="stylesheet" href="https://7f7c-181-41-144-10.ngrok-free.app/public/assets/css/style-prefix.css">



@section('content')
<!-- BREADCRUMB -->
<div id="breadcrumb" class="section">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h3 class="breadcrumb-header">Catálogo</h3>
        <ul class="breadcrumb-tree">
          <li><a href="{{ url('/home') }}">Home</a></li>
          <li class="active">Catálogo</li>
        </ul>
      </div>
    </div>
  </div>
</div>
<!-- /BREADCRUMB -->

<!-- store products -->
<div class="row">
  @php
  $c = 0;
  $a = 0;
  @endphp
  @foreach ($productos as $producto)
  @php
  $c++;
  $a++;
  @endphp
  <!-- product -->
  <div class="col-md-4 col-xs-6">
    <div class="product">
      <div class="product-img">
        <!-- script js -->
        <script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js">
        </script>
        <ul class="grid-list">
          <li>
            <div class="product-card">
              <div class="card-banner img-holder" style="--width: 160; --height: 260;background-color: rgb(255, 255, 255);">
                <model-viewer id="miModelViewer" alt="ropa" src="{{ asset('public/img/' . $producto->modelo) }}" ar ar-modes="webxr scene-viewer quick-look" seamless-poster shadow-intensity="1" camera-controls ar ar-modes="webxr quick-look" ar-button ar-placement="floor" progress-bar width="150px" height="150px">
                </model-viewer>

                {{-- <img src="{{ asset('public/img/' . $producto->imagen) }}" alt="" width="150px" height="150px"> --}}


              </div>
            </div>
          </li>
        </ul>

        <div class="product-label">
          @if ($producto->idpromocion != '')
          @foreach ($promociones as $promocion)
          @if ($producto->idpromocion == $promocion->id)
          <span class="sale">-{{ $promocion->descuento }}%</span>
          @php $descuento = $promocion->descuento / 100; @endphp
          @endif
          @endforeach
          @endif
          @if ($producto->stock == 0)
          <span class="new">Sin Stock</span>
          @endif
        </div>
      </div>
      <div class="product-body">
        @foreach ($categorias as $categoria)
        @if ($categoria->id == $producto->idcategoria)
        <p class="product-category">{{ $categoria->nombre }}</p>
        @endif
        @endforeach
        <h3 class="product-name"><a href="#">{{ $producto->name }}</a></h3>
        @if ($producto->idpromocion != '')
        <h4 class="product-price">Bs
          {{ $producto->precioUnitario - $producto->precioUnitario * $descuento }}
          <del class="product-old-price">Bs {{ $producto->precioUnitario }}</del>
        </h4>
        @else
        <h4 class="product-price">Bs {{ $producto->precioUnitario }}
        </h4>
        @endif
        <div class="product-rating">
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
        </div>
        <div class="product-btns">
          <button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">add to
              wishlist</span></button>
          <button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">add to
              compare</span></button>
          <button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">
              <a href="{{ route('catalogo.show', $producto->id) }}" style="color: white">quick view</a> </span></button>
          <form action="{{ route('detalleCarrito.store') }}" method="POST" enctype="multipart/form-data" id="create{{ $a }}">
            @csrf
            <input type="number" id="cantidad" name="cantidad" min="1" max="1000" value="1">
            @if ($producto->idpromocion != '')
            <input type="hidden" name="precio" id="precio" value="{{ $producto->precioUnitario - $producto->precioUnitario * $descuento }}">
            @else
            <input type="hidden" name="precio" id="precio" value="{{ $producto->precioUnitario }}">
            @endif
            <input type="hidden" name="idProducto" id="idProducto" value="{{ $producto->id }}">
            @auth
            <input type="hidden" name="idCarrito" id="idCarrito" value="{{ $carrito->id }}">
            @endauth
          </form>
        </div>
      </div>
      <div class="add-to-cart">
        <button class="add-to-cart-btn" form="create{{ $a }}"><i class="fa fa-shopping-cart"></i>
          añadir</button>
      </div>
    </div>
  </div>
  @if ($c == 3)
  <div class="col-md-12 col-xs-6">
    <div class="product">
    </div>
  </div>
  @php
  $c = 0;
  @endphp
  @endif
  @endforeach
  <div class="col-md-12 col-xs-6">
    <div class="product">
    </div>
  </div>
</div>

<div class="pagination justify-content-end">
  {!! $productos->links() !!}
</div>
@endsection
