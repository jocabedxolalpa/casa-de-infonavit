import * as THREE from 'https://cdn.skypack.dev/three@0.129.0/build/three.module.js';
import { GLTFLoader } from 'https://cdn.skypack.dev/three@0.129.0/examples/jsm/loaders/GLTFLoader.js';
//import { gsap } from 'https://cdn.skypack.dev/gsap';


// import * as THREE from '../node_modules/build/three.module.js';
// import { GLTFLoader } from '../node_modules/three/examples/jsm/loaders/GLTFLoader.js';
import { gsap } from '../node_modules/gsap/index.js';

const camera = new THREE.PerspectiveCamera(
    10,
    window.innerWidth / window.innerHeight,
    0.1,
    1000
);
camera.position.z = 13;

const scene = new THREE.Scene();
let model;
let mixer;
const loader = new GLTFLoader();
loader.load('public/model/logo.glb',
    function (gltf) {
        model = gltf.scene;
        scene.add(model);

        mixer = new THREE.AnimationMixer(model);
        if (gltf.animations.length > 0) {
            mixer.clipAction(gltf.animations[0]).play();
        }
        modelMove();
    },
    function (xhr) {},
    function (error) {}
);
const renderer = new THREE.WebGLRenderer({ alpha: true });
renderer.setSize(window.innerWidth, window.innerHeight);
document.getElementById('model-container').appendChild(renderer.domElement);

// light
const ambientLight = new THREE.AmbientLight(0xffffff, 1.3);
scene.add(ambientLight);

const topLight = new THREE.DirectionalLight(0xffffff, 1);
topLight.position.set(500, 500, 500);
scene.add(topLight);

const reRender3D = () => {
    requestAnimationFrame(reRender3D);
    if (model) {
        model.rotation.y += 0.01; // Girar el modelo continuamente
    }
    renderer.render(scene, camera);
    if (mixer) mixer.update(0.02);
};
reRender3D();

let arrPositionModel = [
    {
        id: 'section1',
        position: { x: 0, y: 0, z: 0 },
        rotation: { x: 0, y: 0, z: 0 }
    },
    {
        id: "section2",
        position: { x: 1.5, y: 0, z: 0 },
        rotation: { x: 0, y: 1., z: 0 },
    },
    {
        id: "section3",
        position: { x: -1.5, y: 0, z: 0 },
        rotation: { x: 0, y: -1.5, z: 0 },
    },
    {
        id: "section4",
        position: { x: 1.5, y: 0, z: 0 },
        rotation: { x: 0, y: 1.5, z: 0 },
    },
    {
        id: "section5",
        position: { x: -1.5, y: 0, z: 0 },
        rotation: { x: 0, y: -1.5, z: 0 },
    },
    {
        id: "contact",
        position: { x: 0, y: 0, z: 0 },
        rotation: { x: 0, y: 0, z: 0 },
    },
    {
        id: "team",
        position: { x: 1.5, y: 0, z: 0 },
        rotation: { x: 0, y: 1.5, z: 0 },
    },
    {
        id: "virtual-tour",
        position: { x: -1.5, y: 0, z: 0 },
        rotation: { x: 0, y: -1.5, z: 0 },
    },
];

const modelMove = () => {
    const sections = document.querySelectorAll('.section');
    let currentSection;
    sections.forEach((section) => {
        const rect = section.getBoundingClientRect();
        if (rect.top <= window.innerHeight / 3) {
            currentSection = section.id;
        }
    });
    let position_active = arrPositionModel.findIndex(
        (val) => val.id == currentSection
    );
    if (position_active >= 0) {
        let new_coordinates = arrPositionModel[position_active];
        gsap.to(model.position, {
            x: new_coordinates.position.x,
            y: new_coordinates.position.y,
            z: new_coordinates.position.z,
            duration: 3,
            ease: "power1.out"
        });
        gsap.to(model.rotation, {
            x: new_coordinates.rotation.x,
            y: new_coordinates.rotation.y,
            z: new_coordinates.rotation.z,
            duration: 3,
            ease: "power1.out"
        });
    }
};

window.addEventListener('scroll', () => {
    if (model) {
        modelMove();
    }
});

window.addEventListener('resize', () => {
    renderer.setSize(window.innerWidth, window.innerHeight);
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
});