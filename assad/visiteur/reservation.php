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



        $sql = " select * from  utilisateurs where role='guide' ";
        $resultat = $conn->query($sql);

        $array_guides = array();
        while ($ligne =  $resultat->fetch_assoc())
            array_push($array_guides, $ligne);

        $sql = "SELECT * FROM visitesguidees  WHERE 1=1";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {



            // filter par date_filter
            if (!empty($_POST['date_filter'])) {
                $sql .= " AND dateheure_viste <= " . $_POST['date_filter'];
            }

            // Filtre par typr guide_filter
            if (!empty($_POST['guide_filter'])) {
                $sql .= " AND id_guide = '" . $_POST['guide_filter'] . "'";
            }
        }

        try {
            $resultat = $conn->query($sql);
            $array_visites = array();
            while ($ligne =  $resultat->fetch_assoc())
                array_push($array_visites, $ligne);
        } catch (Exception $e) {

            error_log(date('Y-m-d H:i:s') . " - Erreur Recherche visite : " . $e->getMessage() . PHP_EOL, 3, "../error.log");
            $array_visites = array();
            while ($ligne =  $resultat->fetch_assoc())
                array_push($array_visites, $ligne);
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
     <title>Réservation Visites - Zoo Virtuel ASSAD</title>
     <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
     <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap"
         rel="stylesheet" />
     <link
         href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
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
                         <a class="text-[#1b140d] text-sm font-medium hover:text-primary transition-colors"
                             href="animaux.php">Animaux</a>
                         <a class="text-primary text-sm font-bold hover:text-primary transition-colors"
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

     <main class="flex-grow flex flex-col items-center py-10">
         <div class="w-full max-w-[1200px] mx-auto px-4 md:px-10">

             <div class="w-full mb-10">
                 <div
                     class="rounded-xl overflow-hidden relative min-h-[250px] flex flex-col justify-center items-center text-center p-8 bg-cover bg-center shadow-xl shadow-primary/10 bg-green-900/90">
                     <span
                         class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/20 backdrop-blur-sm border border-white/30 text-white text-sm font-bold uppercase tracking-wider mb-4">
                         <span class="material-symbols-outlined text-base">live_tv</span>
                         Immersion garantie
                     </span>
                     <h1
                         class="text-white text-4xl md:text-5xl font-black leading-tight tracking-tight mb-4 max-w-3xl drop-shadow-lg">
                         Réservez Votre Visite Guidée Virtuelle
                     </h1>
                     <p class="text-white/90 text-base md:text-lg font-medium max-w-2xl drop-shadow-md">
                         Rencontrez nos guides experts et explorez la faune comme jamais auparavant, en temps réel.
                     </p>
                 </div>
             </div>

             <section id="reservations" class="mb-16">
                 <h2 class="text-3xl font-extrabold text-[#1b140d] mb-8 text-center border-b border-primary/20 pb-4">Sessions Disponibles</h2>

                 <form method="POST" action="" class="flex flex-col md:flex-row justify-between items-center gap-4 p-4 bg-white rounded-xl shadow-lg border border-[#f3ede7] mb-8">
                     <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 w-full">
                         <div class="relative">
                             <input type="date" name="date_filter" value="<?= $_POST['date_filter'] ?? date('Y-m-d') ?>"
                                 class="px-4 py-2 border border-gray-200 rounded-lg bg-white text-sm focus:ring-primary w-full" />
                         </div>

                         <select name="guide_filter" class="px-4 py-2 border border-gray-200 rounded-lg bg-white text-sm focus:ring-primary w-full">
                             <option value="">Tous les Guides</option>
                             <?php foreach ($array_guides as $guide): ?>
                                 <option value="<?= $guide["id_utilisateur"] ?>" <?= (isset($_POST['guide_filter']) && $_POST['guide_filter'] == $guide["id_utilisateur"]) ? 'selected' : '' ?>>
                                     <?= ($guide["nom_utilisateur"]) ?>
                                 </option>
                             <?php endforeach; ?>
                         </select>

                         <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg font-bold hover:bg-orange-600 transition-colors flex items-center justify-center gap-2">
                             <span class="material-symbols-outlined">filter_list</span>
                             Filtrer
                         </button>
                     </div>
                 </form>
                 <div class="space-y-6">
                     <?php foreach ($array_visites as $visit) :

                            $date_visite = strtotime($visit['dateheure_viste']);
                            $maintenant = time();
                            $is_full = 11 <= 0;
                        ?>
                         <div class="flex flex-col sm:flex-row gap-4 p-4 rounded-2xl bg-white dark:bg-zinc-800 border border-[#f3ede7] dark:border-zinc-700 shadow-md hover:shadow-lg transition-shadow duration-300 <?= $is_full ? 'opacity-75' : '' ?>">

                             <div class="h-48 sm:h-auto sm:w-48 rounded-xl bg-cover bg-center shrink-0 relative bg-gray-200"
                                 style="background-image: url('../assets/img/habitats/<?= $visit['id_habitat'] ?? 'default' ?>.jpg');">

                                 <?php if ($date_visite <= $maintenant && $date_visite > ($maintenant - 3600)) : ?>
                                     <div class="m-2 absolute top-0 left-0 inline-flex px-2 py-1 bg-green-500/90 backdrop-blur-sm text-white text-xs font-bold rounded-lg items-center gap-1">
                                         <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                                         En direct
                                     </div>
                                 <?php elseif ($date_visite > $maintenant) : ?>
                                     <div class="m-2 absolute top-0 left-0 inline-flex px-2 py-1 bg-blue-600/90 backdrop-blur-sm text-white text-xs font-bold rounded-lg items-center gap-1">
                                         <span class="material-symbols-outlined text-[14px] leading-none">schedule</span>
                                         Programmé
                                     </div>
                                 <?php else : ?>
                                     <div class="m-2 absolute top-0 left-0 inline-flex px-2 py-1 bg-gray-500/90 backdrop-blur-sm text-white text-xs font-bold rounded-lg items-center gap-1">
                                         Terminé
                                     </div>
                                 <?php endif; ?>
                             </div>

                             <div class="flex flex-col justify-between flex-1 gap-4">
                                 <div>
                                     <h4 class="text-xl font-bold mb-1 hover:text-primary transition-colors cursor-pointer text-[#1b140d] dark:text-white">
                                         <?= ($visit['titre_visite']) ?>
                                     </h4>
                                     <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2 mb-2">
                                         <?= ($visit['description_visite']) ?>.

                                     </p>

                                     <div class="flex flex-wrap items-center gap-4 mt-2 text-sm text-gray-500">
                                         <div class="flex items-center gap-1">
                                             <span class="material-symbols-outlined text-primary text-[18px]">calendar_month</span>
                                             <span><?= date('d M Y, H:i', $date_visite) ?></span>
                                         </div>
                                         <div class="flex items-center gap-1">
                                             <span class="material-symbols-outlined text-primary text-[18px]">group</span>
                                             <span><?= $is_full ? 'Complet' : $visit["capacite_max__visite"] . ' places dispo.' ?></span>
                                         </div>
                                         <div class="flex items-center gap-1">
                                             <span class="material-symbols-outlined text-primary text-[18px]">payments</span>
                                             <span class="font-bold text-green-600"><?= ($visit['prix__visite']) ?>€</span>
                                         </div>
                                     </div>
                                 </div>

                                 <div class="flex flex-wrap gap-3 mt-auto pt-2 border-t border-gray-100 dark:border-zinc-700">
                                     <a href="visite_details.php?id=<?= $visit['id_visite'] ?>" class="flex items-center gap-2 px-4 py-2 rounded-lg bg-primary text-white text-sm font-semibold hover:bg-primary/90 transition-colors">
                                         <span class="material-symbols-outlined text-[18px]">visibility</span>
                                         Détails
                                     </a>

                                     <?php if (!$is_full) : ?>

                                         <form action="php/traiter_reservation.php" method="POST" class="reservation-form">
                                             <input type="hidden" name="id_visite" value="<?= $visit['id_visite'] ?>">
                                             <input type="hidden" name="id_utilisateur" value="<?= $_SESSION['id_utilisateur'] ?>">

                                             <div class="flex items-center gap-2">
                                                 <input type="number" name="nb_personnes" min="1" max="10" value="1"
                                                     class="w-16 px-2 py-2 border border-gray-200 rounded-lg text-sm" required>

                                                 <button type="submit" class="flex items-center gap-2 px-4 py-2 rounded-lg border border-primary text-primary text-sm font-semibold hover:bg-primary/10 transition-colors">
                                                     <span class="material-symbols-outlined text-[18px]">confirmation_number</span>
                                                     Réserver
                                                 </button>
                                             </div>
                                         </form>
                                     <?php endif; ?>


                                 </div>
                             </div>
                         </div>
                     <?php endforeach; ?>

                     <?php if (empty($array_visites)): ?>
                         <div class="p-10 text-center bg-white rounded-2xl shadow-sm border border-dashed border-gray-300">
                             <span class="material-symbols-outlined text-5xl text-gray-300 mb-2">search_off</span>
                             <p class="text-gray-500 text-lg">Aucune visite disponible pour le moment.</p>
                         </div>
                     <?php endif; ?>
                 </div>

             </section>
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