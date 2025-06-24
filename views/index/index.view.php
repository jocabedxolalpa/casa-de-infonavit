<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="" />
    <link
      rel="stylesheet"
      as="style"
      onload="this.rel='stylesheet'"
      href="https://fonts.googleapis.com/css2?display=swap&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900&amp;family=Space+Grotesk%3Awght%40400%3B500%3B700"
    />
link
    <title>HomeSync</title>
    <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64," />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
      // Función para alternar el menú móvil
      function toggleMobileMenu() {
        const mobileMenu = document.getElementById('mobile-menu');
        const menuButton = document.getElementById('menu-button');
        const isOpen = mobileMenu.classList.contains('hidden');
        
        if (isOpen) {
          mobileMenu.classList.remove('hidden');
          menuButton.classList.add('open');
          document.body.style.overflow = 'hidden';
        } else {
          mobileMenu.classList.add('hidden');
          menuButton.classList.remove('open');
          document.body.style.overflow = 'auto';
        }
      }
      
      // Cerrar menú al hacer clic en un enlace
      function closeMobileMenu() {
        const mobileMenu = document.getElementById('mobile-menu');
        const menuButton = document.getElementById('menu-button');
        mobileMenu.classList.add('hidden');
        menuButton.classList.remove('open');
        document.body.style.overflow = 'auto';
      }

      document.addEventListener('DOMContentLoaded', function() {
        // Verificar preferencia de tema
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
          document.documentElement.classList.add('dark');
          if (document.getElementById('darkModeToggle')) {
            document.getElementById('darkModeToggle').checked = true;
          }
        } else {
          document.documentElement.classList.remove('dark');
        }

        // Smooth scroll para enlaces internos
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
          anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
              targetElement.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
              });
              
              // Cerrar menú móvil si está abierto
              const mobileMenu = document.getElementById('mobile-menu');
              const menuButton = document.getElementById('menu-button');
              if (!mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.add('hidden');
                menuButton.classList.remove('open');
              }
            }
          });
        });

        // Toggle menú móvil
        const menuButton = document.getElementById('menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        
        if (menuButton) {
          // Manejar clic en el botón del menú
          menuButton.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleMobileMenu();
          });
          
          // Cerrar menú al hacer clic fuera
          document.addEventListener('click', function(e) {
            if (!mobileMenu.contains(e.target) && !menuButton.contains(e.target)) {
              closeMobileMenu();
            }
          });
          
          // Cerrar menú al hacer scroll
          let lastScrollTop = 0;
          window.addEventListener('scroll', function() {
            const st = window.pageYOffset || document.documentElement.scrollTop;
            if (Math.abs(st - lastScrollTop) > 10) { // Solo si el desplazamiento es significativo
              closeMobileMenu();
            }
            lastScrollTop = st <= 0 ? 0 : st;
          });
        }

        // Cerrar menú al hacer clic fuera
        document.addEventListener('click', function(e) {
          if (!menuButton.contains(e.target) && !mobileMenu.contains(e.target)) {
            menuButton.classList.remove('open');
            mobileMenu.classList.add('hidden');
          }
        });

        // Toggle modo oscuro
        const darkModeToggle = document.getElementById('darkModeToggle');
        if (darkModeToggle) {
          darkModeToggle.addEventListener('change', function() {
            if (this.checked) {
              localStorage.theme = 'dark';
              document.documentElement.classList.add('dark');
            } else {
              localStorage.theme = 'light';
              document.documentElement.classList.remove('dark');
            }
          });
        }

        // Mostrar/ocultar modal de contacto
        const contactButtons = document.querySelectorAll('[data-modal-toggle="contactModal"]');
        const contactModal = document.getElementById('contactModal');
        const closeButtons = document.querySelectorAll('[data-modal-hide="contactModal"]');

        contactButtons.forEach(button => {
          button.addEventListener('click', () => {
            contactModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
          });
        });

        closeButtons.forEach(button => {
          button.addEventListener('click', () => {
            contactModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
          });
        });

        // Cerrar modal al hacer clic fuera del contenido
        contactModal.addEventListener('click', (e) => {
          if (e.target === contactModal) {
            contactModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
          }
        });
      });
    </script>
    <style>
      /* Estilos para el botón de menú móvil */
      #menu-button {
        display: none; /* Ocultar por defecto */
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 40px;
        height: 40px;
        background: transparent;
        border: none;
        cursor: pointer;
        padding: 0;
        z-index: 1001;
        position: relative;
      }
      
      #menu-button span {
        display: block;
        width: 24px;
        height: 2px;
        background-color: white;
        margin: 4px 0;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        transform-origin: center;
      }
      
      #menu-button.open span:first-child {
        transform: translateY(6px) rotate(45deg);
      }
      
      #menu-button.open span:nth-child(2) {
        opacity: 0;
        transform: scale(0);
      }
      
      #menu-button.open span:last-child {
        transform: translateY(-6px) rotate(-45deg);
      }
      
      /* Estilos para el menú móvil */
      #mobile-menu {
        position: fixed;
        top: 80px; /* Ajustado para que quede justo debajo del header fijo */
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #151a1e;
        z-index: 999;
        overflow-y: auto;
        padding: 20px;
        transform: translateX(-100%);
        transition: transform 0.3s ease-in-out;
      }
      
      #mobile-menu.active {
        transform: translateX(0);
        display: block;
      }
      
      /* Ocultar menú móvil en desktop */
      @media (min-width: 1024px) {
        #mobile-menu {
          display: none !important;
        }
      }
      
      #mobile-menu .max-w-md {
        margin: 0 auto;
        background: #1e252b;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
      }
      
      #mobile-menu a {
        display: block;
        padding: 12px 16px;
        color: white;
        text-decoration: none;
        font-size: 16px;
        font-weight: 500;
        transition: all 0.2s ease;
        border-radius: 8px;
        margin: 4px 0;
      }

      #mobile-menu a:hover {
        background-color: #2c363f;
      }

      /* Estilos para el modal */
      .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        z-index: 1000;
        overflow-y: auto;
      }

      .modal-content {
        background-color: white;
        margin: 5% auto;
        padding: 2rem;
        border-radius: 8px;
        max-width: 500px;
        width: 90%;
        position: relative;
      }

      .dark .modal-content {
        background-color: #1e293b;
        color: white;
      }

      .close-modal {
        position: absolute;
        top: 15px;
        right: 15px;
        font-size: 1.5rem;
        cursor: pointer;
      }

      /* Estilos para el toggle de modo oscuro */
      .checkbox-wrapper-54 input[type="checkbox"] {
        visibility: hidden;
        display: none;
      }

      .checkbox-wrapper-54 *,
      .checkbox-wrapper-54 ::after,
      .checkbox-wrapper-54 ::before {
        box-sizing: border-box;
      }

      .checkbox-wrapper-54 .switch {
        --width-of-switch: 3.5em;
        --height-of-switch: 2em;
        --size-of-icon: 1.4em;
        --slider-offset: 0.3em;
        position: relative;
        width: var(--width-of-switch);
        height: var(--height-of-switch);
        display: inline-block;
      }

      .checkbox-wrapper-54 .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #f4f4f5;
        transition: .4s;
        border-radius: 30px;
      }

      .dark .checkbox-wrapper-54 .slider {
        background-color: #374151;
      }

      .checkbox-wrapper-54 .slider:before {
        position: absolute;
        content: "";
        height: var(--size-of-icon,1.4em);
        width: var(--size-of-icon,1.4em);
        border-radius: 20px;
        left: var(--slider-offset,0.3em);
        top: 50%;
        transform: translateY(-50%);
        background: linear-gradient(40deg,#ff0080,#ff8c00 70%);
        transition: .4s;
      }

      .checkbox-wrapper-54 input:checked + .slider {
        background-color: #303136;
      }

      .checkbox-wrapper-54 input:checked + .slider:before {
        left: calc(100% - (var(--size-of-icon,1.4em) + var(--slider-offset,0.3em)));
        background: #303136;
        box-shadow: inset -3px -2px 5px -2px #8983f7, inset -10px -4px 0 0 #a3dafb;
      }

      /* Media Queries */
      @media (max-width: 1023px) {
        #desktop-menu {
          display: none !important;
        }
        
        #menu-button {
          display: flex;
        }
      }
      
      @media (min-width: 1024px) {
        #mobile-menu {
          display: none !important;
        }
      }
      
      @media (min-width: 1025px) {
        #mobile-menu {
          display: none !important;
        }
      }

      /* Estilos para las nuevas secciones */
      .app-section, .virtual-tour-section {
        padding: 4rem 1rem;
        margin: 2rem 0;
        border-radius: 8px;
        background-color: rgba(255, 255, 255, 0.05);
      }

      .dark .app-section,
      .dark .virtual-tour-section {
        background-color: rgba(0, 0, 0, 0.2);
      }
    </style>

