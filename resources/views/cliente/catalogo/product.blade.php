@extends('cliente.cliente')
@extends('cliente.header')
@section('content')
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>
<link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
<script src="https://aframe.io/releases/1.0.4/aframe.min.js"></script>
<script src="https://raw.githack.com/AR-js-org/AR.js/master/aframe/build/aframe-ar.js"></script>

<script src="/js/gesture-detector.js"></script>
<script src="/js/gesture-handler.js"></script>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<!-- Modal -->
<div id="breadcrumb" class="section">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h3 class="breadcrumb-header">{{ $producto->name }}</h3>
        <ul class="breadcrumb-tree">
          <li><a href="{{ url('/home') }}">Home</a></li>
          <li class="">Producto</li>
          <li class="active">{{ $producto->name }}</li>
        </ul>
      </div>
    </div>
  </div>
</div>


<!-- SECTION -->
<div class="section">
  <div class="container">
    <div class="row">
      <div class="col-md-5 col-md-push-2">
        <div class="product-preview">
          {{-- <a-scene arjs embedded renderer="logarithmicDepthBuffer: true;" vr-mode-ui="enabled: false" gesture-detector id="scene">
            <a-assets>
              <a-asset-item id="bowser" src="{{ asset('public/img/' . $producto->modelo) }}">
          </a-asset-item>
          </a-assets>
          <a-marker preset="hiro" raycaster="objects: .clickable" emitevents="true" cursor="fuse: false; rayOrigin: mouse;" id="markerA">
            <a-entity id="bowser-model" gltf-model="#bowser" position="0 0 0" scale="0.05 0.05 0.05" class="clickable" gesture-handler>
            </a-entity>
          </a-marker>
          <a-entity camera></a-entity>
          </a-scene> --}}
        </div>
      </div>
      <div class="col-md-2 col-md-pull-2">
        {{-- <model-viewer id="miModelViewer" alt="ropa" src="{{ asset('public/img/' . $producto->modelo) }}" ar
        ar-modes="webxr scene-viewer quick-look" seamless-poster shadow-intensity="1" camera-controls ar
        ar-modes="webxr quick-look" ar-button ar-placement="floor" progress-bar
        style="width: 100%; height: 400px;">
        </model-viewer> --}}
        <img src="{{ asset('public/img/' . $producto->imagen) }}" alt="" width="200" height="200">
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
              <div class="qty-label">
                Cantidad
                <div class="input-number">
                  <input type="number" id="cantidad" name="cantidad" min="1" max="1000" value="1">
                  <span class="qty-up">+</span>
                  <span class="qty-down">-</span>
                </div>
              </div>
              <button class="add-to-cart-btn" form="add"><i class="fa fa-shopping-cart"></i>
                Añadir</button>
            </form>
            <br>

            <button id="openModalBtn" class="bg-black hover:bg-red-400 text-white font-bold py-2 px-4 rounded border border-white flex items-center">
              <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10 20c-5.523 0-10-4.477-10-10s4.477-10 10-10 10 4.477 10 10-4.477 10-10 10zm0-18c-4.418 0-8 3.582-8 8s3.582 8 8 8 8-3.582 8-8-3.582-8-8-8zm1 12h-2v-1h2v1zm0-3h-2v-5h2v5z" />
              </svg>
              RA Provador de ropa
            </button>
          </div>
          <ul class="product-links">
            <li>Categoría:</li>
            @foreach ($categorias as $categoria)
            @if ($producto->idcategoria == $categoria->id)
            <li><a href="{{ route('categoriaShow.show', $categoria->id) }}">{{ $categoria->nombre }}</a>
            </li>
            @endif
            @endforeach
            <li>Marca:</li>
            @foreach ($marcas as $marca)
            @if ($producto->idmarca == $marca->id)
            <li>{{ $marca->nombre }}</li>
            @endif
            @endforeach
          </ul>
          <ul class="product-links">
            <li style="color: #fff">Share:</li>
            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
            <li><a href="#"><i class="fa fa-envelope"></i></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="myModal" class="fixed inset-0 z-50 flex justify-center items-center bg-gray-500 bg-opacity-75 hidden">
  <div class="modal-content bg-white w-full md:max-w-2xl p-6 md:p-10 rounded-lg shadow-lg flex flex-col items-center">
    <div class="flex justify-between items-center w-full mb-4">
      <h2 class="text-2xl md:text-3xl font-bold text-gray-800">¡Bienvenido al Probador Virtual!</h2>
      <button id="closeModalBtn" class="text-gray-600 hover:text-gray-800">
        <svg class="h-6 w-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
          <path d="M14.7 5.3a1 1 0 010 1.4L11.42 10l3.3 3.3a1 1 0 01-1.4 1.4l-3.3-3.3-3.3 3.3a1 1 0 01-1.4-1.4l3.3-3.3-3.3-3.3a1 1 0 111.4-1.4l3.3 3.3 3.3-3.3a1 1 0 011.4 0z" />
        </svg>
      </button>
    </div>

    <div class="flex flex-col items-center">
      <p class="text-gray-700 leading-relaxed text-center mb-4">Escanea el código QR para explorar nuestro
        probador virtual de ropa antes de comprar.</p>
      <a href="{{ asset('cliente/img/qr.png') }}" download="hiro.png" id="downloadLink" class="mb-4">
        <img src="{{ asset('cliente/img/qr.png') }}" alt="Código QR" class="w-40 h-40 rounded-lg border-4 border-blue-500">
      </a>



      <p>Ingresa desde tu dispositivo movil haciendo click en la camara de abajo o copiando el siguiente link:
        "https://pericena.github.io/declaracion/datos/index3.html" para poder escanear el código QR



      </p>

      @if(isset($producto))
      {{-- <a href="{{ route('productrv', ['id1' => $producto->id, 'id2' => $producto->id]) }}" class="text-blue-500 font-bold hover:underline">
        <i class='bx bxs-camera bx-md'></i>
      </a> --}}
      <a href="https://pericena.github.io/declaracion/datos/index3.html" class="text-blue-500 font-bold hover:underline">
        <i class='bx bxs-camera bx-md'></i>
      </a>


      

      @endif
    </div>
  </div>
</div>
</div>
</div>
<script>
  // JavaScript para controlar el modal
  document.getElementById('openModalBtn').addEventListener('click', function() {
    document.getElementById('myModal').classList.remove('hidden');
  });

  document.getElementById('closeModalBtn').addEventListener('click', function() {
    document.getElementById('myModal').classList.add('hidden');
  });

</script>
@endsection
