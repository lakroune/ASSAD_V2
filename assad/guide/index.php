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



    $date_now = date('d-m-Y H:i:s');
    $sql = " SELECT * FROM visitesguidees where id_guide = $id_utilisateur and dateheure_viste <= ' " . $date_now . "' order by  dateheure_viste desc limit 1";

    $resultat = $conn->query($sql);
    $visite = array();
    if ($resultat->num_rows > 0)
        $visite = $resultat->fetch_assoc();





    $sql = " SELECT count(*) as total_visite FROM visitesguidees where id_guide = $id_utilisateur";
    $resultat = $conn->query($sql);
    $total_visite = 0;
    if ($resultat->num_rows == 1)
        $total_visite = $resultat->fetch_assoc()["total_visite"];



    $sql = " SELECT c.note FROM visitesguidees v  INNER JOIN commentaires c on c.id_visite= c.id_visite and v.id_guide = $id_utilisateur";
    $resultat = $conn->query($sql);

    $snbtar = 0;
    $count_res = 0;
    $star_total = 0;
    while ($ligne =  $resultat->fetch_assoc()) {
        $snbtar += $ligne["note"];
        $count_res++;
    }
    if ($count_res > 0)
        $star_total = $snbtar / (5 * $count_res);
} else {
    // Redirection de sécurité
    header("Location: ../connexion.php?error=access_denied");
    exit();
}
?>

<!DOCTYPE html>

<html class="light" lang="fr">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Tableau de bord - ASSAD</title>
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

                    <a class="flex items-center gap-3 px-4 py-3 rounded-xl bg-primary/10 text-primary dark:text-primary font-bold" href="./index.php">
                        <span class="material-symbols-outlined">dashboard</span>
                        <span>Tableau de bord</span>
                    </a>

                    <a class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-main-light dark:text-text-sec-dark hover:bg-border-light dark:hover:bg-surface-dark transition-colors font-medium" href="./mes_visites.php">
                        <span class="material-symbols-outlined text-text-sec-light dark:text-text-sec-dark">map</span>
                        <span>Mes Visites</span>
                    </a>

                    <a class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-main-light dark:text-text-sec-dark hover:bg-border-light dark:hover:bg-surface-dark transition-colors font-medium" href="reservations.php">
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
        <main class="flex-1 flex flex-col h-full overflow-y-auto overflow-x-hidden">
            <div class="lg:hidden flex items-center justify-between p-4 border-b border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark sticky top-0 z-20">
                <span class="material-symbols-outlined text-primary">pets</span>
                <span class="material-symbols-outlined text-text-main-light dark:text-text-main-dark">menu</span>
            </div>

            <div class="p-6 md:p-10 max-w-7xl mx-auto w-full flex flex-col gap-8">

                <div class="flex flex-col gap-2">
                    <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight">Bonjour, <?= $nom_utilisateur ?> !</h2>
                    <p class="text-text-sec-light dark:text-text-sec-dark text-lg">Votre espace de gestion pour les visites virtuelles d'ASSAD.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                    <div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-border-light dark:border-border-dark shadow-md p-5 flex flex-col gap-2">
                        <span class="material-symbols-outlined text-primary text-3xl">event_upcoming</span>
                        <p class="text-sm text-text-sec-light dark:text-text-sec-dark font-medium">Prochaine Visite</p>
                        <p class="text-xl font-extrabold tracking-tight text-primary"><?php if ($visite) echo date('d-m-Y', strtotime($visite['dateheure_viste'])) ?></p>
                        <p class="text-sm  font-extrabold tracking-tight text-primary"><?php if ($visite) echo "à  " . date('H:i', strtotime($visite['dateheure_viste'])) ?></p>
                        <p class="text-sm font-semibold"><?php if ($visite) echo  $visite["titre_visite"];
                                                            else echo "aucun visite pour ce instant"  ?></p>
                    </div>

                    <div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-border-light dark:border-border-dark shadow-md p-5 flex flex-col gap-2">
                        <span class="material-symbols-outlined text-green-600 text-3xl">map</span>
                        <p class="text-sm text-text-sec-light dark:text-text-sec-dark font-medium">Visites Créées</p>
                        <p class="text-xl font-extrabold tracking-tight"><?= $total_visite ?></p>
                        <p class="text-sm font-semibold">total historique</p>
                    </div>

                    <!-- <div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-border-light dark:border-border-dark shadow-md p-5 flex flex-col gap-2">
                        <span class="material-symbols-outlined text-blue-600 text-3xl">groups</span>
                        <p class="text-sm text-text-sec-light dark:text-text-sec-dark font-medium">Réservations à Venir</p>
                        <p class="text-xl font-extrabold tracking-tight"><?= "cccc" ?></p>
                        <p class="text-sm font-semibold">participants confirmés</p>
                    </div> -->

                    <div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-border-light dark:border-border-dark shadow-md p-5 flex flex-col gap-2">
                        <span class="material-symbols-outlined text-yellow-500 text-3xl">star</span>
                        <p class="text-sm text-text-sec-light dark:text-text-sec-dark font-medium">Note Guide</p>
                        <p class="text-xl font-extrabold tracking-tight"><?= $star_total ?> / 5.0</p>
                        <p class="text-sm font-semibold">basé sur les retours</p>
                    </div>
                </div>

            </div>
        </main>
    </div>
</body>

</html>