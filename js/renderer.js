let scene, camera, renderer, controls;

      function init(model) {
        renderer = new THREE.WebGLRenderer({ antialias: true });
        renderer.setSize(window.innerWidth, window.innerHeight);
        document.body.appendChild(renderer.domElement);

        scene = new THREE.Scene();
        backgroundColor = 0x00000F//$("body").css("background-color");
        scene.background = new THREE.Color(backgroundColor);

        camera = new THREE.PerspectiveCamera(
          50,
          window.innerWidth / window.innerHeight,
          1,
          5000
        );
        camera.position.x = 800;
        camera.position.y = 1100;
        camera.position.z = -1000;

        controls = new THREE.OrbitControls(camera, renderer.domElement);

        directionalLight = new THREE.DirectionalLight(0xc4c4c4, 0.5);
        directionalLight.position.set(0, 1, 0);
        directionalLight.castShadow = true;
        scene.add(directionalLight);

        hlight = new THREE.AmbientLight(0x404040, 5);
        scene.add(hlight);

        /*light = new THREE.PointLight(0xc4c4c4, 10);
        light.position.set(0, 300, 500);
        scene.add(light);

        light2 = new THREE.PointLight(0xc4c4c4, 10);
        light2.position.set(500, 100, 0);
        scene.add(light2);

        light3 = new THREE.PointLight(0xc4c4c4, 10);
        light3.position.set(0, 100, -500);
        scene.add(light3);

        light4 = new THREE.PointLight(0xc4c4c4, 10);
        light4.position.set(-500, 300, 500);
        scene.add(light4);*/

        let loader = new THREE.GLTFLoader();
        loader.load(model, function (gltf) {
          asset = gltf.scene.children[0];
          asset.scale.set(30, 30, 30);
          scene.add(gltf.scene);
          animate();
        });
      }

      window.addEventListener("resize", onWindowResize, false);

      function onWindowResize() {
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();

        renderer.setSize(window.innerWidth, window.innerHeight);

        animate();
      }

      function animate() {
        requestAnimationFrame(animate);
        renderer.render(scene, camera);
        controls.update();
      }