<!-- Estilos para el canvas 3D -->
<style>
  #canvas3d {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: -1;
    opacity: 0.9;
    transition: opacity 0.5s;
  }
  #canvas3d:hover {
    opacity: 1;
  }
  .content-section {
    position: relative;
    z-index: 1;
    background: rgba(21, 26, 30, 0.8);
    backdrop-filter: blur(5px);
  }
</style>
<script>
  // Verificar que las dependencias estén cargadas
  console.log('Three.js cargado:', typeof THREE !== 'undefined' ? 'Sí' : 'No');
  console.log('FBXLoader cargado:', typeof THREE.FBXLoader !== 'undefined' ? 'Sí' : 'No');
  console.log('GSAP cargado:', typeof gsap !== 'undefined' ? 'Sí' : 'No');
  console.log('ScrollTrigger cargado:', typeof ScrollTrigger !== 'undefined' ? 'Sí' : 'No');
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Variables globales
  let model, mixer, clock;
  
  // Inicializar reloj para animaciones
  clock = new THREE.Clock();
  
  // Configuración del renderizador
  const canvas = document.querySelector('#canvas3d');
  const renderer = new THREE.WebGLRenderer({ 
    canvas: canvas,
    alpha: true,
    antialias: true
  });
  
  renderer.setSize(window.innerWidth, window.innerHeight);
  renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
  renderer.outputEncoding = THREE.sRGBEncoding;
  
  // Escena
  const scene = new THREE.Scene();
  scene.background = null; // Hacemos el fondo transparente
  
  // Cámara
  const camera = new THREE.PerspectiveCamera(
    45, 
    window.innerWidth / window.innerHeight, 
    0.1, 
    1000
  );
  camera.position.z = 10;
  camera.position.y = 2;
  
  // Luces
  const ambientLight = new THREE.AmbientLight(0xffffff, 0.6);
  scene.add(ambientLight);
  
  const directionalLight1 = new THREE.DirectionalLight(0xffffff, 0.8);
  directionalLight1.position.set(1, 1, 1);
  scene.add(directionalLight1);
  
  const directionalLight2 = new THREE.DirectionalLight(0xffffff, 0.5);
  directionalLight2.position.set(-1, -1, -1);
  scene.add(directionalLight2);
  
  // Cargar modelo FBX
  // Cargar modelo FBX
