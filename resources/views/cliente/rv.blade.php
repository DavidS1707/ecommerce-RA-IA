<!DOCTYPE html>

<html>
  <head>
    <title>Realidad Aumentada AR</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="css/styles.css">

    <script src="https://aframe.io/releases/1.0.4/aframe.min.js"></script>
    <script src="https://raw.githack.com/AR-js-org/AR.js/master/aframe/build/aframe-ar.js"></script>
    <script src="gesture-detector.js"></script>
    <script src="gesture-handler.js"></script>
  </head>

  <body>

    <a-scene
      arjs
      embedded
      renderer="logarithmicDepthBuffer: true;"
      vr-mode-ui="enabled: false"
      gesture-detector
      id="scene"
    >
      <a-assets>
        <a-asset-item
          id="bowser"
          src="dist/charmander.glb"
        >
        </a-asset-item>
      </a-assets>

      <a-marker
        preset="hiro"
        raycaster="objects: .clickable"
        emitevents="true"
        cursor="fuse: false; rayOrigin: mouse;"
        id="markerA"
      >

        <a-entity
          id="bowser-model"
          gltf-model="#bowser"
          position="0 0 0"
          scale="0.05 0.05 0.05"
          class="clickable"
          gesture-handler
        >
        </a-entity>
   
      </a-marker>
      <a-entity camera></a-entity>
    </a-scene>
  </body>
</html>