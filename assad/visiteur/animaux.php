 <?php
    session_start();

    include "../db_connect.php";

    if (
        isset($_SESSION['role_utilisateur'], $_SESSION['logged_in'], $_SESSION['id_utilisateur']) &&
        $_SESSION['role_utilisateur'] === "visiteur" &&
        $_SESSION['logged_in'] === TRUE
    ) {


        $id_utilisateur = ($_SESSION['id_utilisateur']);
        $nom_utilisateur = ($_SESSION['nom_utilisateur']);
        $role_utilisateur = ($_SESSION['role_utilisateur']);

        $sql = " select * from  habitats ";
        $resultat = $conn->query($sql);

        $array_habitats = array();
        while ($ligne =  $resultat->fetch_assoc())
            array_push($array_habitats, $ligne);

        $array_animaux = array();

        $sql = "SELECT a.*, h.nom_habitat 
        FROM animaux a 
        JOIN habitats h ON a.id_habitat = h.id_habitat 
        WHERE 1=1 ";


        $numAnimaux = 5;
        if ($_SERVER['REQUEST_METHOD'] === 'POST' and isset($_POST["chargerplus"])) {
            if (!empty($_POST["chargerplus"])) {
                $numAnimaux += $_POST["chargerplus"];
                $sql .= " limit 5 OFFSET  $numAnimaux";
            }
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!empty($_POST['search'])) {
                $sql .= " AND a.nom_animal LIKE '" . $_POST['search'] . "%'";
            }

            if (!empty($_POST['id_habitat'])) {
                $sql .= " AND a.id_habitat = " . $_POST['id_habitat'];
            }

            if (!empty($_POST['alimentation_animal'])) {
                $sql .= " AND a.alimentation_animal = '" . $_POST['alimentation_animal'] . "'";
            }
        } else  $sql .= " limit 5 ";


        try {
            $resultat = $conn->query($sql);
            while ($ligne =  $resultat->fetch_assoc())
                array_push($array_animaux, $ligne);
        } catch (Exception $e) {
            error_log(date('Y-m-d H:i:s') . " - Erreur Recherche Animaux -: " . $e->getMessage() . PHP_EOL, 3, "../error.log");
        }
    } else {
        header("Location: ../connexion.php?error=access_denied");
        exit();
    }



    ?>






 <!DOCTYPE html>

 <html class="light" lang="fr">

 <head>
     <meta charset="utf-8" />
     <meta content="width=device-width, initial-scale=1.0" name="viewport" />
     <title>Liste des Animaux - Zoo Virtuel ASSAD</title>
     <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
     <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&amp;display=swap" rel="stylesheet" />
     <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
     <script id="tailwind-config">
         tailwind.config = {
             darkMode: "class",
             theme: {
                 extend: {
                     colors: {
                         "primary": "#ec7f13",
                         "background-light": "#f8f7f6",
                         "background-dark": "#221910",
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
         /* Style pour Badge de Statut */
         .status-badge-critical {
             background-color: #fef2f2;
             color: #ef4444;
             border: 1px solid #fecaca;
         }

         .status-badge-danger {
             background-color: #fefce8;
             color: #eab308;
             border: 1px solid #fde047;
         }

         .status-badge-vulnerable {
             background-color: #fffbeb;
             color: #f59e0b;
             border: 1px solid #fcd34d;
         }

         .status-badge-minor {
             background-color: #f0fdf4;
             color: #10b981;
             border: 1px solid #a7f3d0;
         }

         .material-symbols-outlined {
             font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
         }

         .scrollbar-hide::-webkit-scrollbar {
             display: none;
         }

         .scrollbar-hide {
             -ms-overflow-style: none;
             scrollbar-width: none;
         }
     </style>
 </head>

 <body class="bg-background-light dark:bg-background-dark text-[#1b140d] font-display min-h-screen flex flex-col">
     <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-[#f3ede7]">
         <div class="max-w-[1200px] mx-auto px-4 md:px-10 py-3">
             <div class="flex items-center justify-between whitespace-nowrap">
                 <div class="flex items-center gap-4">
                     <div class="text-primary">
                         <span class="material-symbols-outlined text-4xl">pets</span>
                     </div>
                     <h2 class="text-[#1b140d] text-lg font-bold leading-tight tracking-[-0.015em]">Zoo Virtuel ASSAD
                     </h2>
                 </div>
                 <div class="hidden lg:flex flex-1 justify-end gap-8">
                     <div class="flex items-center gap-9">
                         <a class="text-[#1b140d] text-sm font-medium hover:text-primary transition-colors"
                             href="index.php">Accueil</a>
                         <a class="text-primary text-sm font-bold hover:text-primary transition-colors"
                             href="animaux.php">Animaux</a>
                         <a class="text-[#1b140d] text-sm font-medium hover:text-primary transition-colors"
                             href="reservation.php">Réservation</a>
                         <a class="text-[#1b140d] text-sm font-medium hover:text-primary transition-colors"
                             href="./mes_reservations.php">Mes Reservations</a>
                         <a class="text-[#1b140d] text-sm font-medium hover:text-primary transition-colors"
                             href="./../php/sedeconnecter.php"> Se Deconnecter</a>
                     </div>

                 </div>
                 <button class="lg:hidden text-[#1b140d]">
                     <span class="material-symbols-outlined">menu</span>
                 </button>
             </div>
         </div>
     </header>

     <main class="flex-grow flex flex-col items-center">
         <!-- <div class="w-full max-w-[1200px] px-4 md:px-10 py-6">
             <div
                 class="rounded-xl overflow-hidden relative min-h-[250px] flex flex-col justify-center items-center text-center p-8 bg-cover bg-center shadow-xl shadow-primary/10"
                 style='background-image: linear-gradient(rgba(0, 0, 0, 0.4) 0%, rgba(0, 0, 0, 0.7) 100%), url("https://lh3.googleusercontent.com/aida-public/AB6AXuB7tV0MbXCZTrttbfuFt8CqKgYEiMryvuxkVWJ6WjvseE_KC2bRS8wOCXpRA4lgDfHgikgjgeCdHsMWdoTr4UFYTYVRoaXexOq-BoOXf5Yo4UcENg5bt1enOCEyrAifv40q_DFANZ1CKEoehRrYDWpLP4S40C7IO1NzrxJat8xe6LbEld6MWZxqsFZoxikvEa865GjFKpz8yY8X5kFjlAlJsm2eNUry4Us0zUZHNEz_wQNZStdhBmsEhv7mpEWzSrjunYXj4bxh4v0h");'>
                 <h1
                     class="text-white text-4xl md:text-5xl font-black leading-tight tracking-tight mb-4 max-w-3xl drop-shadow-lg">
                     Découvrez tous nos Résidents Étoiles
                 </h1>
                 <p class="text-white/90 text-base md:text-lg font-medium max-w-2xl drop-shadow-md mb-8">
                     Explorez notre collection complète d'animaux, classés par habitat et statut de conservation.
                 </p>
             </div>
         </div> -->

         <form action="" method="POST" class="w-full max-w-[1200px] px-4 md:px-10 sticky top-[65px] z-40">
             <div class="bg-white/80 backdrop-blur-xl shadow-sm border border-[#f3ede7] rounded-xl p-4 mb-8">
                 <div class="flex flex-col md:flex-row gap-4 justify-between items-center">
                     <div class="w-full md:w-1/3 relative group">
                         <button class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                             <span class="material-symbols-outlined text-gray-400 group-focus-within:text-primary transition-colors">search</span>
                         </button>
                         <input name="search"
                             class="w-full pl-10 pr-4 py-2.5 bg-[#f8f7f6] border-none rounded-lg text-sm text-[#1b140d] placeholder-gray-500 focus:ring-2 focus:ring-primary focus:bg-white transition-all"
                             placeholder="Rechercher (ex: Lion, Éléphant...)" type="text" />
                     </div>
                     <div class="flex gap-4 overflow-x-auto pb-2 md:pb-0 w-full md:w-2/3 scrollbar-hide">
                         <select name="id_habitat"
                             class="px-4 py-2 bg-white border border-[#e5e5e5] hover:border-primary/50 hover:bg-primary/5 text-[#1b140d] rounded-lg text-sm font-medium whitespace-nowrap transition-all focus:ring-primary focus:border-primary w-full sm:w-1/2">
                             <option value="">Filtrer par Habitat</option>
                             <?php foreach ($array_habitats as $habitat) : ?>
                                 <option value="<?= ($habitat["id_habitat"]) ?>"><?= ($habitat["nom_habitat"]) ?></option>
                             <?php endforeach; ?>
                         </select>
                         <select name="alimentation_animal"
                             class="px-4 py-2 bg-white border border-[#e5e5e5] hover:border-primary/50 hover:bg-primary/5 text-[#1b140d] rounded-lg text-sm font-medium whitespace-nowrap transition-all focus:ring-primary focus:border-primary w-full sm:w-1/2">
                             <option value="" selected>Tout Type Alimentaire</option>
                             <option value="Carnivore">Carnivore</option>
                             <option value="Herbivore">Herbivore</option>
                             <option value="Omnivore">Omnivore</option>
                         </select>
                     </div>
                 </div>
             </div>
         </form>

         <!-- <div class="w-full max-w-[1200px] px-4 md:px-10 mb-6 flex justify-between items-end">
             <div>
                 <h2 class="text-[#1b140d] text-2xl font-bold leading-tight">Liste des Animaux</h2>
                 <p class="text-gray-500 text-sm mt-1">Total: <?php count($array_animaux) ?> animaux répertoriés</p>
             </div>
         </div> -->

         <div class="w-full max-w-[1200px] px-4 md:px-10 pb-20">
             <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-6">

                 <?php foreach ($array_animaux as $index => $animal) : ?>
                     <?php
                        $status = $animal['alimentation_animal'];
                        $badge_class = '';
                        if (strtolower($status) === 'carnivore') {
                            $badge_class = 'status-badge-critical';
                        } elseif (strtolower($status) === 'herbivore') {
                            $badge_class = 'status-badge-danger';
                        } elseif (strtolower($status) === 'omnivore') {
                            $badge_class = 'status-badge-vulnerable';
                        }
                        ?>

                     <?php if (strtolower(trim($animal["espece"])) ==  trim(strtolower("Lion d'Atlas"))) :
                        ?>
                         <div class="group  relative flex flex-col bg-white rounded-2xl border-2 border-primary overflow-hidden hover:shadow-xl transition-all duration-300 col-span-1 sm:col-span-2 lg:col-span-2">
                             <div class="absolute top-4 left-4 z-10">
                                 <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-primary text-white text-xs font-bold shadow-lg">
                                     <span class="material-symbols-outlined text-[16px]">stars</span>
                                     <?= ($animal['alimentation_animal']) ?>
                                 </span>
                             </div>
                             <a href="animal_detail.php?id=<?= ($animal['id_animal']) ?>" class="h-64 md:h-full w-full overflow-hidden relative">
                                 <img alt="<?= ($animal['nom_animal']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="<?= ($animal['image_url']) ?>" />
                                 <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                                 <div class="absolute bottom-4 left-4 text-white">
                                     <h3 class="text-2xl font-bold"><?= ($animal['nom_animal']) ?></h3>
                                     <p class="text-white/80 text-sm"><?= ($animal['espece']) ?></p>
                                 </div>
                             </a>
                             <div class="p-4 flex justify-between items-center bg-primary/5 border-t border-primary/10">
                                 <div class="flex items-center gap-2 text-sm font-medium text-[#1b140d]">
                                     <span class="w-5 h-5 rounded-full overflow-hidden flex items-center justify-center bg-gray-200 text-xs">🇲🇦</span>
                                     <?= ($animal['pays_origine']) ?>
                                 </div>
                                 <a href="animal_detail.php?id=<?= ($animal['id_animal']) ?>" class="text-primary text-sm font-bold flex items-center gap-1 group-hover:gap-2 transition-all">
                                     En savoir plus
                                     <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                                 </a>
                             </div>
                         </div>
                     <?php else : // Cartes régulières 
                        ?>
                         <div class="group flex flex-col bg-white rounded-2xl border border-[#f3ede7] overflow-hidden hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                             <a href="animal_detail.php?id=<?= ($animal['id_animal']) ?>" class="h-48 overflow-hidden relative">
                                 <img alt="<?= ($animal['nom_animal']) ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" src="<?= ($animal['image_url']) ?>" />

                             </a>
                             <div class="p-4 flex flex-col flex-grow">
                                 <div class="flex items-start justify-between mb-2">
                                     <div>
                                         <h3 class="text-lg font-bold text-[#1b140d]"><?= ($animal['nom_animal']) ?></h3>
                                         <p class="text-xs text-gray-500 italic"><?= ($animal['espece']) ?></p>
                                     </div>
                                 </div>
                                 <div class="flex flex-wrap gap-2 mt-2">
                                     <span class="inline-flex items-center px-2 py-1 rounded bg-[#f8f7f6] text-xs font-medium text-gray-600">
                                         <?= ($animal['nom_habitat']) ?>
                                     </span>
                                     <?php if ($badge_class): ?>
                                         <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium <?= $badge_class ?>">
                                             <?= ($animal['alimentation_animal']) ?>
                                         </span>
                                     <?php endif; ?>
                                 </div>
                                 <div class="mt-auto pt-4 flex items-center justify-between border-t border-gray-100">
                                     <div class="flex items-center gap-1.5 text-xs font-medium text-gray-600">
                                         <span class="material-symbols-outlined text-[16px] text-gray-400">location_on</span>
                                         <?= ($animal['pays_origine']) ?>
                                     </div>
                                     <a href="animal_detail.php?id=<?= ($animal['id_animal']) ?>" class="text-primary text-sm font-bold flex items-center gap-1 group-hover:gap-2 transition-all">
                                         Détails
                                         <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                                     </a>
                                 </div>
                             </div>
                         </div>
                     <?php endif; ?>
                 <?php endforeach; ?>
             </div>

             <?php
                if (count($array_animaux) == 5)
                    echo ' <div class="flex justify-center mt-12">
                        <form action="" method="POST">
                            <input type="hidden" value="' . $numAnimaux . '" name="chargerplus">
                            <button
                                class="flex items-center justify-center gap-2 px-6 py-3 border border-[#e5e5e5] hover:border-primary text-[#1b140d] hover:text-primary font-bold rounded-xl transition-all bg-white hover:bg-orange-50">
                                Charger plus d\'animaux
                                <span class="material-symbols-outlined">expand_more</span>
                            </button>
                        </form>
                    </div>';
                ?>
         </div>
     </main>

     <footer class="bg-[#1b140d] text-white pt-16 pb-8 mt-auto">
         <div class="max-w-[1200px] mx-auto px-4 md:px-10">
             <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                 <div class="col-span-1 md:col-span-1">
                     <div class="flex items-center gap-3 mb-6">
                         <div class="text-primary">
                             <span class="material-symbols-outlined text-4xl">pets</span>
                         </div>
                         <span class="font-bold text-xl">ASSAD Zoo</span>
                     </div>
                     <p class="text-gray-400 text-sm leading-relaxed mb-6">
                         Le premier zoo virtuel dédié à la faune africaine. Soutenez la conservation et célébrez la CAN 2025 avec nous.
                     </p>
                 </div>
                 <div>
                     <h4 class="font-bold mb-4 text-white">Explorer</h4>
                     <ul class="space-y-3 text-gray-400 text-sm">
                         <li><a class="hover:text-primary transition-colors" href="animaux.php">Nos Animaux</a></li>
                         <li><a class="hover:text-primary transition-colors" href="reservation.php">Réservation Visites</a></li>
                         <li><a class="hover:text-primary transition-colors" href="#">Programme Éducatif</a></li>
                     </ul>
                 </div>
                 <div>
                     <h4 class="font-bold mb-4 text-white">CAN 2025</h4>
                     <ul class="space-y-3 text-gray-400 text-sm">
                         <li><a class="hover:text-primary transition-colors" href="#">Billetterie</a></li>
                         <li><a class="hover:text-primary transition-colors" href="#">Fan Zone Virtuelle</a></li>
                         <li><a class="hover:text-primary transition-colors" href="#">Partenaires</a></li>
                     </ul>
                 </div>
                 <div>
                     <h4 class="font-bold mb-4 text-white">Newsletter</h4>
                     <p class="text-gray-400 text-sm mb-4">Restez informé des naissances et des matchs.</p>
                     <div class="flex gap-2">
                         <input
                             class="bg-white/10 border-none rounded-lg text-sm text-white px-3 py-2 w-full focus:ring-1 focus:ring-primary"
                             placeholder="Votre email" type="email" />
                         <button class="bg-primary hover:bg-orange-600 text-white rounded-lg px-3 py-2 transition-colors">
                             <span class="material-symbols-outlined text-sm">send</span>
                         </button>
                     </div>
                 </div>
             </div>
             <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                 <p class="text-gray-500 text-xs">© 2025 Zoo Virtuel ASSAD. Tous droits réservés.</p>
                 <div class="flex gap-6 text-gray-500 text-xs">
                     <a class="hover:text-white transition-colors" href="#">Confidentialité</a>
                     <a class="hover:text-white transition-colors" href="#">Conditions</a>
                     <a class="hover:text-white transition-colors" href="#">Cookies</a>
                 </div>
             </div>
         </div>
     </footer>
 </body>

 </html>