@extends('cliente.clienterv')
@section('content')
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
{{-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> --}}
<link rel="shortcut icon" href="assets/images/logo/CosmicVR-AI-App.png" type="image/svg+xml">
<script src="https://aframe.io/releases/1.0.4/aframe.min.js"></script>
<script src="https://raw.githack.com/AR-js-org/AR.js/master/aframe/build/aframe-ar.js"></script>
<script src="gesture-detector.js"></script>
<script src="gesture-handler.js"></script>
<body id="top">
  <script>
    function goBack() {
      window.history.back();
    }

  </script>
</body>
</html>
<!-- SECTION -->
<div class="section">
  <div class="container">
    <div class="row">
      <div class="col-md-5 col-md-push-2">
        <div class="product-preview">

        </div>
      </div>
      <div class="col-md-2 col-md-pull-2">
        {{-- <model-viewer id="miModelViewer" alt="ropa" src="{{ asset('public/img/' . $producto->modelo) }}" ar ar-modes="webxr scene-viewer quick-look" seamless-poster shadow-intensity="1" camera-controls ar ar-modes="webxr quick-look" ar-button ar-placement="floor" progress-bar style="width: 100%; height: 400px;">
        </model-viewer> --}}
         <a-scene arjs embedded renderer="logarithmicDepthBuffer: true;" vr-mode-ui="enabled: false" gesture-detector id="scene">
           <a-assets>
             <!-- Añadir tu propio modelo 3D (reemplaza 'ruta-de-tu-modelo.glb' por la URL o ruta a tu modelo) -->
             <a-asset-item id="custom-model" src="{{ asset('public/img/' . $producto->modelo) }}"></a-asset-item>

           </a-assets>

           <a-marker preset="hiro" raycaster="objects: .clickable" emitevents="true" cursor="fuse: false; rayOrigin: mouse;" id="markerA">
             <!-- Añadir un plano de fondo -->
             <!-- <a-plane position="0 0 -0.1" rotation="-90 0 0" width="2.5" height="2.5" color="red" shadow="receive: true"></a-plane> -->

             <!-- Agregar tu modelo 3D personalizado -->
             <a-entity id="custom-model" gltf-model="#custom-model" position="0 0 0" scale="0.03 0.03 0.03" class="clickable" gesture-handler></a-entity>

             <!-- Agregar un título para el modelo -->
             <a-entity text="value: Tu Modelo 3D; color: red; align: center; width: 4" position="0 0.15 -0.1"></a-entity>
           </a-marker>

           <a-entity camera></a-entity>
         </a-scene>

      </div>
      <div class="col-md-5" style="color: #000000">
        <div class="product-details">
          <h2 class="product-name">{{ $producto->name }}</h2>
          <div>
            @if ($producto->idpromocion != '')
            @foreach ($promociones as $promocion)
            @if ($producto->idpromocion == $promocion->id)
            <?php $descuento = $promocion->descuento / 100; ?>
            <h3 class="product-price">Bs
              {{ $producto->precioUnitario - $producto->precioUnitario * $descuento }}
              <del class="product-old-price">Bs {{ $producto->precioUnitario }}</del>
            </h3>
            @endif
            @endforeach
            @else
            <h3 class="product-price">Bs {{ $producto->precioUnitario }}
              @endif
              @if ($producto->stock != 0)
              <span class="product-available">En stock</span>
              @else
              <span class="product-available">No en stock</span>
              @endif
          </div>
          <p>{{ $producto->descripcion }}</p>
          <div class="add-to-cart">
            <form action="{{ route('detalleCarrito.store') }}" method="POST" enctype="multipart/form-data" id="add">
              @csrf
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
      </div>
    </div>
  </div>
</div>
</div>
</div>
@endsection
