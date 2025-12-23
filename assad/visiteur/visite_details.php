 <?php

    $image = "https://lh3.googleusercontent.com/aida-public/AB6AXuBB3mzttMFekKaHiUMQgz9CbcCvR-LHMfkNamiYLEoaa6mr4VX3RGazcvrLyN6USTeeR3THkb5RzRgunm2nxYGRlj0JP37XKsb0oTpMuUfgiqYzKIQpDFu5Cwamtq0rGjsH93RIdsA6guKSg4KakhrlAV6mKU_SZGX00TM6y3-uGVugQHONmrBvFsVLmZ73htnyBEHRcaZXZ-cwzOoPb7aiKe-dIsmCV4By1n5q6PJKo8CSmh3GTGb2hDjnxSb8_vhCsJz-sArwzoL6";

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
        $tour_id = $_GET['id'];

        $sql = " select * from  visitesguidees  inner join  utilisateurs  on id_utilisateur =  id_guide and id_visite = $tour_id";
        $resultat = $conn->query($sql);

        $tour = array();
        if ($resultat->num_rows == 1) {
            $tour = $resultat->fetch_assoc();
            $sql = " select * from  visitesguidees v inner join  etapesvisite e on v.id_visite= e.id_visite   and v.id_visite = $tour_id";
            $resultat = $conn->query($sql);
            $array_etapes = array();
            while ($ligne =  $resultat->fetch_assoc())
                array_push($array_etapes, $ligne);

            $sql = " select sum(r.nb_personnes) as nb_participants from  visitesguidees v inner join  reservations r   on r.id_visite= v.id_visite
                    inner join  utilisateurs u   on u.id_utilisateur= v.id_guide where  v.id_visite = $tour_id  ";
            $resultat = $conn->query($sql);
            $nb_participants = $resultat->fetch_assoc()["nb_participants"];
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
     <title>Détails : <?= ($tour['title']) ?> - ASSAD</title>
     <link href="https://fonts.googleapis.com" rel="preconnect" />
     <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
     <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap" rel="stylesheet" />
     <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
     <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
     <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
     <script id="tailwind-config">
         tailwind.config = {
             darkMode: "class",
             theme: {
                 extend: {
                     colors: {
                         "primary": "#ec7f13",
                         "background-light": "#fcfaf8",
                         "background-dark": "#221910",
                         "surface-light": "#ffffff",
                         "surface-dark": "#2d241b",
                         "text-main-light": "#1b140d",
                         "text-main-dark": "#fcfaf8",
                         "text-sec-light": "#9a734c",
                         "text-sec-dark": "#d0bba6",
                         "border-light": "#e7dbcf",
                         "border-dark": "#4a3b2f",
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
             font-variation-settings:
                 'FILL' 1,
                 'wght' 400,
                 'GRAD' 0,
                 'opsz' 24
         }

         body {
             font-family: "Plus Jakarta Sans", sans-serif;
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
     <div class="flex h-screen w-full overflow-hidden">

         <main class="flex-1 flex flex-col h-full overflow-y-auto overflow-x-hidden">
             <div class="lg:hidden flex items-center justify-between p-4 border-b border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark sticky top-0 z-20">
                 <span class="material-symbols-outlined text-primary">pets</span>
                 <span class="material-symbols-outlined text-text-main-light dark:text-text-main-dark">menu</span>
             </div>

             <div class="p-6 md:p-10 max-w-7xl mx-auto w-full flex flex-col gap-8">
                 <a href="./reservation.php" class="text-sm text-text-sec-light dark:text-text-sec-dark hover:text-primary transition-colors flex items-center gap-1">
                     <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                     Retour à les Visites
                 </a>

                 <div class="flex flex-wrap justify-between items-start gap-4 pb-4 border-b border-border-light dark:border-border-dark">
                     <div class="flex flex-col gap-1">
                         <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight"><?= ($tour['titre_visite']) ?></h2>
                         <p class="text-text-sec-light dark:text-text-sec-dark text-lg">Détails de Visite #<?= $tour_id ?></p>
                     </div>


                 </div>

                 <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                     <div class="lg:col-span-1 flex flex-col gap-6">
                         <?php
                            $date_visite = strtotime($visit['dateheure_viste']?? time());
                            $maintenant = time();
                            $is_full = 11 <= 0;
                            ?>
                         <div class="h-60 rounded-xl bg-cover bg-center relative shadow-lg border border-border-light dark:border-border-dark" style='background-image: url("<?= $image ?>");'>
                             <div class="m-3 absolute top-0 left-0 inline-flex px-3 py-1  backdrop-blur-sm text-white text-sm font-bold rounded-lg items-center gap-1">
                                 <span class="material-symbols-outlined text-[14px] leading-none">schedule</span>
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

                             </div>
                         </div>

                         <div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-border-light dark:border-border-dark shadow-sm p-5 flex flex-col gap-4">
                             <h3 class="text-xl font-bold flex items-center gap-2 text-primary">
                                 <span class="material-symbols-outlined">info</span>
                                 Informations Clés
                             </h3>
                             <ul class="space-y-3 text-sm">
                                 <li class="flex justify-between items-center pb-1 border-b border-border-light dark:border-border-dark/50">
                                     <span class="text-text-sec-light dark:text-text-sec-dark font-medium">Date & Heure :</span>
                                     <span class="font-semibold"><?= (new DateTime($tour['dateheure_viste']))->format('d M Y') ?> à <?= (new DateTime($tour['dateheure_viste']))->format('h:m ')  ?></span>
                                 </li>
                                 <li class="flex justify-between items-center pb-1 border-b border-border-light dark:border-border-dark/50">
                                     <span class="text-text-sec-light dark:text-text-sec-dark font-medium">Durée Estimée :</span>
                                     <span class="font-semibold"><?= $tour['duree__visite'] ?></span>
                                 </li>
                                 <li class="flex justify-between items-center pb-1 border-b border-border-light dark:border-border-dark/50">
                                     <span class="text-text-sec-light dark:text-text-sec-dark font-medium">langue :</span>
                                     <span class="font-semibold text-primary"><?= $tour['langue__visite'] ?></span>
                                 </li>
                                 <li class="flex justify-between items-center pb-1">
                                     <span class="text-text-sec-light dark:text-text-sec-dark font-medium">Guide Assigné :</span>
                                     <span class="font-semibold"><?= $tour['nom_utilisateur'] ?></span>
                                 </li>
                             </ul>
                         </div>

                         <div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-border-light dark:border-border-dark shadow-sm p-5">
                             <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                                 <span class="material-symbols-outlined text-primary">description</span>
                                 Description
                             </h3>
                             <p class="text-sm text-text-main-light/90 dark:text-text-main-dark/90"><?= (($tour['description_visite'])) ?></p>
                         </div>
                     </div>

                     <div class="lg:col-span-2 flex flex-col gap-6">

                         <div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-border-light dark:border-border-dark shadow-sm p-5">
                             <h3 class="text-xl font-bold mb-3 flex items-center gap-2 text-green-600">
                                 <span class="material-symbols-outlined">group</span>
                                 Résumé des Réservations
                             </h3>
                             <div class="grid grid-cols-3 gap-4 text-center border-t border-border-light dark:border-border-dark/50 pt-3">
                                 <div class="p-2 border-r border-border-light dark:border-border-dark/50">
                                     <p class="text-3xl font-extrabold text-text-main-light dark:text-text-main-dark"><?= $tour['capacite_max__visite'] ?></p>
                                     <p class="text-sm text-text-sec-light dark:text-text-sec-dark">Places Total</p>
                                 </div>
                                 <div class="p-2 border-r border-border-light dark:border-border-dark/50">
                                     <p class="text-3xl font-extrabold text-blue-600"><?= $nb_participants ?></p>
                                     <p class="text-sm text-text-sec-light dark:text-text-sec-dark">Réservations Confirmées</p>
                                 </div>
                                 <div class="p-2">
                                     <p class="text-3xl font-extrabold   dark:text-text-main-dark   text-green-600"><?= $tour['capacite_max__visite'] - $nb_participants ?></p>
                                     <p class="text-sm text-text-sec-light dark:text-text-sec-dark">Places Restantes</p>
                                 </div>
                             </div>
                         </div>

                         <div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-border-light dark:border-border-dark shadow-sm overflow-x-auto">
                             <div class="p-5 border-b border-border-light dark:border-border-dark">
                                 <h3 class="text-xl font-bold flex items-center gap-2">
                                     <span class="material-symbols-outlined text-primary">list_alt</span>
                                     les etape de visite
                                 </h3>
                             </div>
                             <table class="min-w-full divide-y divide-border-light dark:divide-border-dark">
                                 <thead class="bg-gray-50/50 dark:bg-white/5">
                                     <tr>
                                         <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-text-sec-light dark:text-text-sec-dark uppercase tracking-wider">
                                             Titre d'Etape
                                         </th>
                                         <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-text-sec-light dark:text-text-sec-dark uppercase tracking-wider">
                                             Description d'Etape
                                         </th>

                                         <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-text-sec-light dark:text-text-sec-dark uppercase tracking-wider">
                                             order
                                         </th>
                                     </tr>
                                 </thead>
                                 <tbody class="divide-y divide-border-light dark:divide-border-dark">
                                     <?php foreach ($array_etapes as $etape) : ?>
                                         <tr class="hover:bg-background-light dark:hover:bg-white/5 transition-colors">
                                             <td class="px-6 py-4 whitespace-nowrap">
                                                 <div class="text-sm font-medium text-text-main-light dark:text-text-main-dark"><?= ($etape['titre_etape']) ?></div>
                                                 <div class="text-xs text-text-sec-light dark:text-text-sec-dark truncate"><?= ($etape['description_etape']) ?></div>
                                             </td>
                                             <td class="px-6 py-4 whitespace-nowrap text-center">
                                                 <span class="text-sm font-bold"><?= ($etape['description_etape']) ?></span>
                                             </td>

                                             <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                 <div class="flex justify-end gap-2">

                                                     <button title="Envoyer un rappel" class="text-blue-600 hover:text-blue-700 transition-colors p-1 rounded-full">
                                                         <span class="text-3xl font-extrabold text-blue-600"> <?= $etape['ordre_etape'] ?></span>
                                                     </button>
                                                 </div>
                                             </td>
                                         </tr>
                                     <?php endforeach; ?>
                                 </tbody>
                             </table>

                             <?php if (empty($array_etapes)): ?>
                                 <div class="p-6 text-center text-text-sec-light dark:text-text-sec-dark text-sm">
                                     Aucun étapes pour cette visite pour l'instant.
                                 </div>
                             <?php endif; ?>

                             <div class="p-4 border-t border-border-light dark:border-border-dark/50 text-right">
                                 <a href="reservations.php?tour_id=<?= $tour_id ?>" class="text-sm text-primary font-semibold hover:underline">
                                     Gérer toutes les réservations
                                     <span class="material-symbols-outlined text-[16px] align-middle ml-1">arrow_forward</span>
                                 </a>
                             </div>
                         </div>
                     </div>
                 </div>


             </div>
         </main>
     </div>

     <!-- <script>
         document.getElementById('copy-link-btn').addEventListener('click', function() {
             const link = this.getAttribute('data-link');
             navigator.clipboard.writeText(link).then(() => {
                 alert('Lien copié dans le presse-papiers !');
                 // Optionnellement, changer le texte du bouton brièvement
                 this.innerHTML = '<span class="material-symbols-outlined text-[20px]">check</span> Copié !';
                 setTimeout(() => {
                     this.innerHTML = '<span class="material-symbols-outlined text-[20px]">content_copy</span> Copier le Lien';
                 }, 1500);
             }).catch(err => {
                 console.error('Erreur lors de la copie: ', err);
             });
         });
     </script> -->
 </body>

 </html>