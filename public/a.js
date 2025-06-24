import * as THREE from 'https://cdn.jsdelivr.net/npm/three@0.150.1/build/three.module.js';
import { GLTFLoader } from 'https://cdn.jsdelivr.net/npm/three@0.150.1/examples/jsm/loaders/GLTFLoader.js';

const container = document.getElementById('model-container');
if(container) {
    // Crear la escena
    const scene = new THREE.Scene();
    scene.background = new THREE.Color(0xeeeeee);

    // Cámara
    const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
    camera.position.set(0, 1.5, 4);

    // Renderizador
    const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
    renderer.setSize(window.innerWidth, window.innerHeight);
    container.appendChild(renderer.domElement);

    // Luz
    const light = new THREE.HemisphereLight(0xffffff, 0x444444, 1);
    scene.add(light);
    const dirLight = new THREE.DirectionalLight(0xffffff, 0.8);
    dirLight.position.set(5, 10, 7.5);
    scene.add(dirLight);

    // Cargar modelo GLB
    const loader = new GLTFLoader();
    loader.load('/model/3d-model.glb', function(gltf) {
        scene.add(gltf.scene);
    }, undefined, function(error) {
        console.error('Error al cargar el modelo 3D:', error);
    });

    // Control de tamaño responsivo
    window.addEventListener('resize', () => {
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(window.innerWidth, window.innerHeight);
    });

    // Animación
    function animate() {
        requestAnimationFrame(animate);
        renderer.render(scene, camera);
    }
    animate();
}
// Fin integración 3D