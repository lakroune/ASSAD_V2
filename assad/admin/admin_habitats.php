 <?php
    session_start();
    include "../db_connect.php";

    if (
        isset($_SESSION['role_utilisateur'], $_SESSION['logged_in'], $_SESSION['id_utilisateur'], $_SESSION['nom_utilisateur']) &&
        $_SESSION['role_utilisateur'] === "admin" &&
        $_SESSION['logged_in'] === TRUE
    ) {
        $id_utilisateur = ($_SESSION['id_utilisateur']);
        $nom_utilisateur = ($_SESSION['nom_utilisateur']);
        $role_utilisateur = ($_SESSION['role_utilisateur']);



        $sql = " SELECT  *  FROM habitats where nom_habitat like  ?";
        $searchInput = "%";
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['searchInput']))
            $searchInput =  ($_POST["searchInput"]) . "%";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $searchInput);
        $stmt->execute();
        $resultat = $stmt->get_result();
        $array_habitats = array();
        while ($ligne =  $resultat->fetch_assoc())
            array_push($array_habitats, $ligne);



        $info_habitat = null;
        $info = false;
        $edit = false;
        if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['id_habitat_info']) or isset($_POST['id_habitat_edit']))) {
            $id_h = null;
            if (!empty($_POST['id_habitat_info'])) {
                $info = true;
                $id_h = $_POST['id_habitat_info'];
            }
            if (!empty($_POST['id_habitat_edit'])) {
                $edit = true;
                $id_h = $_POST['id_habitat_edit'];
            }

            $sql_info = "SELECT * FROM habitats WHERE id_habitat = ?";
            $stmt = $conn->prepare($sql_info);
            $stmt->bind_param("i", $id_h);
            $stmt->execute();
            $res = $stmt->get_result();
            $info_habitat = $res->fetch_assoc();
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
     <title>Gestion des Habitats - ASSAD Admin</title>
     <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200..800&display=swap"
         rel="stylesheet" />
     <link
         href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
         rel="stylesheet" />
     <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
     <script id="tailwind-config">
         tailwind.config = {
             darkMode: "class",
             theme: {
                 extend: {
                     colors: {
                         "primary": "#ec7f13",
                         "primary-dark": "#d16a0a",
                         "background-light": "#f8f7f6",
                         "background-dark": "#221910",
                         "surface-light": "#ffffff",
                         "surface-dark": "#2d241b",
                         "text-light": "#1b140d",
                         "text-dark": "#f0e6dd",
                         "text-secondary-light": "#9a734c",
                         "text-secondary-dark": "#b08d6b",
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
 </head>

 <body
     class="bg-background-light dark:bg-background-dark text-text-light dark:text-text-dark font-display antialiased min-h-screen flex overflow-hidden">
     <aside
         class="w-64 bg-surface-light dark:bg-surface-dark border-r border-gray-200 dark:border-gray-800 flex-col hidden md:flex h-screen sticky top-0 shrink-0">
         <div class="h-full flex flex-col justify-between p-4">
             <div class="flex flex-col gap-6">
                 <div class="flex items-center gap-3 px-2">
                     <div class="bg-center bg-no-repeat bg-cover rounded-full h-10 w-10 shadow-sm border border-primary/20"
                         data-alt="Abstract logo representing a lion head in orange tones"
                         style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBLtzdITINYnoOVjCU_bzpU_9pRXby0heIBLEdVS8X21OrFNaKbkKt2QBzQT6g2TlgCLazrJMWR_qW34Zv6Tj7_7PjVBI6tVF7vpjpMqb3ILmEytcvS6tyde7BUh1040h1liUA00KJKxQNaIwONa2LqVBJOPB5zlfXQptiNh4jSMeomQTLUtiPoYhXr6RVNv8W6_zOXk9IIvkFT1OeYYZ7XHdx3p9BoVqOb5Ua6dpsaIgcEH3eNYsuOi7xYESV5EqCMwKZrZoa522Uy");'>
                     </div>
                     <div class="flex flex-col">
                         <h1 class="text-text-light dark:text-text-dark text-lg font-bold leading-tight">ASSAD Admin</h1>
                         <p class="text-primary text-xs font-semibold tracking-wider uppercase">Zoo Virtuel</p>
                     </div>
                 </div>
                 <nav class="flex flex-col gap-1">
                     <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-text-secondary-light dark:text-text-secondary-dark hover:bg-primary/10 hover:text-primary transition-colors group"
                         href="index.php">
                         <span class="material-symbols-outlined text-2xl group-hover:text-primary transition-colors">dashboard</span>
                         <span class="text-sm font-medium">Vue d'ensemble</span>
                     </a>
                     <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-text-secondary-light dark:text-text-secondary-dark hover:bg-primary/10 hover:text-primary transition-colors group"
                         href="admin_animaux.php">
                         <span
                             class="material-symbols-outlined text-2xl group-hover:text-primary transition-colors">pets</span>
                         <span class="text-sm font-medium">Gestion Animaux</span>
                     </a>
                     <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-primary text-white shadow-md shadow-primary/20"
                         href="admin_habitats.php">
                         <span
                             class="material-symbols-outlined text-2xl fill-current">nature</span>
                         <span class="text-sm font-medium">Habitats</span>
                     </a>

                     <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-text-secondary-light dark:text-text-secondary-dark hover:bg-primary/10 hover:text-primary transition-colors group"
                         href="admin_users.php">
                         <span
                             class="material-symbols-outlined text-2xl group-hover:text-primary transition-colors">group</span>
                         <span class="text-sm font-medium">Utilisateurs</span>
                     </a>

                 </nav>
             </div>
             <div class="border-t border-gray-200 dark:border-gray-800 pt-4 px-2">
                 <div class="flex items-center gap-3">
                     <div class="flex flex-col">
                         <a href="../php/sedeconnecter.php" class="text-xs text-text-secondary-light dark:text-text-secondary-dark">se deconnecter</a>
                     </div>
                 </div>
             </div>
         </div>
     </aside>
     <main class="flex-1 flex flex-col h-screen overflow-hidden relative">
         <header
             class="bg-surface-light dark:bg-surface-dark border-b border-gray-200 dark:border-gray-800 shrink-0 z-10">
             <div class="px-6 py-5 max-w-7xl mx-auto w-full">
                 <div class="flex flex-wrap justify-between items-end gap-4">
                     <div class="flex flex-col gap-1">
                         <h1 class="text-3xl font-black tracking-tight text-text-light dark:text-text-dark">Gestion des Habitats</h1>
                         <p
                             class="text-text-secondary-light dark:text-text-secondary-dark text-sm font-medium flex items-center gap-1">
                             Surveillance des zones virtuelles et de leur contenu
                         </p>
                     </div>
                     <div class="flex items-center gap-3">
                         <button onclick=" toggleModal('modalHabitat') ;"
                             class="flex items-center gap-2 px-4 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white shadow-lg shadow-green-600/30 transition-all text-sm font-bold">
                             <span class="material-symbols-outlined text-lg">add_location_alt</span>
                             Ajouter Nouvel Habitat
                         </button>
                     </div>
                 </div>
             </div>
         </header>
         <div class="flex-1 overflow-y-auto bg-background-light dark:bg-background-dark">
             <div class="max-w-7xl mx-auto w-full px-6 py -8 flex flex-col gap-8">

                 <div class="flex flex-col md:flex-row justify-between items-center gap-4 p-4 bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
                     <div class="flex flex-wrap gap-3">
                         <button class="px-4 py -2 text-sm font-bold rounded-lg bg-primary text-white shadow-sm">Tous (<?= count($array_habitats) ?>)</button>
                     </div>
                     <div class="relative w-full md:w-auto">
                         <form action="" method="POST">
                             <span
                                 class="material-symbols-outlined absolute left-2.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm">search</span>
                             <input name="searchInput"
                                 class="pl-8 pr-3 py-1.5 rounded-lg border-gray-200 dark:border-gray-700 bg-white dark:bg-surface-dark text-sm w-full md:w-64 focus:ring-primary/20 focus:border-primary"
                                 placeholder="Rechercher par nom..." type="text" />
                             <button></button>
                         </form>

                     </div>
                 </div>
                 <?php if (isset($_GET['status']) && $_GET['status'] === 'updated'): ?>
                     <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                         L'habitat a été mis à jour avec succès !
                     </div>
                 <?php endif; ?>
                 <?php if (isset($_GET['status']) && $_GET['status'] === 'delete'): ?>
                     <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                         L'habitat a été supprimer avec succès !
                     </div>
                 <?php endif; ?>
                 <?php if (isset($_GET['status']) && $_GET['status'] === 'added'): ?>
                     <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                         L'habitat a été ajouter avec succès !
                     </div>
                 <?php endif; ?>
                 <div id="card_habitas"
                     class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-xl border border-gray-100 dark:border-gray-800 overflow-hidden">
                     <div class="overflow-x-auto">

                         <table class="w-full text-left text-sm whitespace-nowrap">
                             <thead
                                 class="bg-gray-50/50 dark:bg-gray-800/30 border-b border-gray-100 dark:border-gray-800">
                                 <tr>
                                     <th
                                         class="px-6 py-3 font-semibold text-text-secondary-light dark:text-text-secondary-dark">
                                         Nom / ID</th>
                                     <th
                                         class="px-6 py-3 font-semibold text-text-secondary-light dark:text-text-secondary-dark">
                                         Type</th>
                                     <th
                                         class="px-6 py-3 text-start font-semibold text-text-secondary-light dark:text-text-secondary-dark text-center">
                                         Zone Zoo</th>


                                     <th
                                         class="px-6 py-3 text-center font-semibold text-text-secondary-light dark:text-text-secondary-dark text-right">
                                         Actions</th>
                                 </tr>
                             </thead>
                             <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                 <?php foreach ($array_habitats as $habitat) : ?>
                                     <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors group">
                                         <td class="px-6 py-3">
                                             <div class="flex items-center gap-3">
                                                 <span class="material-symbols-outlined text-2xl text-primary"><?php  ?></span>
                                                 <div class="flex flex-col">
                                                     <span class="font-bold text-text-light dark:text-text-dark"><?= ($habitat['nom_habitat']) ?></span>
                                                     <span class="text-xs text-text-secondary-light">ID: <?= ($habitat['id_habitat']) ?></span>
                                                 </div>
                                             </div>
                                         </td>
                                         <td class="px-6 py-3">
                                             <span class="text-text-light dark:text-text-dark font-medium"><?= ($habitat['type_climat']) ?></span>
                                         </td>
                                         <td class="px-6 py-3 text-start">
                                             <span class="font-bold text-sm text-primary"><?= ($habitat['zone_zoo']) ?></span>
                                         </td>


                                         <td class="px-6 py-3 text-right">
                                             <div
                                                 class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">


                                                 <form class="edit" action="" method="POST">
                                                     <input type="hidden" value="<?= $habitat['id_habitat'] ?>" name="id_habitat_edit">
                                                     <button
                                                         class="p-1.5 rounded hover:bg-gray-100 dark:hover:bg-gray-700 text-blue-500"
                                                         title="Éditer les détails">
                                                         <span class="material-symbols-outlined text-lg">edit</span>
                                                     </button>
                                                 </form>
                                                 <form class="info" action="" method="POST">
                                                     <input type="hidden" value="<?= $habitat['id_habitat'] ?>" name="id_habitat_info">
                                                     <button
                                                         class="p-1.5 rounded hover:bg-gray-100 dark:hover:bg-gray-700 text-primary"
                                                         title="Voir les animaux résidents">
                                                         <span class="material-symbols-outlined text-lg">pets</span>
                                                     </button>
                                                 </form>
                                                 <form class="delete" action="php/delete_habitat.php" method="POST">
                                                     <input type="hidden" value="<?= $habitat['id_habitat'] ?>" name="id_habitat">
                                                     <button
                                                         type="button"
                                                         class="p-1.5 rounded hover:bg-gray-100 dark:hover:bg-gray-700 text-red-500 btn-delete"
                                                         title="Supprimer">
                                                         <span class="material-symbols-outlined text-lg">delete</span>
                                                     </button>
                                                 </form>
                                             </div>
                                         </td>
                                     </tr>
                                 <?php endforeach; ?>
                             </tbody>
                         </table>
                         <?php if (empty($array_habitats)): ?>
                             <div class="p-6 text-center text-text-secondary-light dark:text-text-secondary-dark text-sm">
                                 Aucun habitat trouvé.
                             </div>
                         <?php endif; ?>
                     </div>
                 </div>
             </div>

         </div>
     </main>

     <!-- info habiata -->
     <?php if ($edit && $info_habitat): ?>
         <div id="modalEditHabitat" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
             <div class="bg-surface-light dark:bg-surface-dark w-full max-w-md p-6 rounded-xl shadow-2xl border border-blue-500/30">
                 <div class="flex justify-between items-center mb-6">
                     <h2 class="text-xl font-bold text-blue-600">Modifier l'Habitat</h2>
                     <button onclick="document.getElementById('modalEditHabitat').remove()" class="text-gray-500 hover:text-red-500">
                         <span class="material-symbols-outlined">close</span>
                     </button>
                 </div>

                 <form action="php/update_habitat.php" method="POST" class="flex flex-col gap-4">
                     <input type="hidden" name="id_habitat" value="<?= $info_habitat['id_habitat'] ?>">

                     <div>
                         <label class="block text-sm font-medium mb-1">Nom de l'habitat</label>
                         <input type="text" name="nom_habitat" value="<?= ($info_habitat['nom_habitat']) ?>" required
                             class="w-full rounded-lg border-gray-300 dark:bg-background-dark dark:border-gray-700 focus:ring-blue-500 text-sm">
                     </div>

                     <div>
                         <label class="block text-sm font-medium mb-1">Type de Climat</label>
                         <select name="type_climat" required class="w-full rounded-lg border-gray-300 dark:bg-background-dark dark:border-gray-700 focus:ring-blue-500 text-sm">
                             <?php
                                $climats = ["Tropical", "Aride", "Tempéré", "Polaire", "Aquatique", "Savane"];
                                foreach ($climats as $c): ?>
                                 <option value="<?= $c ?>" <?= ($info_habitat['type_climat'] == $c) ? 'selected' : '' ?>><?= $c ?></option>
                             <?php endforeach; ?>
                         </select>
                     </div>

                     <div>
                         <label class="block text-sm font-medium mb-1">Zone du Zoo</label>
                         <input type="text" name="zone_zoo" value="<?= ($info_habitat['zone_zoo']) ?>" required
                             class="w-full rounded-lg border-gray-300 dark:bg-background-dark dark:border-gray-700 focus:ring-blue-500 text-sm">
                     </div>

                     <div>
                         <label class="block text-sm font-medium mb-1">Description</label>
                         <textarea name="description_habitat" rows="4" required
                             class="w-full rounded-lg border-gray-300 dark:bg-background-dark dark:border-gray-700 focus:ring-blue-500 text-sm"><?= ($info_habitat['description_habitat']) ?></textarea>
                     </div>

                     <div class="mt-2 flex gap-3">
                         <button type="button" onclick="document.getElementById('modalEditHabitat').remove()"
                             class="flex-1 py-2 text-sm font-bold border border-gray-300 rounded-lg hover:bg-gray-50">Annuler</button>
                         <button type="submit" class="flex-1 py-2 text-sm font-bold bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-lg shadow-blue-600/20">
                             Mettre à jour
                         </button>
                     </div>
                 </form>
             </div>
         </div>
     
         <?php endif; ?>
     <div id="modalHabitat" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
         <div class="bg-surface-light dark:bg-surface-dark w-full max-w-md p-6 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-800">
             <div class="flex justify-between items-center mb-6">
                 <h2 class="text-xl font-bold">Nouvel Habitat</h2>
                 <button onclick="toggleModal('modalHabitat')" class="text-gray-500 hover:text-red-500">
                     <span class="material-symbols-outlined">close</span>
                 </button>
             </div>

             <form action="php/add_habitat.php" method="POST" class="flex flex-col gap-4">
                 <div>
                     <label class="block text-sm font-medium mb-1">Nom de l'habitat</label>
                     <input type="text" name="nom_habitat" required
                         class="w-full rounded-lg border-gray-300 dark:bg-background-dark dark:border-gray-700 focus:ring-primary text-sm">
                 </div>

                 <div>
                     <label class="block text-sm font-medium mb-1">Type de Climat</label>
                     <select name="type_climat" required
                         class="w-full rounded-lg border-gray-300 dark:bg-background-dark dark:border-gray-700 focus:ring-primary text-sm">
                         <option value="" disabled selected>Choisir un climat...</option>
                         <option value="Tropical">Tropical (Humide)</option>
                         <option value="Aride">Aride (Désertique)</option>
                         <option value="Tempéré">Tempéré (Forêt)</option>
                         <option value="Polaire">Polaire (Froid)</option>
                         <option value="Aquatique">Aquatique</option>
                         <option value="Savane">Savane</option>
                     </select>
                 </div>

                 <div>
                     <label class="block text-sm font-medium mb-1">Zone du Zoo</label>
                     <input type="text" name="zone_zoo" placeholder="Ex: Secteur Nord" required
                         class="w-full rounded-lg border-gray-300 dark:bg-background-dark dark:border-gray-700 focus:ring-primary text-sm">
                 </div>

                 <div>
                     <label class="block text-sm font-medium mb-1">Description</label>
                     <textarea name="description_habitat" rows="3" maxlength="500" required
                         class="w-full rounded-lg border-gray-300 dark:bg-background-dark dark:border-gray-700 focus:ring-primary text-sm"
                         placeholder="Décrivez l'environnement..."></textarea>
                 </div>

                 <div class="mt-2 flex gap-3">
                     <button type="button" onclick="toggleModal('modalHabitat')"
                         class="flex-1 py-2 text-sm font-bold border border-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                         Annuler
                     </button>
                     <button type="submit"
                         class="flex-1 py-2 text-sm font-bold bg-primary text-white rounded-lg hover:bg-primary-dark shadow-lg shadow-primary/20 transition-all">
                         Enregistrer
                     </button>
                 </div>
             </form>
         </div>
     </div>
     <?php if ($info): ?>
         <div id="modalInfoHabitat" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
             <div class="bg-surface-light dark:bg-surface-dark w-full max-w-lg p-8 rounded-2xl shadow-2xl border border-primary/20">
                 <div class="flex justify-between items-start mb-6">
                     <div>
                         <p class="text-primary font-bold text-xs uppercase tracking-widest">Détails de l'habitat</p>
                         <h2 class="text-3xl font-black"><?= ($info_habitat['nom_habitat']) ?></h2>
                     </div>
                     <button onclick="closeInfoModal()" class="bg-gray-100 dark:bg-gray-800 p-2 rounded-full hover:text-red-500 transition-colors">
                         <span class="material-symbols-outlined">close</span>
                     </button>
                 </div>
                 <div class="grid grid-cols-2 gap-4 mb-6">
                     <div class="p-4 bg-gray-50 dark:bg-background-dark rounded-xl">
                         <p class="text-xs text-text-secondary-light">Climat</p>
                         <p class="font-bold"><?= ($info_habitat['type_climat']) ?></p>
                     </div>
                     <div class="p-4 bg-gray-50 dark:bg-background-dark rounded-xl">
                         <p class="text-xs text-text-secondary-light">Zone géographique</p>
                         <p class="font-bold"><?= ($info_habitat['zone_zoo']) ?></p>
                     </div>
                 </div>
                 <div class="mb-8">
                     <p class="text-xs text-text-secondary-light mb-2">Description complète</p>
                     <p class="text-sm leading-relaxed italic text-text-secondary-dark">
                         "<?= nl2br(($info_habitat['description_habitat'])) ?>"
                     </p>
                 </div>
                 <button onclick="closeInfoModal()" class="w-full py-3 bg-primary text-white font-bold rounded-xl">Fermer</button>
             </div>
         </div>
     <?php endif; ?>
     <script>
         document.getElementById('card_habitas').addEventListener('click', (e) => {
             const btnDelete = e.target.closest('.btn-delete');
             if (btnDelete) {
                 if (confirm("Voulez-vous vraiment supprimer cet habitat ?")) {
                     btnDelete.closest('form').submit();
                 }
             }
         });
         document.getElementById('card_habitas').addEventListener('click', (e) => {
             const ele_click = e.target;
             if (ele_click.tagName === 'SPAN') {
                 const form = ele_click.closest('form.info');
                 if (form)

                     form.submit();

             }
         });


         function toggleModal(id) {
             const modal = document.getElementById(id);
             modal.classList.toggle('hidden');
             modal.classList.toggle('flex');
         }

         function closeInfoModal() {
             const modal = document.getElementById('modalInfoHabitat');
             if (modal) modal.remove();
         }
     </script>
 </body>

 </html>