const loader = new THREE.FBXLoader();
const modelPath = '/casa-de-infonavit/public/utils/3d-model.glb'; // Ajusta esta ruta

console.log('Intentando cargar modelo desde:', modelPath);

loader.load(
  modelPath,
  function(object) {
    console.log('Modelo cargado exitosamente:', object);
    model = object;
    
    // Ajustar escala y posición
    model.scale.set(0.05, 0.05, 0.05);
    model.position.y = -1;
    model.rotation.y = Math.PI / 4;
    
    scene.add(model);
    console.log('Modelo añadido a la escena');
    
    // Configurar animaciones con scroll
    setupScrollAnimations();
    
    // Forzar un renderizado
    renderer.render(scene, camera);
  },
  // Función de progreso
  function(xhr) {
    console.log((xhr.loaded / xhr.total * 100) + '% cargado');
  },
  // Función de error
  function(error) {
    console.error('Error al cargar el modelo FBX:', error);
    // Mostrar un objeto de prueba si falla la carga
    console.log('Mostrando objeto de prueba...');
    const geometry = new THREE.BoxGeometry(1, 1, 1);
    const material = new THREE.MeshBasicMaterial({ color: 0x00ff00 });
    model = new THREE.Mesh(geometry, material);
    scene.add(model);
  }
);
  // Manejar redimensionamiento
  window.addEventListener('resize', onWindowResize);
  function onWindowResize() {
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(window.innerWidth, window.innerHeight);
  }
  
  // Animación
  function animate() {
    requestAnimationFrame(animate);
    
    // Actualizar animaciones del modelo
    if (mixer) {
      const delta = clock.getDelta();
      mixer.update(delta);
    }
    
    renderer.render(scene, camera);
  }
  
  animate();
  
  // Limpiar al desmontar
  return () => {
    window.removeEventListener('resize', onWindowResize);
    if (renderer) {
      renderer.dispose();
    }
  };
  // public/js/3d-model.js
