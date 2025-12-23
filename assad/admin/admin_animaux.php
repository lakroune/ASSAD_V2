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




        $sql = "  select * from  animaux a inner join  habitats h on a.id_habitat =h.id_habitat where nom_animal like  ?";
        $searchInput = "%";
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['searchInput']))
            $searchInput =  ($_POST["searchInput"]) . "%";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $searchInput);
        $stmt->execute();
        $resultat = $stmt->get_result();
        $array_animaux = array();
        while ($ligne =  $resultat->fetch_assoc())
            array_push($array_animaux, $ligne);



        $info_animal = null;
        $info = false;
        $edit = false;
        if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['id_animal_info']) or isset($_POST['id_animal_edit']))) {
            $id_animal = null;
            if (!empty($_POST['id_animal_info'])) {
                $info = true;
                $id_animal = $_POST['id_animal_info'];
            }
            if (!empty($_POST['id_animal_edit'])) {
                $edit = true;
                $id_animal = $_POST['id_animal_edit'];
            }
            $sql_info = " select * from  animaux a inner join  habitats h on a.id_habitat =h.id_habitat  WHERE id_animal = ?";
            $stmt = $conn->prepare($sql_info);
            $stmt->bind_param("i", $id_animal);
            $stmt->execute();
            $res = $stmt->get_result();
            $info_animal = $res->fetch_assoc();
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
     <title>Gestion des Animaux - ASSAD Admin</title>
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
                     <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-primary text-white shadow-md shadow-primary/20"
                         href="admin_animaux.php">
                         <span
                             class="material-symbols-outlined text-2xl fill-current">pets</span>
                         <span class="text-sm font-medium">Gestion Animaux</span>
                     </a>
                     <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-text-secondary-light dark:text-text-secondary-dark hover:bg-primary/10 hover:text-primary transition-colors group"
                         href="./admin_habitats.php">
                         <span
                             class="material-symbols-outlined text-2xl group-hover:text-primary transition-colors">nature</span>
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
                 <div class="flex flex-col">
                     <a href="../php/sedeconnecter.php" class="text-xs text-text-secondary-light dark:text-text-secondary-dark">se deconnecter</a>
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
                         <h1 class="text-3xl font-black tracking-tight text-text-light dark:text-text-dark">Gestion des Animaux</h1>
                         <p
                             class="text-text-secondary-light dark:text-text-secondary-dark text-sm font-medium flex items-center gap-1">
                             Base de données complète des espèces du Zoo Virtuel
                         </p>
                     </div>
                     <div class="flex items-center gap-3">
                         <button onclick="toggleModal()" class="flex items-center gap-2 px-4 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white shadow-lg shadow-green-600/30 transition-all text-sm font-bold">
                             <span class="material-symbols-outlined text-lg">add</span>
                             Ajouter Nouvel Animal
                         </button>
                     </div>
                 </div>
             </div>
         </header>
         <div class="flex-1 overflow-y-auto bg-background-light dark:bg-background-dark">
             <div class="max-w-7xl mx-auto w-full px-6 py-8 flex flex-col gap-8">

                 <div class="flex flex-col md:flex-row justify-between items-center gap-4 p-4 bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
                     <div class="flex flex-wrap gap-3">
                         <span class="px-4 py-2 text-sm font-bold rounded-lg bg-primary text-white shadow-sm">Tous (<?= count($array_animaux) ?>)</span>
                     </div>
                     <div class="relative w-full md:w-auto">
                         <span
                             class="material-symbols-outlined absolute left-2.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm">search</span>
                         <input
                             class="pl-8 pr-3 py-1.5 rounded-lg border-gray-200 dark:border-gray-700 bg-white dark:bg-surface-dark text-sm w-full md:w-64 focus:ring-primary/20 focus:border-primary"
                             placeholder="Rechercher par nom ou espèce..." type="text" />
                     </div>
                 </div>
                 <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
                     <div class="bg-surface-light dark:bg-surface-dark p-5 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
                         <div class="flex items-center gap-3">
                             <span class="material-symbols-outlined text-3xl text-primary">forest</span>
                             <div>
                                 <p class="text-sm text-text-secondary-light dark:text-text-secondary-dark">Carnivore</p>
                                 <h3 class="text-xl font-bold text-text-light dark:text-text-dark"><?= count(array_filter($array_animaux, fn($a) => $a['alimentation_animal'] === 'Carnivore')) ?></h3>
                             </div>
                         </div>
                     </div>
                     <div class="bg-surface-light dark:bg-surface-dark p-5 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
                         <div class="flex items-center gap-3">
                             <span class="material-symbols-outlined text-3xl text-green-600">forest</span>
                             <div>
                                 <p class="text-sm text-text-secondary-light dark:text-text-secondary-dark">Herbivore</p>
                                 <h3 class="text-xl font-bold text-text-light dark:text-text-dark"><?= count(array_filter($array_animaux, fn($a) => $a['alimentation_animal'] === 'herbivore')) ?></h3>
                             </div>
                         </div>
                     </div>
                     <div class="bg-surface-light dark:bg-surface-dark p-5 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
                         <div class="flex items-center gap-3">
                             <span class="material-symbols-outlined text-3xl text-blue-600">forest</span>
                             <div>
                                 <p class="text-sm text-text-secondary-light dark:text-text-secondary-dark">Omnivore</p>
                                 <h3 class="text-xl font-bold text-text-light dark:text-text-dark"><?= count(array_filter($array_animaux, fn($a) => $a['alimentation_animal'] === 'omnivore')) ?></h3>
                             </div>
                         </div>
                     </div>
                 </section>

                 <div
                     class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-xl border border-gray-100 dark:border-gray-800 overflow-hidden">
                     <div class="overflow-x-auto">
                         <table class="w-full text-left text-sm whitespace-nowrap">
                             <thead
                                 class="bg-gray-50/50 dark:bg-gray-800/30 border-b border-gray-100 dark:border-gray-800">
                                 <tr>
                                     <th
                                         class="px-6 py-3 font-semibold text-text-secondary-light dark:text-text-secondary-dark">
                                         ID / Animal</th>
                                     <th
                                         class="px-6 py-3 font-semibold text-text-secondary-light dark:text-text-secondary-dark">
                                         Espèce</th>
                                     <th
                                         class="px-6 py-3 font-semibold text-text-secondary-light dark:text-text-secondary-dark">
                                         Habitat</th>
                                     <th
                                         class="px-6 py-3 font-semibold text-text-secondary-light dark:text-text-secondary-dark">
                                         alimentation</th>
                                     <th
                                         class="px-6 py-3 font-semibold text-text-secondary-light dark:text-text-secondary-dark text-right">
                                         Actions</th>
                                 </tr>
                             </thead>
                             <tbody id="card-animaux" class="divide-y divide-gray-100 dark:divide-gray-800">
                                 <?php foreach ($array_animaux as $animal) : ?>
                                     <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors group">
                                         <td class="px-6 py-3">
                                             <div class="flex items-center gap-3">
                                                 <div class="h-10 w-10 rounded-lg overflow-hidden bg-gray-100 shrink-0">
                                                     <img alt="<?= ($animal['nom_animal']) ?>" class="h-full w-full object-cover"
                                                         src="<?= ($animal['image_url']) ?>" />
                                                 </div>
                                                 <div class="flex flex-col">
                                                     <span class="font-bold text-text-light dark:text-text-dark"><?= ($animal['nom_animal']) ?></span>
                                                     <span class="text-xs text-text-secondary-light">ID: <?= ($animal['id_animal']) ?></span>
                                                 </div>
                                             </div>
                                         </td>
                                         <td class="px-6 py-3">
                                             <span class="text-text-light dark:text-text-dark font-medium"><?=  ($animal['espece']) ?></span>
                                         </td>
                                         <td class="px-6 py-3">
                                             <span class='inline-flex items-center gap-1 text-xs font-medium text-green-700 bg-green-50 dark:text-green-300 dark:bg-green-900/20 px-2 py-1 rounded-full border border-green-100 dark:border-green-800'>
                                                 <span class='material-symbols-outlined text-[10px]'>forest</span>
                                                 <?= $animal["nom_habitat"] ?>
                                             </span>
                                         </td>
                                         <td class="px-6 py-3">
                                             <?=  ($animal['alimentation_animal']) ?>
                                         </td>
                                         <td class="px-6 py-3 text-right">
                                             <div
                                                 class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                                 <form action="" method="POST" class="edit">
                                                     <input type="hidden" value="<?= $animal['id_animal'] ?>" name="id_animal_edit">
                                                     <button
                                                         class="p-1.5 rounded hover:bg-gray-100 dark:hover:bg-gray-700 text-blue-500"
                                                         title="Éditer les détails">
                                                         <span class="material-symbols-outlined text-lg">edit</span>
                                                     </button>
                                                 </form>

                                                 <form action="" method="POST" class="info">
                                                     <input type="hidden" value="<?= $animal['id_animal'] ?>" name="id_animal_info">
                                                     <button
                                                         class="p-1.5 rounded hover:bg-gray-100 dark:hover:bg-gray-700 text-green-500"
                                                         title="Rendre visible">
                                                         <span class="material-symbols-outlined text-lg">visibility</span>
                                                     </button>
                                                 </form>

                                                 <form action="php/delete_animal.php" method="POST" class="delete">
                                                     <input type="hidden" value="<?= $animal['id_animal'] ?>" name="id_animal">
                                                     <button
                                                         type="button"
                                                         class="p-1.5 rounded hover:bg-gray-100 dark:hover:bg-gray-700 text-red-500"
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
                         <?php if (empty($array_animaux)): ?>
                             <div class="p-6 text-center text-text-secondary-light dark:text-text-secondary-dark text-sm">
                                 Aucun animal trouvé.
                             </div>
                         <?php endif; ?>
                     </div>
                     <div class="p-4 border-t border-gray-100 dark:border-gray-800 flex justify-center">
                         <button
                             class="text-xs font-medium text-primary hover:text-primary-dark transition-colors flex items-center gap-1">
                             Afficher plus de résultats <span
                                 class="material-symbols-outlined text-sm">arrow_forward</span>
                         </button>
                     </div>
                 </div>


             </div>

         </div>
     </main>

     <?php if ($info && $info_animal): ?>
         <div id="modalInfoAnimal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
             <div class="bg-surface-light dark:bg-surface-dark w-full max-w-lg p-8 rounded-2xl shadow-2xl border border-primary/20">
                 <div class="flex justify-between items-start mb-6">
                     <div class="h-20 w-20 rounded-full shadow-lg border-2 border-primary"
                         style="background-image: url('<?= ($info_animal['image_url']) ?>'); background-size: cover; background-position: center;">
                     </div>
                     <div class="flex-1 ml-4">
                         <p class="text-primary font-bold text-xs uppercase tracking-widest">Fiche Animal</p>
                         <h2 class="text-3xl font-black"><?= ($info_animal['nom_animal']) ?></h2>
                     </div>
                     <button onclick="closeModal('modalInfoAnimal');" class="bg-gray-100 dark:bg-gray-800 p-2 rounded-full hover:text-red-500 transition-colors">
                         <span class="material-symbols-outlined">close</span>
                     </button>
                 </div>

                 <div class="grid grid-cols-2 gap-4 mb-6">
                     <div class="p-3 bg-gray-50 dark:bg-background-dark rounded-xl">
                         <p class="text-xs text-text-secondary-light">Espèce</p>
                         <p class="font-bold"><?= ($info_animal['espece']) ?></p>
                     </div>
                     <div class="p-3 bg-gray-50 dark:bg-background-dark rounded-xl">
                         <p class="text-xs text-text-secondary-light">Alimentation</p>
                         <p class="font-bold"><?= ($info_animal['alimentation_animal']) ?></p>
                     </div>
                     <div class="p-3 bg-gray-50 dark:bg-background-dark rounded-xl">
                         <p class="text-xs text-text-secondary-light">Pays d'Origine</p>
                         <p class="font-bold"><?= ($info_animal['pays_origine']) ?></p>
                     </div>
                     <div class="p-3 bg-gray-50 dark:bg-background-dark rounded-xl">
                         <p class="text-xs text-text-secondary-light">Habitat Actuel</p>
                         <p class="font-bold"><?= ($info_animal['nom_habitat']) ?></p>
                     </div>
                 </div>

                 <div class="mb-8">
                     <p class="text-xs text-text-secondary-light mb-2">Description</p>
                     <p class="text-sm leading-relaxed italic text-text-secondary-dark bg-gray-50 dark:bg-background-dark p-4 rounded-lg">
                         "<?= nl2br(($info_animal['description_animal'])) ?>"
                     </p>
                 </div>
                 <button onclick="closeModal('modalInfoAnimal')" class="w-full py-3 bg-primary text-white font-bold rounded-xl hover:bg-primary-dark transition-colors">Fermer</button>
             </div>
         </div>
     <?php endif; ?>

     <?php if ($edit && $info_animal): ?>
         <div id="modalEditAnimal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
             <div class="bg-surface-light dark:bg-surface-dark w-full max-w-md max-h-[90vh] overflow-y-auto p-6 rounded-xl shadow-2xl border border-blue-500/30">

                 <div class="flex justify-between items-center mb-6 sticky top-0 bg-surface-light dark:bg-surface-dark py-2 z-10 border-b dark:border-gray-700">
                     <h2 class="text-xl font-bold text-blue-600">Modifier l'Animal</h2>
                     <button onclick="window.location.href='admin_animaux.php'" class="text-gray-500 hover:text-red-500">
                         <span class="material-symbols-outlined">close</span>
                     </button>
                 </div>

                 <form action="php/update_animal.php" method="POST" class="flex flex-col gap-4">
                     <input type="hidden" name="id_animal" value="<?= $info_animal['id_animal'] ?>">

                     <div>
                         <label class="block text-sm font-medium mb-1">Nom de l'animal</label>
                         <input type="text" name="nom_animal" value="<?= ($info_animal['nom_animal']) ?>" required
                             class="w-full rounded-lg border-gray-300 dark:bg-background-dark dark:border-gray-700 focus:ring-blue-500 text-sm">
                     </div>

                     <div class="grid grid-cols-2 gap-4">
                         <div>
                             <label class="block text-sm font-medium mb-1">Espèce</label>
                             <input type="text" name="espece" value="<?= ($info_animal['espece']) ?>" required
                                 class="w-full rounded-lg border-gray-300 dark:bg-background-dark dark:border-gray-700 focus:ring-blue-500 text-sm">
                         </div>
                         <div>
                             <label class="block text-sm font-medium mb-1">Alimentation</label>
                             <select name="alimentation_animal" class="w-full rounded-lg border-gray-300 dark:bg-background-dark dark:border-gray-700 text-sm">
                                 <option value="Carnivore" <?= $info_animal['alimentation_animal'] == 'Carnivore' ? 'selected' : '' ?>>Carnivore</option>
                                 <option value="herbivore" <?= $info_animal['alimentation_animal'] == 'herbivore' ? 'selected' : '' ?>>Herbivore</option>
                                 <option value="omnivore" <?= $info_animal['alimentation_animal'] == 'omnivore' ? 'selected' : '' ?>>Omnivore</option>
                             </select>
                         </div>
                     </div>

                     <div>
                         <label class="block text-sm font-medium mb-1">Pays d'origine</label>
                         <input type="text" name="pays_origine" value="<?= ($info_animal['pays_origine']) ?>" required
                             class="w-full rounded-lg border-gray-300 dark:bg-background-dark dark:border-gray-700 focus:ring-blue-500 text-sm">
                     </div>

                     <div>
                         <label class="block text-sm font-medium mb-1">URL de l'image</label>
                         <input type="url" name="image_url" value="<?= ($info_animal['image_url']) ?>" required
                             class="w-full rounded-lg border-gray-300 dark:bg-background-dark dark:border-gray-700 focus:ring-blue-500 text-sm">
                     </div>

                     <div>
                         <label class="block text-sm font-medium mb-1">Habitat</label>
                         <select name="id_habitat" required class="w-full rounded-lg border-gray-300 dark:bg-background-dark dark:border-gray-700 text-sm">
                             <?php
                                $res_h = $conn->query("SELECT id_habitat, nom_habitat FROM habitats");
                                while ($h = $res_h->fetch_assoc()): ?>
                                 <option value="<?= $h['id_habitat'] ?>" <?= ($h['id_habitat'] == $info_animal['id_habitat']) ? 'selected' : '' ?>>
                                     <?= ($h['nom_habitat']) ?>
                                 </option>
                             <?php endwhile; ?>
                         </select>
                     </div>

                     <div>
                         <label class="block text-sm font-medium mb-1">Description</label>
                         <textarea name="description_animal" rows="4" required
                             class="w-full rounded-lg border-gray-300 dark:bg-background-dark dark:border-gray-700 focus:ring-blue-500 text-sm"><?= ($info_animal['description_animal']) ?></textarea>
                     </div>

                     <div class="mt-4 flex gap-3 sticky bottom-0 bg-surface-light dark:bg-surface-dark py-2 border-t dark:border-gray-700">
                         <button type="button" onclick="window.location.href='admin_animaux.php'"
                             class="flex-1 py-2 text-sm font-bold border border-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800">Annuler</button>
                         <button type="submit" class="flex-1 py-2 text-sm font-bold bg-blue-600 text-white rounded-lg hover:bg-blue-700">Mettre à jour</button>
                     </div>
                 </form>
             </div>
         </div>
     <?php endif; ?>
     <!-- model add animal -->

     <div id="modalAnimal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/50 backdrop-blur-sm flex  items-center justify-center p-4">
         <div class="bg-surface-light dark:bg-surface-dark w-full max-w-lg rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700">
             <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center">
                 <h2 class="text-xl font-bold text-text-light dark:text-text-dark">Ajouter un Nouvel Animal</h2>
                 <button onclick="toggleModal()" class="text-gray-400 hover:text-red-500 transition-colors">
                     <span class="material-symbols-outlined">close</span>
                 </button>
             </div>

             <form id="formAddAnimal" method="POST" action="php/ajouter_animal.php" class="p-6 space-y-4">
                 <div class="grid grid-cols-2 gap-4">
                     <div>
                         <label class="block text-xs font-bold uppercase text-text-secondary-light mb-1">Nom</label>
                         <input type="text" name="nom_animal" required class="w-full rounded-lg border-gray-200 dark:bg-background-dark dark:border-gray-700 text-sm">
                     </div>
                     <div>
                         <label class="block text-xs font-bold uppercase text-text-secondary-light mb-1">Espèce</label>
                         <input type="text" name="espece" required class="w-full rounded-lg border-gray-200 dark:bg-background-dark dark:border-gray-700 text-sm">
                     </div>
                 </div>

                 <div>
                     <label class="block text-xs font-bold uppercase text-text-secondary-light mb-1">Alimentation</label>
                     <select name="alimentation_animal" class="w-full rounded-lg border-gray-200 dark:bg-background-dark dark:border-gray-700 text-sm">
                         <option value="Carnivore">Carnivore</option>
                         <option value="herbivore">Herbivore</option>
                         <option value="omnivore">Omnivore</option>
                     </select>
                 </div>

                 <div>
                     <label class="block text-xs font-bold uppercase text-text-secondary-light mb-1">URL de l'image</label>
                     <input type="url" name="image_url" placeholder="https://..." required class="w-full rounded-lg border-gray-200 dark:bg-background-dark dark:border-gray-700 text-sm">
                 </div>

                 <div class="grid grid-cols-2 gap-4">
                     <div>
                         <label class="block text-xs font-bold uppercase text-text-secondary-light mb-1">Pays d'origine</label>
                         <input type="text" name="pays_origine" required class="w-full rounded-lg border-gray-200 dark:bg-background-dark dark:border-gray-700 text-sm">
                     </div>
                     <div>
                         <label class="block text-xs font-bold uppercase text-text-secondary-light mb-1">Habitat</label>
                         <select name="id_habitat" required class="w-full rounded-lg border-gray-200 dark:bg-background-dark dark:border-gray-700 text-sm">
                             <?php
                                $res_h = $conn->query("SELECT id_habitat, nom_habitat FROM habitats");
                                while ($h = $res_h->fetch_assoc()): ?>
                                 <option value="<?= $h['id_habitat'] ?>"><?= ($h['nom_habitat']) ?></option>
                             <?php endwhile; ?>
                         </select>
                     </div>
                 </div>

                 <div>
                     <label class="block text-xs font-bold uppercase text-text-secondary-light mb-1">Description</label>
                     <textarea name="description_animal" rows="3" class="w-full rounded-lg border-gray-200 dark:bg-background-dark dark:border-gray-700 text-sm"></textarea>
                 </div>

                 <div class="pt-4 flex gap-3">
                     <button type="button" onclick="toggleModal()" class="flex-1 px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg text-sm font-bold">Annuler</button>
                     <button type="submit" class="flex-1 px-4 py-2 bg-primary hover:bg-primary-dark text-white rounded-lg text-sm font-bold shadow-lg shadow-primary/30 transition-all">Enregistrer</button>
                 </div>
             </form>
         </div>
     </div>


     <script>
         document.getElementById('card-animaux').addEventListener('click', (e) => {
             const ele_click = e.target;
             if (ele_click.tagName === 'SPAN') {
                 const form = ele_click.closest('form.delete');
                 if (form)
                     if (confirm("Voulez-vous vraiment supprimer cet animal ?"))
                         form.submit();

             }
         });

         document.getElementById('card-animaux').addEventListener('click', (e) => {
             const ele_click = e.target;
             if (ele_click.tagName === 'SPAN') {
                 const form = ele_click.closest('form.edit');
                 if (form)
                     form.submit();

             }
         });
         document.getElementById('card-animaux').addEventListener('click', (e) => {
             const ele_click = e.target;
             if (ele_click.tagName === 'SPAN') {
                 const form = ele_click.closest('form.info');
                 if (form)
                     form.submit();

             }
         });

         function closeModal(modalId) {
             const modal = document.getElementById(modalId);
             if (modal) {
                 modal.classList.add('hidden');
                 modal.classList.remove('flex');
                 modal.remove();
             }
         }

         window.onclick = function(event) {
             if (event.target.id.includes('modal')) {
                 event.target.remove();
             }
         }

         function toggleModal() {
             const modal = document.getElementById('modalAnimal');
             modal.classList.toggle('hidden');
             modal.classList.toggle('flex');
         }
     </script>
 </body>

 </html>