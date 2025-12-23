<?php
include "../db_connect.php";
session_start();


if (
    isset($_SESSION['role_utilisateur'], $_SESSION['logged_in']) &&
    $_SESSION['role_utilisateur'] === "guide" &&
    $_SESSION['logged_in'] === TRUE
) {
    $id_utilisateur = ($_SESSION['id_utilisateur']);
    $nom_utilisateur = ($_SESSION['nom_utilisateur']);
    $role_utilisateur = ($_SESSION['id_utilisateur']);



    $tours = [];
    $sql = "SELECT * FROM visitesguidees WHERE id_guide = ? ORDER BY dateheure_viste DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_utilisateur);
    $stmt->execute();
    $resultat = $stmt->get_result();

    while ($ligne = $resultat->fetch_assoc())
        $tours[] = $ligne;
}else {

    header("Location: ../connexion.php?error=access_denied");
    exit();
}
?>
<!DOCTYPE html>
<html class="light" lang="fr">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Mes Visites - ASSAD</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
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
                    }
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 1, 'wght' 400;
        }

        body {
            font-family: "Plus Jakarta Sans", sans-serif;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark min-h-screen text-text-main-light dark:text-text-main-dark transition-colors duration-200">
    <div class="flex h-screen w-full overflow-hidden">
        <aside class="hidden lg:flex flex-col w-72 border-r border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark p-6 h-full justify-between">
            <div class="flex flex-col gap-8">
                <div class="flex items-center gap-3 px-2">
                    <div class="bg-primary/20 p-2 rounded-lg">
                        <span class="material-symbols-outlined text-primary text-3xl">pets</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold tracking-tight">ASSAD</h1>
                        <p class="text-text-sec-light dark:text-text-sec-dark text-xs uppercase tracking-wider font-semibold">Guide Space</p>
                    </div>
                </div>
                <nav class="flex flex-col gap-2">
                    <a class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-border-light dark:hover:bg-surface-dark transition-colors font-medium" href="index.php">
                        <span class="material-symbols-outlined text-text-sec-light dark:text-text-sec-dark">dashboard</span>
                        <span>Tableau de bord</span>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-xl bg-primary/10 text-primary font-bold" href="#">
                        <span class="material-symbols-outlined">map</span>
                        <span>Mes Visites</span>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-border-light dark:hover:bg-surface-dark transition-colors font-medium" href="reservations.php">
                        <span class="material-symbols-outlined text-text-sec-light dark:text-text-sec-dark">groups</span>
                        <span>Réservations</span>
                    </a>
                </nav>
            </div>
           <div class="border-t border-gray-200 dark:border-gray-800 pt-4 px-2">
                 <div class="flex items-center gap-3">

                     <div class="flex flex-col">
                         <a href="../php/seconnecter.php" class="text-xs text-text-secondary-light dark:text-text-secondary-dark">se deconnecter</a>
                     </div>
                 </div>
             </div>
        </aside>

        <main class="flex-1 flex flex-col h-full overflow-y-auto">
            <div class="p-6 md:p-10 max-w-7xl mx-auto w-full flex flex-col gap-8">
                <div class="flex flex-wrap justify-between items-end gap-4">
                    <div class="flex flex-col gap-2">
                        <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight">Mes Visites</h2>
                        <p class="text-text-sec-light dark:text-text-sec-dark text-lg">Gérez vos programmes de visites guidées.</p>
                    </div>
                    <button onclick="toggleModal()" class="flex items-center gap-2 bg-primary hover:bg-primary/90 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-primary/30 transition-all transform hover:scale-105">
                        <span class="material-symbols-outlined">add_circle</span>
                        <span>Créer une nouvelle visite</span>
                    </button>
                </div>

                <div class="flex flex-col gap-6">
                    <div class="flex items-center gap-4 border-b border-border-light dark:border-border-dark pb-3">
                        <h3 class="text-xl font-bold">Liste des Visites (<?= count($tours) ?>)</h3>
                    </div>

                    <?php foreach ($tours as $tour) : ?>
                        <div class="flex flex-col sm:flex-row gap-4 p-4 rounded-2xl bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark shadow-md">
                            <div class="h-32 sm:w-32 rounded-xl bg-primary/10 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-primary text-4xl">image</span>
                            </div>

                            <div class="flex flex-col justify-between flex-1 gap-2">
                                <div>
                                    <div class="flex justify-between">
                                        <h4 class="text-xl font-bold text-primary"><?= ($tour['titre_visite']) ?></h4>
                                        <?php
                                        if ($tour['statut__visite'] == 0)

                                            echo '<span class="text-xs font-bold px-2 py-1 bg-green-100 text-green-700 rounded-lg">Actif</span>';
                                        else
                                            echo '<span class="text-xs font-bold px-2 py-1 bg-green-100 text-green-700 rounded-lg">pas disponible</span>';

                                        ?>

                                    </div>
                                    <p class="text-sm line-clamp-2 mt-1"><?= ($tour['description_visite']) ?></p>

                                    <div class="flex flex-wrap gap-4 mt-3 text-xs font-medium text-text-sec-light dark:text-text-sec-dark">
                                        <div class="flex items-center gap-1">
                                            <span class="material-symbols-outlined text-sm">calendar_today</span>
                                            <?= date('d M Y H:i', strtotime($tour['dateheure_viste'])) ?>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <span class="material-symbols-outlined text-sm">payments</span>
                                            <?= $tour['prix__visite'] ?> DH
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <span class="material-symbols-outlined text-sm">language</span>
                                            <?= $tour['langue__visite'] ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex gap-2 mt-2">
                                    <a href="visite_details.php?id=<?= $tour['id_visite'] ?>" class="flex items-center gap-2 px-4 py-2 rounded-lg bg-primary text-white text-sm font-semibold hover:bg-primary/90 transition-colors">
                                        <span class="material-symbols-outlined text-[18px]">visibility</span>
                                        Détails
                                    </a>
                                    <button onclick='editTour(<?= json_encode($tour) ?>)' class="flex items-center gap-1 px-3 py-1.5 rounded-lg border border-border-light dark:border-border-dark text-xs font-bold hover:bg-gray-50 dark:hover:bg-background-dark transition-colors">
                                        <span class="material-symbols-outlined text-sm">edit</span> Modifier
                                    </button>
                                    <button onclick="confirmDelete(<?= $tour['id_visite'] ?>) ;" class="flex items-center gap-2 px-4 py-2 rounded-lg border border-red-200 dark:border-red-900/30 text-red-600 dark:text-red-400 text-sm font-semibold hover:bg-red-50 dark:hover:bg-red-900/10 transition-colors">
                                        <span class="material-symbols-outlined text-[18px]">cancel</span>
                                        Annuler
                                    </button>
                                </div>




                            </div>
                        </div>
                    <?php endforeach; ?>

                    <?php if (empty($tours)): ?>
                        <div class="text-center p-12 bg-surface-light dark:bg-surface-dark rounded-2xl border-2 border-dashed border-border-light dark:border-border-dark">
                            <span class="material-symbols-outlined text-primary text-5xl mb-4">map</span>
                            <p class="text-xl font-bold">Aucune visite pour le moment</p>
                            <p class="text-text-sec-light mb-6">Commencez par créer votre première expérience.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <div id="tourModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-surface-light dark:bg-surface-dark w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-2xl shadow-2xl">
            <div class="p-6 border-b border-border-light dark:border-border-dark flex justify-between items-center sticky top-0 bg-surface-light dark:bg-surface-dark z-10">
                <h3 id="modalTitle" class="text-2xl font-bold">Nouvelle Visite</h3>
                <button onclick="toggleModal()" class="text-text-sec-light hover:text-primary transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <form id="visiteForm" action="php/save_visite.php" method="POST" class="p-6 space-y-6">
                <input type="hidden" name="id_visite" id="id_visite">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold mb-1">Titre de la visite</label>
                        <input type="text" name="titre_visite" id="titre_visite" required class="w-full rounded-xl border-border-light dark:bg-background-dark dark:border-dark focus:ring-primary focus:border-primary">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold mb-1">Description</label>
                        <textarea name="description_visite" id="description_visite" rows="2" class="w-full rounded-xl border-border-light dark:bg-background-dark dark:border-dark"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-1">Date et Heure</label>
                        <input type="datetime-local" name="dateheure_viste" id="dateheure_viste" required class="w-full rounded-xl border-border-light dark:bg-background-dark dark:border-dark">
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-1">Langue</label>
                        <select name="langue__visite" id="langue__visite" class="w-full rounded-xl border-border-light dark:bg-background-dark dark:border-dark">
                            <option value="Français">Français</option>
                            <option value="Arabe">Arabe</option>
                            <option value="Anglais">Anglais</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-1">Prix (DH)</label>
                        <input type="number" name="prix__visite" id="prix__visite" required class="w-full rounded-xl border-border-light dark:bg-background-dark dark:border-dark">
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-1">Capacité Max</label>
                        <input type="number" name="capacite_max__visite" id="capacite_max__visite" required class="w-full rounded-xl border-border-light dark:bg-background-dark dark:border-dark">
                    </div>
                </div>

                <div class="border-t border-border-light dark:border-border-dark pt-4">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="font-bold flex items-center gap-2 text-primary">
                            <span class="material-symbols-outlined">route</span> Étapes de la visite
                        </h4>
                        <button type="button" onclick="addEtape()" class="text-xs bg-primary text-white px-3 py-1 rounded-lg hover:bg-primary/90 transition-all flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">add</span> Ajouter
                        </button>
                    </div>
                    <div id="etapesContainer" class="space-y-3">
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-6">
                    <button type="button" onclick="toggleModal()" class="px-6 py-2 rounded-xl font-bold border border-border-light dark:border-border-dark">Annuler</button>
                    <button type="submit" class="px-6 py-2 rounded-xl font-bold bg-primary text-white shadow-lg">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let etapeCount = 0;

        function toggleModal() {
            const modal = document.getElementById('tourModal');
            modal.classList.toggle('hidden');
            if (modal.classList.contains('hidden')) {
                document.getElementById('visiteForm').reset();
                document.getElementById('etapesContainer').innerHTML = '';
                etapeCount = 0;
                addEtape(); // Toujours avoir au moins une étape
            }
        }

        function addEtape(titre = '', desc = '') {
            const container = document.getElementById('etapesContainer');
            const etapeId = etapeCount;
            const html = `
                <div class="etape-item bg-background-light dark:bg-background-dark p-4 rounded-xl border border-border-light dark:border-border-dark relative animate-in slide-in-from-top-1 duration-200">
                    <button type="button" onclick="this.parentElement.remove(); updateNumbers();" class="absolute top-2 right-2 text-red-500 hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-sm">delete</span>
                    </button>
                    <div class="flex items-center gap-3 mb-2">
                        <span class="step-number bg-primary text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold">${etapeId + 1}</span>
                        <input type="text" name="etapes[${etapeId}][titre]" value="${titre}" placeholder="Titre de l'étape" required class="flex-1 text-sm rounded-lg border-border-light dark:bg-surface-dark">
                    </div>
                    <textarea name="etapes[${etapeId}][desc]" placeholder="Description..." class="w-full text-sm rounded-lg border-border-light dark:bg-surface-dark">${desc}</textarea>
                    <input type="hidden" name="etapes[${etapeId}][ordre]" class="step-ordre" value="${etapeId + 1}">
                </div>`;
            container.insertAdjacentHTML('beforeend', html);
            etapeCount++;
        }

        function updateNumbers() {
            const items = document.querySelectorAll('.etape-item');
            items.forEach((item, index) => {
                item.querySelector('.step-number').innerText = index + 1;
                item.querySelector('.step-ordre').value = index + 1;
            });
            etapeCount = items.length;
        }

        function editTour(data) {
            toggleModal();
            document.getElementById('modalTitle').innerText = "Modifier la Visite";
            document.getElementById('id_visite').value = data.id_visite;
            document.getElementById('titre_visite').value = data.titre_visite;
            document.getElementById('description_visite').value = data.description_visite;
            document.getElementById('dateheure_viste').value = data.dateheure_viste.replace(' ', 'T');
            document.getElementById('langue__visite').value = data.langue__visite;
            document.getElementById('prix__visite').value = data.prix__visite;
            document.getElementById('capacite_max__visite').value = data.capacite_max__visite;
            // Note: Pour charger les étapes en édition, il faudrait faire un appel AJAX ou les passer en JSON.
        }

        function confirmDelete(id) {
            if (confirm("Êtes-vous sûr de vouloir supprimer cette visite définitivement ?")) {
                window.location.href = "php/delete_visite.php?id=" + id;
            }
        }
        // Initialisation
        document.addEventListener('DOMContentLoaded', () => {
            addEtape();
        });
    </script>
</body>

</html>