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

    <title>DomoticLink - Hogar Inteligente</title>
    <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64," />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <style>
      [x-cloak] { display: none !important; }
    </style>
    <!-- Alpine.js y plugins -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
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
const modelPath = '/public/utils/3d-model.glb'; // Ajusta esta ruta

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
            <div class="h-8 w-8">
              <img src="public/image/logo.jpeg" alt="Logo DomoticLink" class="h-full w-full object-contain">
            </div>
            <h2 class="text-white text-lg font-bold leading-tight tracking-[-0.015em]">DomoticLink</h2>
          </div>
          <!-- Menú de escritorio -->
          <div id="desktop-menu" class="hidden lg:flex items-center gap-9">
            <a class="text-white text-sm font-medium leading-normal hover:text-blue-300 transition-colors" href="#home">Inicio</a>
            <a class="text-white text-sm font-medium leading-normal hover:text-blue-300 transition-colors" href="#about">Nosotros</a>
            <a class="text-white text-sm font-medium leading-normal hover:text-blue-300 transition-colors" href="#services">Servicios</a>
            <a class="text-white text-sm font-medium leading-normal hover:text-blue-300 transition-colors" href="#how-it-works">¿Cómo Funciona?</a>
            <a class="text-white text-sm font-medium leading-normal hover:text-blue-300 transition-colors" href="#app">Descargar App</a>
            <a class="text-white text-sm font-medium leading-normal hover:text-blue-300 transition-colors" href="#virtual-tour">Tour Virtual</a>
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
                <a class="block py-3 px-4 text-white hover:bg-[#2c363f] rounded-lg transition-colors" href="#home" onclick="closeMobileMenu()">Inicio</a>
                <a class="block py-3 px-4 text-white hover:bg-[#2c363f] rounded-lg transition-colors" href="#about" onclick="closeMobileMenu()">Nosotros</a>
                <a class="block py-3 px-4 text-white hover:bg-[#2c363f] rounded-lg transition-colors" href="#services" onclick="closeMobileMenu()">Servicios</a>
                <a class="block py-3 px-4 text-white hover:bg-[#2c363f] rounded-lg transition-colors" href="#how-it-works" onclick="closeMobileMenu()">¿Cómo Funciona?</a>
                <a class="block py-3 px-4 text-white hover:bg-[#2c363f] rounded-lg transition-colors" href="#app" onclick="closeMobileMenu()">Descargar App</a>
                <a class="block py-3 px-4 text-white hover:bg-[#2c363f] rounded-lg transition-colors" href="#virtual-tour" onclick="closeMobileMenu()">Tour Virtual</a>
                <div class="pt-4 mt-2">
                  <button class="w-full bg-[#dae5f0] text-[#151a1e] py-3 px-6 rounded-full font-bold text-sm hover:bg-opacity-90 transition-colors" data-modal-toggle="contactModal" onclick="closeMobileMenu()">
                    Comenzar
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
                <span class="truncate">Comenzar</span>
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
                      Experimenta el Futuro de la Vivienda Inteligente
                    </h1>
                    <h2 class="text-white text-sm font-normal leading-normal @[480px]:text-base @[480px]:font-normal @[480px]:leading-normal">
                      DomoticLink integra tecnología en tu hogar, proporcionando un control y comodidad sin precedentes. Explora nuestro tour interactivo del hogar con scrolling suave
                      y animaciones dinámicas para descubrir cómo podemos transformar tu espacio de vida.
                    </h2>
                  </div>
                  <button
                    class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 px-4 @[480px]:h-12 @[480px]:px-5 bg-[#dae5f0] text-[#151a1e] text-sm font-bold leading-normal tracking-[0.015em] @[480px]:text-base @[480px]:font-bold @[480px]:leading-normal @[480px]:tracking-[0.015em]"
                  >
                    <span class="truncate">Explorar Modelo 3D</span>
                  </button>
                </div>
              </div>
            </div>
            <h2 id="about" class="text-white text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5 scroll-mt-20">Acerca de</h2>
            <p class="text-white text-base font-normal leading-normal pb-3 pt-1 px-4">
              En DomoticLink, estamos dedicados a revolucionar la forma en que vivimos en nuestros hogares a través de tecnología inteligente innovadora. Nuestra misión es crear entornos de hogar sin fisuras, intuitivos y seguros que mejoren la comodidad y la eficiencia. Con un equipo de expertos en tecnología y diseño, nos esforzamos por ofrecer soluciones que satisfagan las necesidades cambiantes de los propietarios de hogares modernos.
            </p>
            <h2 id="services" class="text-white text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5 scroll-mt-20">Nuestros Servicios</h2>
            <div class="flex flex-col gap-10 px-4 py-10 @container">
              <div class="flex flex-col gap-4">
                <h1
                  class="text-white tracking-light text-[32px] font-bold leading-tight @[480px]:text-4xl @[480px]:font-black @[480px]:leading-tight @[480px]:tracking-[-0.033em] max-w-[720px]"
                >
                  Características de Hogar Inteligente
                </h1>
                <p class="text-white text-base font-normal leading-normal max-w-[720px]">
                  DomoticLink ofrece una amplia gama de características diseñadas para mejorar tu experiencia de vida en el hogar. Desde iluminación automatizada hasta seguridad avanzada, tenemos todo cubierto.
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
                    <h2 class="text-white text-base font-bold leading-tight">Iluminación Inteligente</h2>
                    <p class="text-[#a0adbb] text-sm font-normal leading-normal">Controla tus luces de forma remota, programa horarios y crea escenas de iluminación personalizadas.</p>
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
                    <h2 class="text-white text-base font-bold leading-tight">Gestión de Energía</h2>
                    <p class="text-[#a0adbb] text-sm font-normal leading-normal">Monitorea y optimiza el consumo de energía para reducir costos e impacto ambiental.</p>
                  </div>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#3f4d5a] bg-[#20262d] p-4 flex-col">
                  <div class="text-white" data-icon="Lock" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M208,80H176V56a48,48,0,0,0-96,0V80H48A16,16,0,0,0,32,96V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V96A16,16,0,0,0,208,80ZM96,56a32,32,0,1,1,32-32A32,32,0,0,1,96,56ZM208,208H48V96H208V208Zm-68-56a12,12,0,1,1-12-12A12,12,0,0,1,140,152Z"
                      ></path>
                    </svg>
                  </div>
                  <div class="flex flex-col gap-1">
                    <h2 class="text-white text-base font-bold leading-tight">Sistemas de Seguridad</h2>
                    <p class="text-[#a0adbb] text-sm font-normal leading-normal">Protege tu hogar con cerraduras inteligentes, sensores de movimiento y alertas en tiempo real.</p>
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
                    <h2 class="text-white text-base font-bold leading-tight">Control de Clima</h2>
                    <p class="text-[#a0adbb] text-sm font-normal leading-normal">Mantén la temperatura perfecta con termostatos inteligentes y control de clima automatizado.</p>
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
                    <h2 class="text-white text-base font-bold leading-tight">Vigilancia</h2>
                    <p class="text-[#a0adbb] text-sm font-normal leading-normal">Vigila tu propiedad con cámaras de alta definición y acceso remoto.</p>
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
                    <h2 class="text-white text-base font-bold leading-tight">Entretenimiento</h2>
                    <p class="text-[#a0adbb] text-sm font-normal leading-normal">Disfruta de integración perfecta con tus sistemas de música y entretenimiento favoritos.</p>
                  </div>
                </div>
              </div>
            </div>
            <h2 id="how-it-works" class="text-white text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5 scroll-mt-20">¿Cómo Funciona?</h2>
            <p class="text-white text-base font-normal leading-normal pb-3 pt-1 px-4">
              DomoticLink se integra con los sistemas existentes de tu hogar para crear una experiencia de hogar inteligente unificada. Nuestro sistema utiliza un centro de control para conectar todos tus dispositivos, permitiéndote controlarlos desde una sola aplicación. Con funciones avanzadas de automatización, tu hogar aprende tus preferencias y ajusta la configuración automáticamente, ahorrándote tiempo y ofreciendo la máxima comodidad.
            </p>
            <!-- Sección de Descarga de Aplicación -->
            <section id="app" class="app-section scroll-mt-20">
              <h2 class="text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3">Descargar App</h2>
              <p class="text-base font-normal leading-normal pb-6 px-4">
                Descarga nuestra aplicación para controlar tu hogar inteligente desde cualquier lugar. Disponible para iOS y Android.
              </p>
              <div class="flex flex-col md:flex-row gap-4 px-4">
                <a href="#" class="flex items-center justify-center gap-2 bg-black text-white px-6 py-3 rounded-lg hover:bg-gray-800 transition-colors">
                  <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M17.05 20.28c-.98.95-2.05.8-3.08.35-1.09-.46-2.09-.48-3.24 0-1.44.62-2.2.44-3.06-.35C2.79 15.25 3.51 7.59 9.05 7.31c1.35.07 2.29.74 3.08.8 1.18-.24 2.31-.93 3.57-.84 1.51.12 2.65.72 3.4 1.8-3.12 1.87-2.38 5.98.48 7.13-.57 1.5-1.31 2.99-2.53 4.08zM12 6.8c0-1.4 1.15-2.64 2.1-3.7-.33-2.24-2.21-3.02-2.1-3.7C10.1.1 9.31 2.3 11.34 4.1c.75.64 1.66 1.03 2.66 1.14-.02-.16.01-.3 0-.44z"></path>
                  </svg>
                  <div class="text-left">
                    <div class="text-xs">Descargar en la</div>
                    <div class="text-xl font-semibold">App Store</div>
                  </div>
                </a>
                <a href="#" class="flex items-center justify-center gap-2 bg-black text-white px-6 py-3 rounded-lg hover:bg-gray-800 transition-colors">
                  <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M3.609 1.814L13.792 12 3.61 22.186a.996.996 0 0 1-.61-.92v-18.53a1 1 0 0 1 .609-.922zm.921 2.387L11 11.955 4.53 19.673 4.53 4.201zM14.043 12l4.174 4.174-2.704 2.705-4.175-4.175 2.705-2.704zM19.5 14.573l-2.75-2.75 2.75-2.75.002 5.5z"></path>
                  </svg>
                  <div class="text-left">
                    <div class="text-xs">Obtén en</div>
                    <div class="text-xl font-semibold">Google Play</div>
                  </div>
                </a>
              </div>
            </section>

            <!-- Sección de Tour Virtual -->
            <section id="virtual-tour" class="virtual-tour-section scroll-mt-20">
              <div id="tour-initial-content">
                <h2 class="text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3">Tour Virtual</h2>
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
                    <button id="start-tour-btn" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-full transition-colors">
                      Iniciar Tour
                    </button>
                  </div>
                </div>
              </div>
              <div id="tour-iframe-container" class="hidden relative mx-4 aspect-video rounded-xl overflow-hidden">
                <button id="close-tour-btn" class="absolute top-4 right-4 z-10 bg-gray-900 bg-opacity-80 text-white rounded-full px-3 py-1 font-bold hover:bg-opacity-100">Cerrar</button>
                <iframe src="/casa-de-infonavit/public/utils/tourvirtual.html" class="w-full h-full min-h-[400px] rounded-xl border-0" allowfullscreen></iframe>
              </div>
            </section>
            <script>
              document.addEventListener('DOMContentLoaded', function() {
                var startBtn = document.getElementById('start-tour-btn');
                var closeBtn = document.getElementById('close-tour-btn');
                var initialContent = document.getElementById('tour-initial-content');
                var iframeContainer = document.getElementById('tour-iframe-container');
                if (startBtn) {
                  startBtn.addEventListener('click', function() {
                    initialContent.style.display = 'none';
                    iframeContainer.classList.remove('hidden');
                  });
                }
                if (closeBtn) {
                  closeBtn.addEventListener('click', function() {
                    iframeContainer.classList.add('hidden');
                    initialContent.style.display = '';
                  });
                }
              });
            </script>
            <h2 class="text-white text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Tour Virtual</h2>
            <p class="text-white text-base font-normal leading-normal pb-3 pt-1 px-4">
              Explora una casa inteligente con nuestro tour virtual interactivo. Descubre cómo la tecnología puede transformar tu hogar.
            </p>
            <h2 class="text-white text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Contacto</h2>
            <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
              <label class="flex flex-col min-w-40 flex-1">
                <input
                  placeholder="Tu Nombre"
                  class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-white focus:outline-0 focus:ring-0 border-none bg-[#2c363f] focus:border-none h-14 placeholder:text-[#a0adbb] p-4 text-base font-normal leading-normal"
                  value=""
                />
              </label>
            </div>
            <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
              <label class="flex flex-col min-w-40 flex-1">
                <input
                  placeholder="Tu Correo Electrónico"
                  class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-white focus:outline-0 focus:ring-0 border-none bg-[#2c363f] focus:border-none h-14 placeholder:text-[#a0adbb] p-4 text-base font-normal leading-normal"
                  value=""
                />
              </label>
            </div>
            <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
              <label class="flex flex-col min-w-40 flex-1">
                <textarea
                  placeholder="Tu Mensaje"
                  class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-white focus:outline-0 focus:ring-0 border-none bg-[#2c363f] focus:border-none min-h-36 placeholder:text-[#a0adbb] p-4 text-base font-normal leading-normal"
                ></textarea>
              </label>
            </div>
            <div class="flex px-4 py-3 justify-start">
              <button
                class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 px-4 bg-[#dae5f0] text-[#151a1e] text-sm font-bold leading-normal tracking-[0.015em]"
              >
                <span class="truncate">Enviar</span>
              </button>
            </div>
          </div>
        </div>
        <!-- Sección Nuestro Equipo -->
        <section id="team" class="py-16 px-4 sm:px-6 lg:px-8" x-data="teamCarousel()">
          <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-center text-white mb-12">Nuestro Equipo</h2>
            
            <!-- Carrusel -->
            <div class="relative">
              <div class="swiper team-swiper">
                <div class="swiper-wrapper pb-10">
                  <template x-for="(member, index) in teamMembers" :key="index">
                    <div class="swiper-slide">
                      <div @click="openModal(member)" class="bg-[#20262d] rounded-lg overflow-hidden shadow-lg transition-all duration-300 hover:scale-105 cursor-pointer mx-2">
                        <div class="h-64 bg-gray-700 flex items-center justify-center">
                          <img :src="member.image" :alt="member.name" class="h-full w-full object-cover">
                        </div>
                        <div class="p-6">
                          <h3 class="text-xl font-semibold text-white" x-text="member.name"></h3>
                          <p class="text-blue-300 mb-2" x-text="member.position"></p>
                          <p class="text-gray-400 text-sm" x-text="member.shortBio"></p>
                        </div>
                      </div>
                    </div>
                  </template>
                </div>
                <!-- Navegación -->
                <div class="swiper-button-next text-blue-400"></div>
                <div class="swiper-button-prev text-blue-400"></div>
                <div class="swiper-pagination"></div>
              </div>
            </div>
          </div>

          <!-- Modal Simple -->
          <div x-show="isOpen" 
               x-cloak
               @click.self="isOpen = false"
               class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-70">
            <div class="bg-[#20262d] rounded-lg max-w-4xl w-full max-h-[90vh] overflow-y-auto">
              <div class="p-6">
                <!-- Encabezado -->
                <div class="flex justify-between items-start mb-6">
                  <h3 class="text-2xl font-bold text-white" x-text="selectedMember.name"></h3>
                  <button @click="isOpen = false" class="text-gray-400 hover:text-white">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </button>
                </div>
                
                <!-- Contenido -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                  <!-- Columna izquierda: Foto e info básica -->
                  <div class="space-y-4">
                    <img :src="selectedMember.image" :alt="selectedMember.name" class="w-full h-64 object-cover rounded-lg">
                    <div>
                      <h4 class="text-lg font-semibold text-blue-300" x-text="selectedMember.position"></h4>
                      <p class="text-gray-400 text-sm mt-1" x-text="selectedMember.email"></p>
                      <p class="text-gray-400 text-sm mt-1" x-text="selectedMember.phone"></p>
                    </div>
                  </div>
                  
                  <!-- Columna derecha: Detalles -->
                  <div class="md:col-span-2 space-y-6">
                    <!-- Biografía -->
                    <div>
                      <h4 class="text-lg font-semibold text-white mb-2">Biografía</h4>
                      <p class="text-gray-300" x-text="selectedMember.bio"></p>
                    </div>
                    
                    <!-- Habilidades -->
                    <div>
                      <h4 class="text-lg font-semibold text-white mb-2">Habilidades</h4>
                      <div class="flex flex-wrap gap-2">
                        <template x-for="(skill, index) in selectedMember.skills" :key="index">
                          <span class="bg-blue-900 text-blue-100 text-xs px-3 py-1 rounded-full" x-text="skill"></span>
                        </template>
                      </div>
                    </div>
                    
                    <!-- Experiencia -->
                    <div>
                      <h4 class="text-lg font-semibold text-white mb-3">Experiencia</h4>
                      <div class="space-y-4">
                        <template x-for="(exp, index) in selectedMember.experience" :key="index">
                          <div class="border-l-2 border-blue-500 pl-4 py-1">
                            <h5 class="text-white font-medium" x-text="exp.role"></h5>
                            <p class="text-blue-300 text-sm" x-text="exp.company"></p>
                            <p class="text-gray-400 text-xs" x-text="exp.duration"></p>
                          </div>
                        </template>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

        <script>
        function teamCarousel() {
          return {
            isOpen: false,
            selectedMember: null,
            teamMembers: [
              {
                name: 'María González',
                position: 'CEO & Fundadora',
                email: 'maria@domoticlink.com',
                phone: '+52 55 1234 5678',
                image: 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=688&q=80',
                shortBio: 'Experta en automatización del hogar con más de 10 años de experiencia en el sector.',
                bio: 'Ingeniera en Sistemas con más de 10 años de experiencia en el diseño e implementación de soluciones de domótica residencial. Apasionada por crear hogares más inteligentes y eficientes que mejoren la calidad de vida de las personas.',
                skills: ['Automatización', 'IoT', 'Liderazgo', 'Estrategia'],
                experience: [
                  { role: 'CEO & Fundadora', company: 'DomoticLink', duration: '2020 - Presente' },
                  { role: 'Ingeniera Senior', company: 'SmartHome Solutions', duration: '2015 - 2020' },
                  { role: 'Desarrolladora IoT', company: 'TechHome', duration: '2012 - 2015' }
                ]
              },
              {
                name: 'Carlos Mendoza',
                position: 'Ingeniero en Sistemas',
                email: 'carlos@domoticlink.com',
                phone: '+52 55 2345 6789',
                image: 'https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80',
                shortBio: 'Especialista en integración de sistemas y desarrollo de software para hogares inteligentes.',
                bio: 'Ingeniero en Sistemas con amplia experiencia en el desarrollo de software para sistemas de automatización del hogar. Especializado en la integración de diferentes tecnologías para crear soluciones personalizadas.',
                skills: ['JavaScript', 'Python', 'IoT', 'Seguridad'],
                experience: [
                  { role: 'Ingeniero en Sistemas', company: 'DomoticLink', duration: '2020 - Presente' },
                  { role: 'Desarrollador Full Stack', company: 'HomeAuto', duration: '2017 - 2020' },
                  { role: 'Practicante de Desarrollo', company: 'TechSolutions', duration: '2016 - 2017' }
                ]
              },
              {
                name: 'Ana Torres',
                position: 'Diseñadora UX/UI',
                email: 'ana@domoticlink.com',
                phone: '+52 55 3456 7890',
                image: 'https://images.unsplash.com/photo-1573496358961-3cde61c0d912?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80',
                shortBio: 'Crea experiencias de usuario intuitivas para nuestras aplicaciones de control doméstico.',
                bio: 'Diseñadora de experiencia de usuario con pasión por crear interfaces intuitivas y hermosas. Especializada en aplicaciones de control domótico, se enfoca en hacer que la tecnología sea accesible para todos los usuarios.',
                skills: ['UI/UX Design', 'Figma', 'Prototipado', 'Investigación de Usuarios'],
                experience: [
                  { role: 'Diseñadora UX/UI', company: 'DomoticLink', duration: '2021 - Presente' },
                  { role: 'Diseñadora de Producto', company: 'DigitalHome', duration: '2019 - 2021' },
                  { role: 'Diseñadora Gráfica', company: 'CreativeMinds', duration: '2017 - 2019' }
                ]
              },
              {
                name: 'Javier Ramírez',
                position: 'Técnico en Instalaciones',
                email: 'javier@domoticlink.com',
                phone: '+52 55 4567 8901',
                image: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80',
                shortBio: 'Experto en instalación y mantenimiento de sistemas de domótica residencial.',
                bio: 'Técnico certificado con más de 8 años de experiencia en la instalación y mantenimiento de sistemas de domótica. Se especializa en la integración de sistemas de seguridad, iluminación y climatización inteligente.',
                skills: ['Instalación', 'Mantenimiento', 'Redes', 'Soporte Técnico'],
                experience: [
                  { role: 'Técnico Senior', company: 'DomoticLink', duration: '2019 - Presente' },
                  { role: 'Técnico en Instalaciones', company: 'SmartTech', duration: '2016 - 2019' },
                  { role: 'Asistente Técnico', company: 'ElectroHome', duration: '2014 - 2016' }
                ]
              },
              {
                name: 'Laura Sánchez',
                position: 'Especialista en Atención a Clientes',
                email: 'laura@domoticlink.com',
                phone: '+52 55 5678 9012',
                image: 'https://images.unsplash.com/photo-1573496358773-9d29caf5f790?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80',
                shortBio: 'Brinda soporte excepcional y soluciones personalizadas a nuestros clientes.',
                bio: 'Profesional en atención al cliente con amplia experiencia en el sector tecnológico. Se especializa en brindar soporte técnico personalizado y garantizar la satisfacción total de los clientes con nuestros sistemas de domótica.',
                skills: ['Atención al Cliente', 'Soporte Técnico', 'Resolución de Problemas', 'Ventas'],
                experience: [
                  { role: 'Especialista en Atención', company: 'DomoticLink', duration: '2020 - Presente' },
                  { role: 'Ejecutiva de Soporte', company: 'TechSupport', duration: '2018 - 2020' },
                  { role: 'Asesora de Ventas', company: 'ElectroShop', duration: '2016 - 2018' }
                ]
              }
            ],
            openModal(member) {
              this.selectedMember = member;
              this.isOpen = true;
              document.body.style.overflow = 'hidden';
            },
            closeModal() {
              this.isOpen = false;
              document.body.style.overflow = 'auto';
            },
            init() {
              // Inicializar el carrusel cuando el componente esté montado
              this.$nextTick(() => {
                new Swiper('.team-swiper', {
                  slidesPerView: 1,
                  spaceBetween: 20,
                  loop: true,
                  autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                  },
                  pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                  },
                  navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                  },
                  breakpoints: {
                    640: {
                      slidesPerView: 2,
                    },
                    1024: {
                      slidesPerView: 3,
                    },
                    1280: {
                      slidesPerView: 4,
                    },
                  },
                });
              });
            }
          };
        }
        </script>
      </main>
      
      <footer class="flex justify-center">
          <div class="flex max-w-[960px] flex-1 flex-col">
            <footer class="flex flex-col gap-6 px-5 py-10 text-center @container">
              <div class="flex flex-wrap items-center justify-center gap-6 @[480px]:flex-row @[480px]:justify-around">
                <a class="text-[#a0adbb] text-base font-normal leading-normal min-w-40" href="#">Política de Privacidad</a>
                <a class="text-[#a0adbb] text-base font-normal leading-normal min-w-40" href="#">Términos de Servicio</a>
                <a class="text-[#a0adbb] text-base font-normal leading-normal min-w-40" href="#">Contáctanos</a>
              </div>
              <div class="flex justify-center">
                <div class="h-16 w-16">
                  <img src="public/image/logo.jpeg" alt="Logo DomoticLink" class="h-full w-full object-contain">
                </div>
              </div>
              <p class="text-[#a0adbb] text-base font-normal leading-normal">© 2024 DomoticLink. Todos los derechos reservados.</p>
            </footer>
          </div>

    </div>
    <!-- <script type="module" src="/public/a.js"></script> -->
</body>
      <!-- Three.js y dependencias -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.7.1/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.7.1/ScrollTrigger.min.js"></script>
<script type="module" src="public/a.js"></script>
</html>
