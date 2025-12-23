<!DOCTYPE html>

<html class="light" lang="fr">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Asaad - Zoo Virtuel ASSAD</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200..800&amp;display=swap"
        rel="stylesheet" />
    <!-- Material Symbols -->
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <!-- Theme Configuration -->
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
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .filled-icon {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-[#1b140d] dark:text-white font-display overflow-x-hidden">
    <!-- TopNavBar -->
    <header
        class="sticky top-0 z-50 bg-background-light/95 dark:bg-background-dark/95 backdrop-blur-md border-b border-[#f3ede7] dark:border-[#3a2e24]">
        <div class="px-4 md:px-10 py-3 flex items-center justify-between max-w-[1440px] mx-auto">
            <div class="flex items-center gap-8">
                <div class="flex items-center gap-4 text-[#1b140d] dark:text-white">
                    <div class="size-8 text-primary">
                        <span class="material-symbols-outlined !text-3xl filled-icon">pets</span>
                    </div>
                    <h2 class="text-lg font-bold leading-tight tracking-[-0.015em]">ASSAD</h2>
                </div>

            </div>
            <div class="flex items-center gap-4">

                <a href="./connexion.php"
                    class="flex cursor-pointer items-center justify-center rounded-xl h-10 px-5 bg-primary hover:bg-primary/90 text-white text-sm font-bold transition-colors shadow-lg shadow-primary/20">
                    <span class="truncate">Connexion</span>
                </a>
            </div>
        </div>
    </header>
    <main class="flex flex-col w-full">
        <!-- HeroSection -->
        <section class="relative w-full h-[85vh] min-h-[600px] flex items-end pb-16 px-4 md:px-20 bg-cover bg-center"
            data-alt="Majestic close-up of a male Atlas Lion with a dark mane looking towards the sunset"
            style='background-image: linear-gradient(180deg, rgba(34, 25, 16, 0.1) 0%, rgba(34, 25, 16, 0.8) 100%), url("https://lh3.googleusercontent.com/aida-public/AB6AXuD0QTcMHscbTHh6rVjt1jPCT6A0BU-qx3WTxRNW34LU7QquVTvoWbfA4DCOf8jyun8D3cHw-u_YB-VTBk6RyW1pnPcdew_5l1y4coOHLh9bT6myfJlCvo1TjGZ57YVB2nKCinvWrMFkEh14YarpB25dpphx2ysfOkALoFpKO7rKaB0-JJzPzD7tFNhyH4mVGmQ4lpilju3JYS2w7z6nFlDfFBThXhIXuJ81GARZDG6B3ASm_ObqSA-8A8srQZAct9sGvagIo9J0Pf3Y");'>
            <div
                class="max-w-[1440px] w-full mx-auto relative z-10 flex flex-col md:flex-row items-end justify-between gap-8">
                <div class="flex flex-col gap-4 max-w-2xl animate-fade-in-up">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/20 border border-primary/30 backdrop-blur-sm w-fit">
                        <span class="material-symbols-outlined text-primary text-sm filled-icon">verified</span>
                        <span class="text-primary font-bold text-xs uppercase tracking-wider">Mascotte Officielle CAN
                            2025</span>
                    </div>
                    <h1 class="text-white text-5xl md:text-7xl font-black leading-tight tracking-tight">
                        Rencontrez Asaad
                    </h1>
                    <p class="text-gray-200 text-lg md:text-xl font-medium max-w-xl">
                        Symbole de force et de fierté nationale. Découvrez l'histoire du Lion de l'Atlas, gardien
                        spirituel de notre équipe.
                    </p>
                    <div class="flex flex-wrap gap-4 mt-4">
                        <button
                            class="flex items-center gap-2 h-12 px-6 rounded-xl bg-primary hover:bg-primary/90 text-white font-bold transition-transform hover:scale-105 shadow-lg shadow-primary/30">
                            <span class="material-symbols-outlined">volume_up</span>
                            <span>Écouter son rugissement</span>
                        </button>
                        <button
                            class="flex items-center gap-2 h-12 px-6 rounded-xl bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/30 text-white font-bold transition-colors">
                            <span class="material-symbols-outlined">videocam</span>
                            <span>Visite Virtuelle</span>
                        </button>
                    </div>
                </div>
                <!-- Quick contextual fact -->
                <div
                    class="hidden md:flex flex-col bg-black/40 backdrop-blur-md p-6 rounded-xl border border-white/10 max-w-xs">
                    <span class="text-primary font-bold text-sm mb-1">LE SAVIEZ-VOUS ?</span>
                    <p class="text-white text-sm leading-relaxed">Le rugissement d'un lion de l'Atlas pouvait s'entendre
                        à plus de 8 km à travers les montagnes.</p>
                </div>
            </div>
        </section>
        <!-- Stats Section -->
        <section class="py-12 bg-surface-light dark:bg-surface-dark border-b border-[#e7dbcf] dark:border-[#3a2e24]">
            <div class="max-w-[1200px] mx-auto px-4 md:px-10">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-8">
                    <div
                        class="flex flex-col items-center text-center p-6 rounded-2xl bg-background-light dark:bg-background-dark border border-transparent hover:border-primary/30 transition-all group">
                        <div
                            class="p-3 bg-primary/10 rounded-full text-primary mb-3 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined">monitor_weight</span>
                        </div>
                        <p class="text-[#9a734c] text-sm font-semibold uppercase tracking-wider">Poids</p>
                        <p class="text-2xl md:text-3xl font-black text-[#1b140d] dark:text-white mt-1">240 kg</p>
                    </div>
                    <div
                        class="flex flex-col items-center text-center p-6 rounded-2xl bg-background-light dark:bg-background-dark border border-transparent hover:border-primary/30 transition-all group">
                        <div
                            class="p-3 bg-primary/10 rounded-full text-primary mb-3 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined">cake</span>
                        </div>
                        <p class="text-[#9a734c] text-sm font-semibold uppercase tracking-wider">Âge</p>
                        <p class="text-2xl md:text-3xl font-black text-[#1b140d] dark:text-white mt-1">7 Ans</p>
                    </div>
                    <div
                        class="flex flex-col items-center text-center p-6 rounded-2xl bg-background-light dark:bg-background-dark border border-transparent hover:border-primary/30 transition-all group">
                        <div
                            class="p-3 bg-primary/10 rounded-full text-primary mb-3 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined">restaurant_menu</span>
                        </div>
                        <p class="text-[#9a734c] text-sm font-semibold uppercase tracking-wider">Régime</p>
                        <p class="text-2xl md:text-3xl font-black text-[#1b140d] dark:text-white mt-1">Carnivore</p>
                    </div>
                    <div
                        class="flex flex-col items-center text-center p-6 rounded-2xl bg-background-light dark:bg-background-dark border border-transparent hover:border-primary/30 transition-all group">
                        <div
                            class="p-3 bg-primary/10 rounded-full text-primary mb-3 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined">speed</span>
                        </div>
                        <p class="text-[#9a734c] text-sm font-semibold uppercase tracking-wider">Vitesse</p>
                        <p class="text-2xl md:text-3xl font-black text-[#1b140d] dark:text-white mt-1">80 km/h</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Feature / About Section -->
        <section class="py-20 bg-background-light dark:bg-background-dark">
            <div class="max-w-[1200px] mx-auto px-4 md:px-10">
                <div class="flex flex-col lg:flex-row gap-16">
                    <!-- Left Content -->
                    <div class="flex-1 flex flex-col gap-8">
                        <div>
                            <span class="text-primary font-bold uppercase tracking-widest text-sm">L'Histoire</span>
                            <h2 class="text-4xl md:text-5xl font-black leading-tight mt-2 mb-6">Le Roi des Montagnes
                            </h2>
                            <p class="text-lg text-[#5c4a3d] dark:text-gray-300 leading-relaxed mb-6">
                                Asaad n'est pas seulement un lion, c'est un ambassadeur de son espèce. Né au cœur de
                                notre programme de conservation, il incarne la force et la résilience du peuple
                                marocain.
                            </p>
                            <p class="text-lg text-[#5c4a3d] dark:text-gray-300 leading-relaxed">
                                Sa crinière sombre et imposante, qui descend jusqu'au milieu du dos et sous le ventre,
                                est la caractéristique distinctive des légendaires Lions de l'Atlas. À l'occasion de la
                                CAN 2025, Asaad représente l'esprit combatif de nos joueurs sur le terrain.
                            </p>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div
                                class="flex gap-4 p-4 rounded-xl border border-[#e7dbcf] dark:border-[#3a2e24] bg-white dark:bg-surface-dark shadow-sm">
                                <div class="text-primary shrink-0">
                                    <span class="material-symbols-outlined">sports_soccer</span>
                                </div>
                                <div>
                                    <h3 class="font-bold text-lg mb-1">Esprit d'Équipe</h3>
                                    <p class="text-sm text-[#9a734c] dark:text-gray-400">Symbole vivant pour les Lions
                                        de l'Atlas durant la CAN 2025.</p>
                                </div>
                            </div>
                            <div
                                class="flex gap-4 p-4 rounded-xl border border-[#e7dbcf] dark:border-[#3a2e24] bg-white dark:bg-surface-dark shadow-sm">
                                <div class="text-primary shrink-0">
                                    <span class="material-symbols-outlined">shield</span>
                                </div>
                                <div>
                                    <h3 class="font-bold text-lg mb-1">Protecteur</h3>
                                    <p class="text-sm text-[#9a734c] dark:text-gray-400">Calme en apparence, mais féroce
                                        lorsqu'il défend son territoire.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Right Content: Conservation Status & Habitat Map -->
                    <div class="flex-1 flex flex-col gap-8">
                        <!-- Conservation Card -->
                        <div
                            class="p-8 rounded-2xl bg-white dark:bg-surface-dark border border-[#e7dbcf] dark:border-[#3a2e24] shadow-sm">
                            <h3 class="text-xl font-bold mb-6 flex items-center gap-2">
                                <span class="material-symbols-outlined text-red-500">warning</span>
                                Statut de Conservation
                            </h3>
                            <div class="relative pt-6 pb-2">
                                <!-- Status Bar -->
                                <div class="w-full h-3 bg-gray-200 dark:bg-gray-700 rounded-full flex overflow-hidden">
                                    <div class="w-[16%] h-full bg-green-500"></div> <!-- LC -->
                                    <div class="w-[16%] h-full bg-lime-400"></div> <!-- NT -->
                                    <div class="w-[16%] h-full bg-yellow-400"></div> <!-- VU -->
                                    <div class="w-[16%] h-full bg-orange-400"></div> <!-- EN -->
                                    <div class="w-[16%] h-full bg-red-500"></div> <!-- CR -->
                                    <div class="w-[20%] h-full bg-black flex items-center justify-center relative">
                                        <!-- EW -->
                                        <!-- Active Indicator -->
                                        <div
                                            class="absolute -top-3 size-0 border-l-[8px] border-l-transparent border-r-[8px] border-r-transparent border-t-[8px] border-t-black transform rotate-180">
                                        </div>
                                        <div
                                            class="absolute -top-10 left-1/2 -translate-x-1/2 bg-black text-white text-xs font-bold px-3 py-1 rounded-md whitespace-nowrap">
                                            Éteint à l'état sauvage
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="flex justify-between mt-3 text-xs font-bold text-gray-400 uppercase tracking-widest">
                                    <span>LC</span>
                                    <span>NT</span>
                                    <span>VU</span>
                                    <span>EN</span>
                                    <span>CR</span>
                                    <span class="text-black dark:text-white">EW</span>
                                    <span>EX</span>
                                </div>
                            </div>
                            <p
                                class="mt-6 text-sm text-[#5c4a3d] dark:text-gray-400 italic bg-background-light dark:bg-background-dark p-4 rounded-lg">
                                Le Lion de l'Atlas est aujourd'hui éteint à l'état sauvage. Les seuls survivants vivent
                                dans des zoos comme le nôtre, préservant cet héritage génétique unique.
                            </p>
                        </div>
                        <!-- Habitat Map Preview -->
                        <div
                            class="rounded-2xl overflow-hidden border border-[#e7dbcf] dark:border-[#3a2e24] shadow-sm relative group cursor-pointer">
                            <img alt="Map of Atlas Mountains range"
                                class="w-full h-64 object-cover transition-transform duration-700 group-hover:scale-110"
                                data-alt="Satellite view style map showing the Atlas Mountains range in Morocco"
                                data-location="Atlas Mountains, Morocco"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuAi4pdtHawojavwpsXhsgH7XgPTzs-JksRtxHMU5XOTarorP0cwJIqpF3VynIZ-Hh7HJItJeUu-cwqWSCnJNSFQLreY6zx0zOgQqZY78Gdx_omZQBlHB1ETwPng2Y2-y0-hpofdU2OxjO1orcqjEzN0XGB3A08ZveIEB-zJcAvuprOf0Uu38QJdU3kC_-qxpxU_s7ZLVbdcbH2IuUYFQ91R3UJqHG7ZYMq3JKbTlPwkai3UWc_pZCvjEGUtflnWMzq7wrCJkW74jxYW" />
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent flex flex-col justify-end p-6">
                                <h3 class="text-white text-xl font-bold">Habitat Naturel</h3>
                                <p class="text-gray-300 text-sm mt-1">Montagnes de l'Atlas, Afrique du Nord</p>
                                <div
                                    class="mt-4 inline-flex items-center text-primary font-bold text-sm group-hover:underline">
                                    Explorer la carte <span
                                        class="material-symbols-outlined text-sm ml-1">arrow_forward</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Gallery Section -->
        <section class="py-20 bg-surface-light dark:bg-surface-dark">
            <div class="max-w-[1200px] mx-auto px-4 md:px-10">
                <div class="flex justify-between items-end mb-10">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-black">Galerie Photos</h2>
                        <p class="text-[#9a734c] mt-2">Les plus beaux clichés d'Asaad</p>
                    </div>
                    <button class="hidden md:flex items-center gap-2 text-primary font-bold hover:underline">
                        Voir tout <span class="material-symbols-outlined">arrow_forward</span>
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 h-auto md:h-[600px]">
                    <!-- Large item -->
                    <div class="md:col-span-2 md:row-span-2 rounded-2xl overflow-hidden group relative">
                        <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                            data-alt="Full body shot of Asaad the lion resting on a rock"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuBiiLFHZcRYW82exMIplRXp8WnDyZmsbUi8Bxa8O3wK2gDTeW3D0Hyy84PP69LtP2yOsfJc_dW3w3f9i4oBNvyPHWdKOvgwJgGmMmUKScMQth5FmWfoi3LPeih03KyM1VfBUTNwFUNJJtizs1DvilVQqE2aSI6QlFrMBJxeUBONRvcUPVJvKwBBhyHZ9Q-d1Lto4pUi8_HnF8XvJTS6m6ies7AM1IibENrRnmwXSf5aRADamUuEz1KXV6lkeoWzcLYNpi1iI5lw591P" />
                        <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition-colors"></div>
                    </div>
                    <!-- Small item 1 -->
                    <div class="rounded-2xl overflow-hidden group relative">
                        <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                            data-alt="Close up of lion's eye and texture of the mane"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuAZXrwwnvRsm0ilU2hl26nfWtiDMgertW37JtfK72uPxKOhF-cR0_xu0Jzbj3JCjq8y6bjfVgU9f4UmqsocukoA68hKIIcFGCIT-difI49vwO2BsRMdga1v6lg-VV45BlOZPfH0XVAV78mkiUjyHf1bN3z-qEzuSFJRN9dmBh4N5-WvaLgfC6eWA-A0dj8kKLIxrJxXYgT1nKXTGJapyhcc13zJ4tOsN7PWme0r-M3Jpbi9G2Z4Kh1UCTqF7dOBmhcROVq9-0LLZrtO" />
                    </div>
                    <!-- Small item 2 -->
                    <div class="rounded-2xl overflow-hidden group relative">
                        <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                            data-alt="Asaad playing with a large enrichment ball in his enclosure"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuDhOo2vgmSKCtghxbM1wkQ836nE_VEodYny-oa3mt9ZCr-0eM6M4sq0FRahDpRHnj-663RckkSIEWmDrLBVhgTT-38j9Dl-pndbzUKChybETsjfYriuOLvudOlLNhMpWZyW1fXrvEJYGGuQgYMfU6k14CK40NjAIgHtvKc91yE9QaONWfrWMuD1tWn_tRl9k5eUsOGCkzggGNY--rMGijQLb0Hh6uH7IUKmHLdv8l6Rww0dG6FM3yduMA77Kdcemn28laAts06ZMO3w" />
                    </div>
                </div>
            </div>
        </section>
        <!-- CAN 2025 Promo / CTA -->
        <section class="py-24 bg-primary text-[#1b140d] relative overflow-hidden">
            <!-- Decorative Pattern -->
            <div class="absolute inset-0 opacity-10"
                style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23000000\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
            </div>
            <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
                <div class="inline-block p-3 bg-white/20 backdrop-blur-sm rounded-full mb-6">
                    <span class="material-symbols-outlined text-white text-4xl filled-icon">sports_soccer</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-black mb-6 text-white tracking-tight">Supportez les Lions de
                    l'Atlas !</h2>
                <p class="text-xl md:text-2xl font-medium mb-10 text-white/90 max-w-2xl mx-auto">
                    Pour chaque billet acheté durant la CAN 2025, 5% sont reversés au programme de conservation des
                    félins au Maroc.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <button
                        class="bg-white text-primary text-lg font-bold py-4 px-8 rounded-xl shadow-xl hover:bg-gray-100 transition-colors flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">confirmation_number</span>
                        Réserver ma visite
                    </button>
                    <button
                        class="bg-transparent border-2 border-white text-white text-lg font-bold py-4 px-8 rounded-xl hover:bg-white/10 transition-colors flex items-center justify-center gap-2">
                        En savoir plus sur la conservation
                    </button>
                </div>
            </div>
        </section>
    </main>
    <footer class="bg-background-dark text-white py-16">
        <div class="max-w-[1440px] mx-auto px-4 md:px-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 border-b border-white/10 pb-12 mb-12">
                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center gap-2 mb-6">
                        <span class="material-symbols-outlined text-primary text-3xl filled-icon">pets</span>
                        <h2 class="text-xl font-bold">Zoo Virtuel ASSAD</h2>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Une expérience immersive au cœur de la faune sauvage. Partenaire officiel de la conservation
                        animale au Maroc.
                    </p>
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-6">Explorer</h3>
                    <ul class="flex flex-col gap-3 text-gray-400 text-sm">
                        <li><a class="hover:text-primary transition-colors" href="#">Tous les animaux</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">Carte interactive</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">Webcams Live</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">Événements CAN 2025</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-6">Infos Pratiques</h3>
                    <ul class="flex flex-col gap-3 text-gray-400 text-sm">
                        <li><a class="hover:text-primary transition-colors" href="#">Horaires &amp; Tarifs</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">Comment venir</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">Restauration</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-6">Newsletter</h3>
                    <div class="flex gap-2">
                        <input
                            class="bg-white/5 border border-white/10 rounded-lg px-4 py-2 text-sm text-white w-full focus:border-primary focus:ring-0"
                            placeholder="Votre email" type="email" />
                        <button class="bg-primary p-2 rounded-lg hover:bg-primary/90 transition-colors">
                            <span class="material-symbols-outlined text-white text-xl">send</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-gray-500">
                <p>© 2024 Zoo Virtuel ASSAD. Tous droits réservés.</p>
                <div class="flex gap-6">
                    <a class="hover:text-white transition-colors" href="#">Mentions légales</a>
                    <a class="hover:text-white transition-colors" href="#">Confidentialité</a>
                    <a class="hover:text-white transition-colors" href="#">Cookies</a>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>