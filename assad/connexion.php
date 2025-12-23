 <!DOCTYPE html>
 <html class="light" lang="fr">

 <head>
     <meta charset="utf-8" />
     <meta content="width=device-width, initial-scale=1.0" name="viewport" />
     <title>ASSAD - Connexion / Inscription</title>
     <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
     <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
         rel="stylesheet" />
     <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
         rel="stylesheet" />
     <script id="tailwind-config">
         tailwind.config = {
             darkMode: "class",
             theme: {
                 extend: {
                     colors: {
                         "primary": "#ec7f13",
                         "background-light": "#f8f7f6",
                         "background-dark": "#221910",
                         "surface-light": "#ffffff",
                         "surface-dark": "#2d241b",
                         "text-main": "#1b140d",
                         "text-muted": "#9a734c",
                     },
                     fontFamily: {
                         "display": ["Plus Jakarta Sans", "sans-serif"]
                     },
                     borderRadius: {
                         "DEFAULT": "0.5rem",
                         "lg": "1rem",
                         "xl": "1.5rem",
                         "full": "9999px"
                     },
                 },
             },
         }
     </script>
     <style>
         body {
             font-family: "Plus Jakarta Sans", "Noto Sans", sans-serif;
         }
     </style>
 </head>

 <body class="bg-background-light dark:bg-background-dark min-h-screen flex flex-col text-text-main dark:text-white">

     <header
         class="sticky top-0 z-50 w-full border-b border-[#f3ede7] dark:border-[#3d3228] bg-surface-light/90 dark:bg-surface-dark/90 backdrop-blur-md">
         <div class="px-6 lg:px-20 py-3 flex items-center justify-between">
             <div class="flex items-center gap-3 text-text-main dark:text-white">
                 <div class="size-8 text-primary">
                     <span class="material-symbols-outlined text-[32px]">pets</span>
                 </div>
                 <h2 class="text-xl font-bold tracking-tight">ASSAD </h2>
             </div>
         </div>
     </header>

     <main class="flex-1 w-full flex flex-col md:flex-row h-[calc(100vh-64px)] overflow-hidden">

         <div class="hidden lg:flex w-1/2 relative bg-surface-dark overflow-hidden flex-col justify-end p-12">
             <div class="absolute inset-0 z-0">
                 <img alt="Majestic Atlas Lion portrait looking right" class="w-full h-full object-cover opacity-80"
                     data-alt="Majestic Atlas Lion portrait looking right"
                     src="https://lh3.googleusercontent.com/aida-public/AB6AXuAQ_bKae381kvpRy3XigGpnQjv3W9-AtutgEe4jJysFKleqGcOybkYyMOTbVnRrFdzZ4C3hzpTcUtgtpeWxoZhJdSiQbw2olD3R_9_2FsJM6KowFKfdv2814bIZMg8kqU3iiM0b26PFIJMY__bvemt359xMOdiFk0CBkRhsM8igxOF_znIJ7ZZd_6PBc0EyXMAMClJOeI1oYih4CJRB3QiEjeNAQrr6xYX-pRvfqNEhO9wp9PKDHa_MJRQfE2_265lS3bQidcsezMZb" />
                 <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
             </div>
             <div class="relative z-10 max-w-lg">
                 <div
                     class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/20 border border-primary/30 backdrop-blur-sm mb-6">
                     <span class="material-symbols-outlined text-primary text-sm">stadium</span>
                     <span class="text-primary text-xs font-bold uppercase tracking-wider">CAN 2025 Maroc</span>
                 </div>
                 <h1 class="text-5xl font-extrabold text-white leading-tight mb-4">
                     Vivez la légende des <span class="text-primary">Lions de l'Atlas</span>
                 </h1>
                 <p class="text-lg text-gray-300 mb-8 leading-relaxed">
                     Plongez au cœur de la faune marocaine et célébrez la Coupe d'Afrique des Nations 2025 avec une
                     expérience virtuelle immersive.
                 </p>
                 <div class="flex gap-4">
                     <div class="flex -space-x-3">
                         <img alt="User Avatar 1" class="w-10 h-10 rounded-full border-2 border-white"
                             data-alt="Portrait of a smiling user"
                             src="https://lh3.googleusercontent.com/aida-public/AB6AXuC1hiwGajICp_UEGaXMz2neIrdSWJfMOKxiSu5-v3nQYKxjQXhJS4UUok9UjigOGBl6CmVBnXAjP5v_3WR5KxM8nJ2KhvXbDVUUHLhdq7skdVUDjT-vnuhFD8pK2znX8YZ_IXuanhzvQzSrW-coxCtS8NLbq6uzr9ciOdVbMBwyoMnm7HMWbnHLyZ67HJfIy7kE_j3GYhdqAz8AO7gD6kUIknv809iTK56nAd7lWTjGeD8nfq_rGtswWrp9Rh4BXDGzQktr4_x1BeIN" />
                         <img alt="User Avatar 2" class="w-10 h-10 rounded-full border-2 border-white"
                             data-alt="Portrait of a user"
                             src="https://lh3.googleusercontent.com/aida-public/AB6AXuBDTW-bDVCbZ1f6YTW14Umc6wNs7d6TiFSsAGv7kquQtvezt5_IIOjbpdXBwY1blpBNQCZzo2-Ev2RSwPV2LDTBbcozWcAMqwU4W1-_gsovHR7aXzdYdsng51XFu5C-BzPCUY_6vtcKEYLylKeyCUs9X8M_j14HkDNhFwWHX3lug0NsK4tofzwF5uXmJ-pqEOCZ52gDodLSvZTxUKQf4HI8rlgpF3G3FecHl6l74bKWCluVSyAWVUVUUfKxgV1Y1T1Ksu6VD0oyF4jh" />
                         <img alt="User Avatar 3" class="w-10 h-10 rounded-full border-2 border-white"
                             data-alt="Portrait of a user"
                             src="https://lh3.googleusercontent.com/aida-public/AB6AXuCWGTcNmBfwQlV5lLzrmC2-rcPC3aIpjXOn2yAVyeyy9O7WmobVfQg_CWBLlUf2-JffFE7qJDtCPB02m7Da7Fcq6O6nUhV4ihBg1DiJK9TXua5qvPpaGwycWNNUPNkzrNnT4ZQC0R8oY-KvOUS8jSk58iGebWiHGuisW_rmDwx9rZX228yjBebPX4xYSyj0MSQFLHOoweHXuLLC7zz0la6awnnrIp2zXab4olSQsijcwgOPXiITYr1umALu13IeHs17JRKCK7of769D" />
                     </div>
                     <p class="text-white text-sm flex items-center font-medium">Rejoint par +15k fans</p>
                 </div>
             </div>
         </div>

         <div
             class="w-full lg:w-1/2 flex items-center justify-center bg-surface-light dark:bg-background-dark p-6 overflow-y-auto">
             <div class="w-full max-w-md flex flex-col gap-6">

                 <div class="lg:hidden text-center mb-4">
                     <h1 class="text-3xl font-bold text-text-main dark:text-white mb-2">Zoo Virtuel ASSAD</h1>
                     <p class="text-text-muted">L'aventure commence ici.</p>
                 </div>

                 <div class="flex border-b border-[#e7dbcf] dark:border-white/10 mb-2">
                     <button id="loginTabButton" data-tab="login"
                         class="flex-1 pb-4 text-center border-b-[3px] border-transparent text-text-muted hover:text-text-main dark:hover:text-white transition-colors font-medium text-sm tracking-wide">
                         Connexion
                     </button>
                     <button id="registerTabButton" data-tab="register"
                         class="flex-1 pb-4 text-center border-b-[3px] border-primary text-text-main dark:text-white font-bold text-sm tracking-wide">
                         Inscription
                     </button>
                 </div>

                 <div id="loginForm" class="tab-content hidden">
                     <form method="POST" action="php/seconnecter.php" class="flex flex-col gap-5 mt-2">
                         <div class="flex flex-col gap-2">
                             <label class="text-sm font-bold text-text-main dark:text-white" for="email">Adresse
                                 e-mail</label>
                             <div class="relative">
                                 <div class="absolute left-3 top-1/2 -translate-y-1/2 text-text-muted">
                                     <span class="material-symbols-outlined text-[20px]">mail</span>
                                 </div>
                                 <input
                                     class="w-full h-12 pl-10 pr-4 bg-white dark:bg-white/5 border border-[#e7dbcf] dark:border-white/10 rounded-lg text-sm text-text-main dark:text-white placeholder:text-text-muted/70 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all"
                                     name="email" id="email" placeholder="nom@exemple.com" type="email" />
                             </div>
                         </div>
                         <div class="flex flex-col gap-2">
                             <div class="flex justify-between items-center">
                                 <label class="text-sm font-bold text-text-main dark:text-white" for="password">Mot de
                                     passe</label>
                                 <a class="text-xs font-semibold text-primary hover:underline" href="#">Oublié ?</a>
                             </div>
                             <div class="relative">
                                 <div class="absolute left-3 top-1/2 -translate-y-1/2 text-text-muted">
                                     <span class="material-symbols-outlined text-[20px]">lock</span>
                                 </div>
                                 <input
                                     class="w-full h-12 pl-10 pr-10 bg-white dark:bg-white/5 border border-[#e7dbcf] dark:border-white/10 rounded-lg text-sm text-text-main dark:text-white placeholder:text-text-muted/70 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all"
                                     id="password" name="password" placeholder="••••••••" type="password" />
                                 <button
                                     class="absolute right-3 top-1/2 -translate-y-1/2 text-text-muted hover:text-text-main dark:hover:text-white"
                                     type="button">
                                     <span class="material-symbols-outlined text-[20px]">visibility_off</span>
                                 </button>
                             </div>
                         </div>
                         <button
                             class="mt-2 w-full h-12 bg-primary hover:bg-[#d9720b] text-white dark:text-[#1b140d] font-bold rounded-lg shadow-lg shadow-primary/25 transition-all flex items-center justify-center gap-2 group"
                             type="submit">
                             <span>Se connecter</span>
                             <span
                                 class="material-symbols-outlined text-lg group-hover:translate-x-1 transition-transform">arrow_forward</span>
                         </button>
                     </form>



                     <p class="text-center text-sm text-text-muted mt-4">
                         Pas encore de compte ?
                         <a class="font-bold text-primary hover:text-primary/80" href="#"
                             id="switchToRegisterLink">S'inscrire gratuitement</a>
                     </p>
                 </div>

                 <div id="registerForm" class="tab-content">
                     <form action="php/inscrire.php" method="POST" class="flex flex-col gap-5 mt-2">

                         <div class="flex flex-col gap-2">
                             <label class="text-sm font-bold text-text-main dark:text-white" for="full-name">Nom et
                                 Prénom</label>
                             <div class="relative">
                                 <div class="absolute left-3 top-1/2 -translate-y-1/2 text-text-muted">
                                     <span class="material-symbols-outlined text-[20px]">person</span>
                                 </div>
                                 <input name="full-name"
                                     class="w-full h-12 pl-10 pr-4 bg-white dark:bg-white/5 border border-[#e7dbcf] dark:border-white/10 rounded-lg text-sm text-text-main dark:text-white placeholder:text-text-muted/70 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all"
                                     id="full-name" placeholder="Votre Nom et Prénom" type="text" required />
                             </div>
                         </div>

                         <div class="flex flex-col gap-2">
                             <label class="text-sm font-bold text-text-main dark:text-white" for="Pays">Pays</label>
                             <div class="relative">
                                 <div class="absolute left-3 top-1/2 -translate-y-1/2 text-text-muted">
                                     <span class="material-symbols-outlined text-[20px]">add</span>
                                 </div>
                                 <input name="pays"
                                     class="w-full h-12 pl-10 pr-4 bg-white dark:bg-white/5 border border-[#e7dbcf] dark:border-white/10 rounded-lg text-sm text-text-main dark:text-white placeholder:text-text-muted/70 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all"
                                     id="pays" placeholder="Votre Pays" type="text" required />
                             </div>
                         </div>

                         <div class="flex flex-col gap-2">
                             <label class="text-xs font-semibold uppercase tracking-wider text-text-muted ml-1">Je
                                 m'inscris en tant que</label>
                             <div class="bg-[#f3ede7] dark:bg-white/5 p-1 rounded-xl flex h-12 relative">
                                 <label
                                     class="flex-1 cursor-pointer relative z-10 h-full flex items-center justify-center gap-2 rounded-lg transition-all has-[:checked]:bg-white dark:has-[:checked]:bg-surface-dark has-[:checked]:shadow-sm has-[:checked]:text-primary text-text-muted">
                                     <input checked="" class="hidden peer" name="role" type="radio" value="visiteur" />
                                     <span class="material-symbols-outlined text-[20px]">visibility</span>
                                     <span class="font-bold text-sm">Visiteur</span>
                                 </label>
                                 <label
                                     class="flex-1 cursor-pointer relative z-10 h-full flex items-center justify-center gap-2 rounded-lg transition-all has-[:checked]:bg-white dark:has-[:checked]:bg-surface-dark has-[:checked]:shadow-sm has-[:checked]:text-primary text-text-muted">
                                     <input class="hidden peer" name="role" type="radio" value="guide" />
                                     <span class="material-symbols-outlined text-[20px]">record_voice_over</span>
                                     <span class="font-bold text-sm">Guide</span>
                                 </label>
                             </div>
                         </div>

                         <div class="flex flex-col gap-2">
                             <label class="text-sm font-bold text-text-main dark:text-white" for="reg-email">Adresse
                                 e-mail</label>
                             <div class="relative">
                                 <div class="absolute left-3 top-1/2 -translate-y-1/2 text-text-muted">
                                     <span class="material-symbols-outlined text-[20px]">mail</span>
                                 </div>
                                 <input
                                     class="w-full h-12 pl-10 pr-4 bg-white dark:bg-white/5 border border-[#e7dbcf] dark:border-white/10 rounded-lg text-sm text-text-main dark:text-white placeholder:text-text-muted/70 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all"
                                     id="reg-email" name="reg-email" placeholder="nom@exemple.com" type="email" required />
                             </div>
                         </div>

                         <div class="flex flex-col gap-2">
                             <label class="text-sm font-bold text-text-main dark:text-white" for="reg-password">Mot de
                                 passe</label>
                             <div class="relative">
                                 <div class="absolute left-3 top-1/2 -translate-y-1/2 text-text-muted">
                                     <span class="material-symbols-outlined text-[20px]">lock</span>
                                     </span>
                                 </div>
                                 <input
                                     class="w-full h-12 pl-10 pr-10 bg-white dark:bg-white/5 border border-[#e7dbcf] dark:border-white/10 rounded-lg text-sm text-text-main dark:text-white placeholder:text-text-muted/70 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all"
                                     id="reg-password" name="reg-password" placeholder="••••••••" type="password" required />
                                 <button
                                     class="absolute right-3 top-1/2 -translate-y-1/2 text-text-muted hover:text-text-main dark:hover:text-white"
                                     type="button">
                                     <span class="material-symbols-outlined text-[20px]">visibility_off</span>
                                 </button>
                             </div>
                         </div>

                         <button
                             class="mt-2 w-full h-12 bg-primary hover:bg-[#d9720b] text-white dark:text-[#1b140d] font-bold rounded-lg shadow-lg shadow-primary/25 transition-all flex items-center justify-center gap-2 group"
                             type="submit">
                             <span>S'inscrire</span>
                             <span
                                 class="material-symbols-outlined text-lg group-hover:translate-x-1 transition-transform">how_to_reg</span>
                         </button>
                     </form>

                     <p class="text-center text-sm text-text-muted mt-4">
                         Déjà un compte ?
                         <a class="font-bold text-primary hover:text-primary/80" href="#" id="switchToLoginLink">Se
                             connecter</a>
                     </p>
                 </div>

             </div>
         </div>
     </main>

     <script>
         document.addEventListener('DOMContentLoaded', function() {
             const loginTabButton = document.getElementById('loginTabButton');
             const registerTabButton = document.getElementById('registerTabButton');
             const loginForm = document.getElementById('loginForm');
             const registerForm = document.getElementById('registerForm');

             // Liens rapides dans le texte
             const switchToRegisterLink = document.getElementById('switchToRegisterLink');
             const switchToLoginLink = document.getElementById('switchToLoginLink');

             /**
              * Met à jour les classes pour le bouton d'onglet actif.
              * @param {HTMLElement} activeButton - Le bouton à activer.
              * @param {HTMLElement} inactiveButton - Le bouton à désactiver.
              */
             function updateTabClasses(activeButton, inactiveButton) {
                 // Classes pour l'état ACTIF
                 activeButton.classList.remove('border-transparent', 'text-text-muted', 'hover:text-text-main', 'dark:hover:text-white', 'font-medium');
                 activeButton.classList.add('border-primary', 'text-text-main', 'dark:text-white', 'font-bold');

                 // Classes pour l'état INACTIF
                 inactiveButton.classList.remove('border-primary', 'text-text-main', 'dark:text-white', 'font-bold');
                 inactiveButton.classList.add('border-transparent', 'text-text-muted', 'hover:text-text-main', 'dark:hover:text-white', 'font-medium');
             }

             /**
              * Bascule l'affichage des formulaires.
              * @param {string} tabName - Le nom de l'onglet à afficher ('login' ou 'register').
              */
             function switchTab(tabName) {
                 if (tabName === 'login') {
                     updateTabClasses(loginTabButton, registerTabButton);
                     loginForm.classList.remove('hidden');
                     registerForm.classList.add('hidden');
                 } else if (tabName === 'register') {
                     updateTabClasses(registerTabButton, loginTabButton);
                     loginForm.classList.add('hidden');
                     registerForm.classList.remove('hidden');
                 }
             }

             // --- Écouteurs d'événements pour les boutons d'onglet ---
             loginTabButton.addEventListener('click', () => switchTab('login'));
             registerTabButton.addEventListener('click', () => switchTab('register'));

             // --- Écouteurs d'événements pour les liens rapides (bas de page) ---
             if (switchToRegisterLink) {
                 switchToRegisterLink.addEventListener('click', (e) => {
                     e.preventDefault();
                     switchTab('register');
                 });
             }

             if (switchToLoginLink) {
                 switchToLoginLink.addEventListener('click', (e) => {
                     e.preventDefault();
                     switchTab('login');
                 });
             }

             // Initialisation: Afficher l'onglet INSCRIPTION par défaut
             switchTab('register');
         });
     </script>
 </body>

 </html>