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




    $sql = " select * from  utilisateurs u inner join  reservations r on  r.id_utilisateur = u.id_utilisateur inner join  visitesguidees v on v.id_visite=r.id_visite and id_guide= $id_utilisateur";
    $resultat = $conn->query($sql);
    $array_participants = array();
    while ($ligne =  $resultat->fetch_assoc())
        array_push($array_participants, $ligne);
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
    <title>Réservations - ASSAD</title>
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
                    <a class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-main-light dark:text-text-sec-dark hover:bg-border-light dark:hover:bg-surface-dark transition-colors font-medium" href="index.php">
                        <span class="material-symbols-outlined text-text-sec-light dark:text-text-sec-dark">dashboard</span>
                        <span>Tableau de bord</span>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-main-light dark:text-text-sec-dark hover:bg-border-light dark:hover:bg-surface-dark transition-colors font-medium" href="mes_visites.php">
                        <span class="material-symbols-outlined text-text-sec-light dark:text-text-sec-dark">map</span>
                        <span>Mes Visites</span>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-xl bg-primary/10 text-primary dark:text-primary font-bold" href="#">
                        <span class="material-symbols-outlined">groups</span>
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
        <main class="flex-1 flex flex-col h-full overflow-y-auto overflow-x-hidden">
            <div class="lg:hidden flex items-center justify-between p-4 border-b border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark sticky top-0 z-20">
                <span class="material-symbols-outlined text-primary">pets</span>
                <span class="material-symbols-outlined text-text-main-light dark:text-text-main-dark">menu</span>
            </div>

            <div class="p-6 md:p-10 max-w-7xl mx-auto w-full flex flex-col gap-8">
                <div class="flex flex-wrap justify-between items-end gap-4">
                    <div class="flex flex-col gap-2">
                        <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight">Réservations</h2>
                        <p class="text-text-sec-light dark:text-text-sec-dark text-lg">Suivez les inscriptions pour vos visites et gérez les participants.</p>
                    </div>
                </div>

                <div class="flex flex-col">
                    <div class="flex border-b border-border-light dark:border-border-dark gap-6 overflow-x-auto">

                    </div>
                </div>

                <div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-border-light dark:border-border-dark shadow-sm overflow-x-auto">

                    <table class="min-w-full divide-y divide-border-light dark:divide-border-dark">
                        <thead class="bg-gray-50/50 dark:bg-white/5">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-text-sec-light dark:text-text-sec-dark uppercase tracking-wider">
                                    Nom du Visiteur
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-text-sec-light dark:text-text-sec-dark uppercase tracking-wider">
                                    Visite
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-text-sec-light dark:text-text-sec-dark uppercase tracking-wider">
                                    Date & Heure
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-text-sec-light dark:text-text-sec-dark uppercase tracking-wider">
                                    Participants
                                </th>


                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border-light dark:divide-border-dark">

                            <?php if (empty($array_participants)): ?>
                                <tr>
                                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-sm text-text-sec-light dark:text-text-sec-dark">
                                        Aucune réservation  .
                                    </td>
                                </tr>
                            <?php else: ?>

                                <?php foreach ($array_participants as $participant) : ?>
                                    <tr class="hover:bg-background-light dark:hover:bg-white/5 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-text-main-light dark:text-text-main-dark"><?= ($participant['nom_utilisateur']) ?></div>
                                            <div class="text-xs text-text-sec-light dark:text-text-sec-dark">Réf:Visite- <?= ($participant['id_visite']) ?></div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-text-main-light dark:text-text-main-dark line-clamp-1"><?= ($participant['titre_visite']) ?></div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-text-main-light dark:text-text-main-dark"><?= (new DateTime($participant['dateheure_viste']))->format('d M Y') ?></div>
                                            <div class="text-xs text-text-sec-light dark:text-text-sec-dark"><?= (new DateTime($participant['dateheure_viste']))->format('h : m')  ?></div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span class="text-sm font-bold"><?= ($participant['nb_personnes']) ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>

</html>