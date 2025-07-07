import * as THREE from 'https://cdn.jsdelivr.net/npm/three@0.150.1/build/three.module.js';
import { GLTFLoader } from 'https://cdn.jsdelivr.net/npm/three@0.150.1/examples/jsm/loaders/GLTFLoader.js';

const container = document.getElementById('model-container');
let loadedModel = null; // Variable para almacenar el modelo cargado

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
    loader.load('/public/utils/3d-model.glb', function(gltf) {
        loadedModel = gltf.scene;
        scene.add(loadedModel);
    }, undefined, function(error) {
        console.error('Error al cargar el modelo 3D:', error);
        // Mostrar un mensaje de error en la interfaz
        const errorMessage = document.createElement('div');
        errorMessage.style.color = 'white';
        errorMessage.style.textAlign = 'center';
        errorMessage.style.padding = '20px';
        errorMessage.textContent = 'No se pudo cargar el modelo 3D. Por favor, intente recargar la página.';
        container.appendChild(errorMessage);
    });

    // Control de tamaño responsivo
    window.addEventListener('resize', () => {
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(window.innerWidth, window.innerHeight);
    });

    // Funciones para rotar el modelo 3D
    function rotateModel(axis, angle) {
        if (loadedModel) {
            loadedModel.rotation[axis] += angle;
        }
    }

    // Asignar eventos a los botones de navegación del modelo 3D
    document.getElementById('nav-left')?.addEventListener('click', () => rotateModel('y', Math.PI / 8));
    document.getElementById('nav-right')?.addEventListener('click', () => rotateModel('y', -Math.PI / 8));
    document.getElementById('nav-up')?.addEventListener('click', () => rotateModel('x', Math.PI / 8));
    document.getElementById('nav-down')?.addEventListener('click', () => rotateModel('x', -Math.PI / 8));

    // Bucle de animación del modelo 3D
    function animate() {
        requestAnimationFrame(animate);
        renderer.render(scene, camera);
    }
    animate();
}
// Fin integración 3D