document.addEventListener('DOMContentLoaded', function() {
  console.log('Iniciando script 3D...');
  
  // 1. Configuración básica
  const canvas = document.querySelector('#canvas3d');
  if (!canvas) {
    console.error('No se encontró el elemento canvas3d');
    return;
  }

  // 2. Inicializar Three.js
  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
  const renderer = new THREE.WebGLRenderer({ 
    canvas: canvas,
    alpha: true,
    antialias: true
  });
  
  renderer.setSize(window.innerWidth, window.innerHeight);
  renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));

  // 3. Agregar luces
  const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
  scene.add(ambientLight);
  
  const directionalLight = new THREE.DirectionalLight(0xffffff, 0.8);
  directionalLight.position.set(1, 1, 1);
  scene.add(directionalLight);

  // 4. Agregar un cubo de prueba
  const geometry = new THREE.BoxGeometry(1, 1, 1);
  const material = new THREE.MeshBasicMaterial({ color: 0x00ff00 });
  const cube = new THREE.Mesh(geometry, material);
  scene.add(cube);
  camera.position.z = 5;

  // 5. Función de animación
  function animate() {
    requestAnimationFrame(animate);
    cube.rotation.x += 0.01;
    cube.rotation.y += 0.01;
    renderer.render(scene, camera);
  }

  // 6. Manejar redimensionamiento
  window.addEventListener('resize', () => {
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(window.innerWidth, window.innerHeight);
  });

  // 7. Iniciar animación
  animate();

  console.log('Animación 3D iniciada');
});
});
</script>
  </head>
  <body>
    <div id="model-container" class="position-fixed w-100 h-100"></div>
    <div id="model-container" class="position-fixed w-100 h-100"></div>
    <canvas id="canvas3d" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1;"></canvas>
  
  <!-- El resto de tu contenido existente -->    <div class="relative min-h-screen bg-[#151a1e] dark group/design-root">
      <!-- Header fijo -->
      <header class="fixed top-0 left-0 right-0 z-50 bg-[#151a1ee6] backdrop-blur-md flex items-center justify-between whitespace-nowrap border-b border-solid border-b-[#2c363f] px-4 md:px-10 py-3 h-20">
          <div class="flex items-center gap-4 text-white">
            <div class="size-4">
              <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M39.475 21.6262C40.358 21.4363 40.6863 21.5589 40.7581 21.5934C40.7876 21.655 40.8547 21.857 40.8082 22.3336C40.7408 23.0255 40.4502 24.0046 39.8572 25.2301C38.6799 27.6631 36.5085 30.6631 33.5858 33.5858C30.6631 36.5085 27.6632 38.6799 25.2301 39.8572C24.0046 40.4502 23.0255 40.7407 22.3336 40.8082C21.8571 40.8547 21.6551 40.7875 21.5934 40.7581C21.5589 40.6863 21.4363 40.358 21.6262 39.475C21.8562 38.4054 22.4689 36.9657 23.5038 35.2817C24.7575 33.2417 26.5497 30.9744 28.7621 28.762C30.9744 26.5497 33.2417 24.7574 35.2817 23.5037C36.9657 22.4689 38.4054 21.8562 39.475 21.6262ZM4.41189 29.2403L18.7597 43.5881C19.8813 44.7097 21.4027 44.9179 22.7217 44.7893C24.0585 44.659 25.5148 44.1631 26.9723 43.4579C29.9052 42.0387 33.2618 39.5667 36.4142 36.4142C39.5667 33.2618 42.0387 29.9052 43.4579 26.9723C44.1631 25.5148 44.659 24.0585 44.7893 22.7217C44.9179 21.4027 44.7097 19.8813 43.5881 18.7597L29.2403 4.41187C27.8527 3.02428 25.8765 3.02573 24.2861 3.36776C22.6081 3.72863 20.7334 4.58419 18.8396 5.74801C16.4978 7.18716 13.9881 9.18353 11.5858 11.5858C9.18354 13.988 7.18717 16.4978 5.74802 18.8396C4.58421 20.7334 3.72865 22.6081 3.36778 24.2861C3.02574 25.8765 3.02429 27.8527 4.41189 29.2403Z"
                  fill="currentColor"
                ></path>
              </svg>
            </div>
            <h2 class="text-white text-lg font-bold leading-tight tracking-[-0.015em]">HomeSync</h2>
          </div>
          <!-- Menú de escritorio -->
          <div id="desktop-menu" class="hidden lg:flex items-center gap-9">
            <a class="text-white text-sm font-medium leading-normal hover:text-blue-300 transition-colors" href="#home">Home</a>
            <a class="text-white text-sm font-medium leading-normal hover:text-blue-300 transition-colors" href="#about">About Us</a>
            <a class="text-white text-sm font-medium leading-normal hover:text-blue-300 transition-colors" href="#services">Our Services</a>
            <a class="text-white text-sm font-medium leading-normal hover:text-blue-300 transition-colors" href="#how-it-works">How It Works</a>
            <a class="text-white text-sm font-medium leading-normal hover:text-blue-300 transition-colors" href="#app">App Download</a>
            <a class="text-white text-sm font-medium leading-normal hover:text-blue-300 transition-colors" href="#virtual-tour">Virtual Tour</a>
          </div>
          
          <!-- Botón de menú móvil -->
          <button id="menu-button" class="lg:hidden flex flex-col justify-center items-center w-10 h-10">
            <span></span>
            <span></span>
            <span></span>
          </button>
          
          <!-- Menú móvil -->
          <div id="mobile-menu" class="lg:hidden">
            <div class="container mx-auto px-4 py-6">
              <nav class="flex flex-col space-y-3">
                <a class="block py-3 px-4 text-white hover:bg-[#2c363f] rounded-lg transition-colors" href="#home" onclick="closeMobileMenu()">Home</a>
                <a class="block py-3 px-4 text-white hover:bg-[#2c363f] rounded-lg transition-colors" href="#about" onclick="closeMobileMenu()">About Us</a>
                <a class="block py-3 px-4 text-white hover:bg-[#2c363f] rounded-lg transition-colors" href="#services" onclick="closeMobileMenu()">Our Services</a>
                <a class="block py-3 px-4 text-white hover:bg-[#2c363f] rounded-lg transition-colors" href="#how-it-works" onclick="closeMobileMenu()">How It Works</a>
                <a class="block py-3 px-4 text-white hover:bg-[#2c363f] rounded-lg transition-colors" href="#app" onclick="closeMobileMenu()">App Download</a>
                <a class="block py-3 px-4 text-white hover:bg-[#2c363f] rounded-lg transition-colors" href="#virtual-tour" onclick="closeMobileMenu()">Virtual Tour</a>
                <div class="pt-4 mt-2">
                  <button class="w-full bg-[#dae5f0] text-[#151a1e] py-3 px-6 rounded-full font-bold text-sm hover:bg-opacity-90 transition-colors" data-modal-toggle="contactModal" onclick="closeMobileMenu()">
                    Get Started
                  </button>
                </div>
              </nav>
            </div>
          </div>
            <div class="flex gap-2">
              <button
                class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 px-4 bg-[#dae5f0] text-[#151a1e] text-sm font-bold leading-normal tracking-[0.015em]"
                data-modal-toggle="contactModal"
              >
                <span class="truncate">Get Started</span>
              </button>
              <div class="flex items-center gap-2">
                <div class="checkbox-wrapper-54">
                  <label class="switch">
                    <input type="checkbox" id="darkModeToggle">
                    <span class="slider"></span>
                  </label>
                </div>
              </button>
            </div>
          </div>
      </header>
      
      <!-- Contenido principal con padding superior para el header fijo -->
      <main class="content-section pt-20 min-h-screen">
      <div class="px-4 md:px-10 lg:px-20 xl:px-40 flex justify-center py-5">
          <div class="w-full max-w-[960px]">
            <div class="@container">
              <div class="@[480px]:p-4">
                <div
                  class="flex min-h-[480px] flex-col gap-6 bg-cover bg-center bg-no-repeat @[480px]:gap-8 @[480px]:rounded-xl items-center justify-center p-4"
                  style='background-image: linear-gradient(rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.4) 100%), url("https://lh3.googleusercontent.com/aida-public/AB6AXuBswbHuRoA_jAPq3D6wvy-23sdmT7nZJ2iT56wEIR5Om3OukzQ7IruhOJ_ZiiHTu1AMog9_ZkZwF_IjgJFQRddEi3WcmhBoR6oY61jZ-HUiRw_OKv7hO8jpPFNIdm1RsbkYTtbCTaTYfsatCyPU3B2BW2hl_H34MLDhgzuHo5mhEQK7-fpXeEGyzfiKwxOHOTZuZ70FRpKbiCrQOCWyuXzO3XV7HT5vhqESeJ4fpl2kvawjMhWrLX6EaGNxWeq_jQu9WARSALxwzWNO");'
                >
                  <div class="flex flex-col gap-2 text-center">
                    <h1 id="home" class="text-white text-4xl font-black leading-tight tracking-[-0.033em] @[480px]:text-5xl @[480px]:font-black @[480px]:leading-tight @[480px]:tracking-[-0.033em] scroll-mt-20">
                      Experience the Future of Smart Living
                    </h1>
                    <h2 class="text-white text-sm font-normal leading-normal @[480px]:text-base @[480px]:font-normal @[480px]:leading-normal">
                      HomeSync seamlessly integrates technology into your home, providing unparalleled control and comfort. Explore our interactive 3D model with smooth scrolling
                      and dynamic animations to discover how we can transform your living space.
                    </h2>
                  </div>
                  <button
                    class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 px-4 @[480px]:h-12 @[480px]:px-5 bg-[#dae5f0] text-[#151a1e] text-sm font-bold leading-normal tracking-[0.015em] @[480px]:text-base @[480px]:font-bold @[480px]:leading-normal @[480px]:tracking-[0.015em]"
                  >
                    <span class="truncate">Explore 3D Model</span>
                  </button>
                </div>
              </div>
            </div>
            <h2 id="about" class="text-white text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5 scroll-mt-20">About Us</h2>
            <p class="text-white text-base font-normal leading-normal pb-3 pt-1 px-4">
              At HomeSync, we are dedicated to revolutionizing home living through innovative smart technology. Our mission is to create seamless, intuitive, and secure home
              environments that enhance comfort and efficiency. With a team of experts in technology and design, we strive to deliver solutions that meet the evolving needs of
              modern homeowners.
            </p>
            <h2 id="services" class="text-white text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5 scroll-mt-20">Our Services</h2>
            <div class="flex flex-col gap-10 px-4 py-10 @container">
              <div class="flex flex-col gap-4">
                <h1
                  class="text-white tracking-light text-[32px] font-bold leading-tight @[480px]:text-4xl @[480px]:font-black @[480px]:leading-tight @[480px]:tracking-[-0.033em] max-w-[720px]"
                >
                  Smart Home Features
                </h1>
                <p class="text-white text-base font-normal leading-normal max-w-[720px]">
                  HomeSync offers a range of features designed to enhance your home living experience. From automated lighting to advanced security, we've got you covered.
                </p>
              </div>
              <div class="grid grid-cols-[repeat(auto-fit,minmax(158px,1fr))] gap-3 p-0">
                <div class="flex flex-1 gap-3 rounded-lg border border-[#3f4d5a] bg-[#20262d] p-4 flex-col">
                  <div class="text-white" data-icon="House" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M218.83,103.77l-80-75.48a1.14,1.14,0,0,1-.11-.11,16,16,0,0,0-21.53,0l-.11.11L37.17,103.77A16,16,0,0,0,32,115.55V208a16,16,0,0,0,16,16H96a16,16,0,0,0,16-16V160h32v48a16,16,0,0,0,16,16h48a16,16,0,0,0,16-16V115.55A16,16,0,0,0,218.83,103.77ZM208,208H160V160a16,16,0,0,0-16-16H112a16,16,0,0,0-16,16v48H48V115.55l.11-.1L128,40l79.9,75.43.11.1Z"
                      ></path>
                    </svg>
                  </div>
                  <div class="flex flex-col gap-1">
                    <h2 class="text-white text-base font-bold leading-tight">Smart Lighting</h2>
                    <p class="text-[#a0adbb] text-sm font-normal leading-normal">Control your lights remotely, set schedules, and create custom lighting scenes.</p>
                  </div>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#3f4d5a] bg-[#20262d] p-4 flex-col">
                  <div class="text-white" data-icon="Lightbulb" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M176,232a8,8,0,0,1-8,8H88a8,8,0,0,1,0-16h80A8,8,0,0,1,176,232Zm40-128a87.55,87.55,0,0,1-33.64,69.21A16.24,16.24,0,0,0,176,186v6a16,16,0,0,1-16,16H96a16,16,0,0,1-16-16v-6a16,16,0,0,0-6.23-12.66A87.59,87.59,0,0,1,40,104.49C39.74,56.83,78.26,17.14,125.88,16A88,88,0,0,1,216,104Zm-16,0a72,72,0,0,0-73.74-72c-39,.92-70.47,33.39-70.26,72.39a71.65,71.65,0,0,0,27.64,56.3A32,32,0,0,1,96,186v6h64v-6a32.15,32.15,0,0,1,12.47-25.35A71.65,71.65,0,0,0,200,104Zm-16.11-9.34a57.6,57.6,0,0,0-46.56-46.55,8,8,0,0,0-2.66,15.78c16.57,2.79,30.63,16.85,33.44,33.45A8,8,0,0,0,176,104a9,9,0,0,0,1.35-.11A8,8,0,0,0,183.89,94.66Z"
                      ></path>
                    </svg>
                  </div>
                  <div class="flex flex-col gap-1">
                    <h2 class="text-white text-base font-bold leading-tight">Energy Management</h2>
                    <p class="text-[#a0adbb] text-sm font-normal leading-normal">Monitor and optimize your energy usage to reduce costs and environmental impact.</p>
                  </div>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#3f4d5a] bg-[#20262d] p-4 flex-col">
                  <div class="text-white" data-icon="Lock" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M208,80H176V56a48,48,0,0,0-96,0V80H48A16,16,0,0,0,32,96V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V96A16,16,0,0,0,208,80ZM96,56a32,32,0,0,1,64,0V80H96ZM208,208H48V96H208V208Zm-68-56a12,12,0,1,1-12-12A12,12,0,0,1,140,152Z"
                      ></path>
                    </svg>
                  </div>
                  <div class="flex flex-col gap-1">
                    <h2 class="text-white text-base font-bold leading-tight">Security Systems</h2>
                    <p class="text-[#a0adbb] text-sm font-normal leading-normal">Protect your home with smart locks, motion sensors, and real-time alerts.</p>
                  </div>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#3f4d5a] bg-[#20262d] p-4 flex-col">
                  <div class="text-white" data-icon="Thermometer" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M212,56a28,28,0,1,0,28,28A28,28,0,0,0,212,56Zm0,40a12,12,0,1,1,12-12A12,12,0,0,1,212,96Zm-84,57V88a8,8,0,0,0-16,0v65a32,32,0,1,0,16,0Zm-8,47a16,16,0,1,1,16-16A16,16,0,0,1,120,200Zm40-66V48a40,40,0,0,0-80,0v86a64,64,0,1,0,80,0Zm-40,98a48,48,0,0,1-27.42-87.4A8,8,0,0,0,96,138V48a24,24,0,0,1,48,0v90a8,8,0,0,0,3.42,6.56A48,48,0,0,1,120,232Z"
                      ></path>
                    </svg>
                  </div>
                  <div class="flex flex-col gap-1">
                    <h2 class="text-white text-base font-bold leading-tight">Climate Control</h2>
                    <p class="text-[#a0adbb] text-sm font-normal leading-normal">Maintain the perfect temperature with intelligent thermostats and automated climate control.</p>
                  </div>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#3f4d5a] bg-[#20262d] p-4 flex-col">
                  <div class="text-white" data-icon="Camera" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M208,56H180.28L166.65,35.56A8,8,0,0,0,160,32H96a8,8,0,0,0-6.65,3.56L75.71,56H48A24,24,0,0,0,24,80V192a24,24,0,0,0,24,24H208a24,24,0,0,0,24-24V80A24,24,0,0,0,208,56Zm8,136a8,8,0,0,1-8,8H48a8,8,0,0,1-8-8V80a8,8,0,0,1,8-8H80a8,8,0,0,0,6.66-3.56L100.28,48h55.43l13.63,20.44A8,8,0,0,0,176,72h32a8,8,0,0,1,8,8ZM128,88a44,44,0,1,0,44,44A44.05,44.05,0,0,0,128,88Zm0,72a28,28,0,1,1,28-28A28,28,0,0,1,128,160Z"
                      ></path>
                    </svg>
                  </div>
                  <div class="flex flex-col gap-1">
                    <h2 class="text-white text-base font-bold leading-tight">Surveillance</h2>
                    <p class="text-[#a0adbb] text-sm font-normal leading-normal">Keep an eye on your property with high-definition cameras and remote access.</p>
                  </div>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#3f4d5a] bg-[#20262d] p-4 flex-col">
                  <div class="text-white" data-icon="MusicNote" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M210.3,56.34l-80-24A8,8,0,0,0,120,40V148.26A48,48,0,1,0,136,184V98.75l69.7,20.91A8,8,0,0,0,216,112V64A8,8,0,0,0,210.3,56.34ZM88,216a32,32,0,1,1,32-32A32,32,0,0,1,88,216ZM200,101.25l-64-19.2V50.75L200,70Z"
                      ></path>
                    </svg>
                  </div>
                  <div class="flex flex-col gap-1">
                    <h2 class="text-white text-base font-bold leading-tight">Entertainment</h2>
                    <p class="text-[#a0adbb] text-sm font-normal leading-normal">Enjoy seamless integration with your favorite music and entertainment systems.</p>
                  </div>
                </div>
              </div>
            </div>
            <h2 id="how-it-works" class="text-white text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5 scroll-mt-20">How It Works</h2>
            <p class="text-white text-base font-normal leading-normal pb-3 pt-1 px-4">
              HomeSync integrates with your existing home systems to create a unified smart home experience. Our system uses a central hub to connect all your devices, allowing you
              to control them from a single app. With advanced automation features, your home learns your preferences and adjusts settings automatically, saving you time and
              energy.
            </p>
            <!-- Sección de Descarga de Aplicación -->
            <section id="app" class="app-section scroll-mt-20">
              <h2 class="text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3">App Download</h2>
              <p class="text-base font-normal leading-normal pb-6 px-4">
                Descarga nuestra aplicación para controlar tu hogar inteligente desde cualquier lugar. Disponible para iOS y Android.
              </p>
              <div class="flex flex-col md:flex-row gap-4 px-4">
                <a href="#" class="flex items-center justify-center gap-2 bg-black text-white px-6 py-3 rounded-lg hover:bg-gray-800 transition-colors">
                  <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M17.05 20.28c-.98.95-2.05.8-3.08.35-1.09-.46-2.09-.48-3.24 0-1.44.62-2.2.44-3.06-.35C2.79 15.25 3.51 7.59 9.05 7.31c1.35.07 2.29.74 3.08.8 1.18-.24 2.31-.93 3.57-.84 1.51.12 2.65.72 3.4 1.8-3.12 1.87-2.38 5.98.48 7.13-.57 1.5-1.31 2.99-2.53 4.08zM12 6.8c0-1.4 1.15-2.64 2.1-3.7-.33-2.24-2.21-3.02-2.1-3.7C10.1.1 9.31 2.3 11.34 4.1c.75.64 1.66 1.03 2.66 1.14-.02-.16.01-.3 0-.44z"></path>
                  </svg>
                  <div class="text-left">
                    <div class="text-xs">Download on the</div>
                    <div class="text-xl font-semibold">App Store</div>
                  </div>
                </a>
                <a href="#" class="flex items-center justify-center gap-2 bg-black text-white px-6 py-3 rounded-lg hover:bg-gray-800 transition-colors">
                  <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M3.609 1.814L13.792 12 3.61 22.186a.996.996 0 0 1-.61-.92v-18.53a1 1 0 0 1 .609-.922zm.921 2.387L11 11.955 4.53 19.673 4.53 4.201zM14.043 12l4.174 4.174-2.704 2.705-4.175-4.175 2.705-2.704zM19.5 14.573l-2.75-2.75 2.75-2.75.002 5.5z"></path>
                  </svg>
                  <div class="text-left">
                    <div class="text-xs">Get it on</div>
                    <div class="text-xl font-semibold">Google Play</div>
                  </div>
                </a>
              </div>
            </section>

            <!-- Sección de Tour Virtual -->
            <section id="virtual-tour" class="virtual-tour-section scroll-mt-20">
              <h2 class="text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3">Virtual Tour</h2>
              <p class="text-base font-normal leading-normal pb-6 px-4">
                Explora una casa inteligente con nuestro tour virtual interactivo. Descubre cómo la tecnología puede transformar tu hogar.
              </p>
              <div class="relative overflow-hidden rounded-xl mx-4 aspect-video bg-gray-800 flex items-center justify-center">
                <div class="text-center p-8">
                  <svg class="w-16 h-16 mx-auto text-white mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                  <h3 class="text-xl font-bold text-white mb-2">Tour Virtual Interactivo</h3>
                  <p class="text-gray-300 mb-4">Haz clic en el botón para comenzar la experiencia inmersiva</p>
                  <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-full transition-colors">
                    Iniciar Tour
                  </button>
                </div>
              </div>
            </section>
            <h2 class="text-white text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Virtual Tour</h2>
            <p class="text-white text-base font-normal leading-normal pb-3 pt-1 px-4">
              Take a virtual tour of a HomeSync-enabled home and experience the future of smart living. Explore the interactive 3D model with smooth scrolling and dynamic
              animations to see how our technology integrates seamlessly into every room, enhancing comfort and convenience.
            </p>
            <h2 class="text-white text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Contact</h2>
            <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
              <label class="flex flex-col min-w-40 flex-1">
                <input
                  placeholder="Your Name"
                  class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-white focus:outline-0 focus:ring-0 border-none bg-[#2c363f] focus:border-none h-14 placeholder:text-[#a0adbb] p-4 text-base font-normal leading-normal"
                  value=""
                />
              </label>
            </div>
            <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
              <label class="flex flex-col min-w-40 flex-1">
                <input
                  placeholder="Your Email"
                  class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-white focus:outline-0 focus:ring-0 border-none bg-[#2c363f] focus:border-none h-14 placeholder:text-[#a0adbb] p-4 text-base font-normal leading-normal"
                  value=""
                />
              </label>
            </div>
            <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
              <label class="flex flex-col min-w-40 flex-1">
                <textarea
                  placeholder="Your Message"
                  class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-white focus:outline-0 focus:ring-0 border-none bg-[#2c363f] focus:border-none min-h-36 placeholder:text-[#a0adbb] p-4 text-base font-normal leading-normal"
                ></textarea>
              </label>
            </div>
            <div class="flex px-4 py-3 justify-start">
              <button
                class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 px-4 bg-[#dae5f0] text-[#151a1e] text-sm font-bold leading-normal tracking-[0.015em]"
              >
                <span class="truncate">Send</span>
              </button>
            </div>
          </div>
        </div>
      </main>
      
      <footer class="flex justify-center">
          <div class="flex max-w-[960px] flex-1 flex-col">
            <footer class="flex flex-col gap-6 px-5 py-10 text-center @container">
              <div class="flex flex-wrap items-center justify-center gap-6 @[480px]:flex-row @[480px]:justify-around">
                <a class="text-[#a0adbb] text-base font-normal leading-normal min-w-40" href="#">Privacy Policy</a>
                <a class="text-[#a0adbb] text-base font-normal leading-normal min-w-40" href="#">Terms of Service</a>
                <a class="text-[#a0adbb] text-base font-normal leading-normal min-w-40" href="#">Contact Us</a>
              </div>
              <p class="text-[#a0adbb] text-base font-normal leading-normal">@2024 HomeSync. All rights reserved.</p>
            </footer>
          </div>
      </footer>
    </div>
    <script type="module" src="/public/a.js"></script>
</body>
      <!-- Three.js y dependencias -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/FBXLoader.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.7.1/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.7.1/ScrollTrigger.min.js"></script>
<script type="module" src="/public/a.js"></script>
</script>
</html>
