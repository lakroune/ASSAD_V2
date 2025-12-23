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

        $sql = " SELECT * FROM reservations r INNER JOIN visitesguidees v on r.id_visite = v.id_visite  and r.id_utilisateur= $id_utilisateur";
        $resultat = $conn->query($sql);

        $array_reservations = array();
        while ($ligne =  $resultat->fetch_assoc())
            array_push($array_reservations, $ligne);
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
     <title>Mes Réservations - Zoo Virtuel ASSAD</title>
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

         /* Styles pour les badges de statut */
         .status-confirmée {
             background-color: #d1fae5;
             color: #059669;
             border: 1px solid #6ee7b7;
         }

         .status-terminée {
             background-color: #f3f4f6;
             color: #6b7280;
             border: 1px solid #e5e7eb;
         }

         .status-annulée {
             background-color: #fee2e2;
             color: #dc2626;
             border: 1px solid #fca5a5;
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

     <main class="flex-grow flex flex-col items-center py-10">
         <div class="w-full max-w-[1200px] mx-auto px-4 md:px-10">

             <div class="w-full mb-10 text-center">
                 <div class="p-8 bg-white rounded-xl shadow-lg border border-[#f3ede7]">
                     <h1 class="text-4xl font-black text-[#1b140d] mb-2">
                         Vos Réservations, <span class="text-primary"><?= $nom_utilisateur ?></span>
                     </h1>
                     <p class="text-gray-500 text-lg">
                         Gérez vos visites guidées virtuelles passées et à venir.
                     </p>
                 </div>
             </div>



             <section id="user-reservations" class="mb-16">
                 <?php if (!empty($array_reservations)): ?>
                     <div class="bg-white shadow-xl rounded-xl overflow-hidden border border-[#f3ede7]">
                         <table class="min-w-full divide-y divide-gray-200">
                             <thead class="bg-[#f8f7f6]">
                                 <tr>
                                     <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Visite</th>
                                     <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Date & Heure</th>
                                     <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Guide</th>
                                     <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Invités</th>
                                         </tr>
                             </thead>
                             <tbody class="divide-y divide-gray-200">
                                 <?php foreach ($array_reservations as $reservation) : ?>
                                     <tr class="<?= $reservation['statut__visite'] ? 'bg-white hover:bg-orange-50/50' : 'bg-gray-50/50' ?> transition-colors">
                                         <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-[#1b140d]">
                                             <a href="reservation.php" class="hover:text-primary transition-colors">
                                                 <?= ($reservation['titre_visite']) ?>
                                             </a>
                                             <p class="text-xs text-gray-400">#<?= ($reservation['id_reservations']) ?></p>
                                         </td>
                                         <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                             <?= date('d/m/Y', strtotime($reservation['dateheure_viste'])) ?> à <?= date('H:m', strtotime($reservation['dateheure_viste'])) ?>
                                         </td>
                                         <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                             <?= ($reservation['id_guide']) ?>
                                         </td>
                                         <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                             <?= ($reservation['id_guide']) ?> personne(s)
                                         </td>
                                         
                                          
                                     </tr>
                                 <?php endforeach; ?>
                             </tbody>
                         </table>
                     </div>
                 <?php else: ?>
                     <div class="p-10 text-center bg-white rounded-xl shadow-lg border border-[#f3ede7]">
                         <span class="material-symbols-outlined text-6xl text-gray-300 mb-4">event_busy</span>
                         <p class="text-xl font-bold text-gray-600 mb-2">Vous n'avez aucune réservation pour le moment.</p>
                         <p class="text-gray-500 mb-6">Explorez nos sessions disponibles et réservez votre prochaine visite !</p>
                         <a href="reservation.php"
                             class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-primary hover:bg-orange-600 text-white font-bold rounded-xl transition-all shadow-lg shadow-orange-500/30">
                             <span class="material-symbols-outlined">confirmation_number</span>
                             Voir les visites
                         </a>
                     </div>
                 <?php endif; ?>
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