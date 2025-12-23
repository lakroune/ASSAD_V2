<?php

$animal_id = isset($_GET['id']) ? ($_GET['id']) : null;

if ($animal_id) {

    session_start();
    include "../db_connect.php";

    if (
        isset($_SESSION['role_utilisateur'], $_SESSION['logged_in'], $_SESSION['id_utilisateur']) &&
        $_SESSION['role_utilisateur'] === "visiteur" &&
        $_SESSION['logged_in'] === TRUE
    ) {




        $id_utilisateur = ($_SESSION['id_utilisateur']);



        $sql = " SELECT * FROM animaux a INNER JOIN habitats h on a.id_habitat= h.id_habitat and a.id_animal= $animal_id";
        $resultat = $conn->query($sql);

        $animal = $resultat->fetch_assoc();
    } else {
        header("Location: ../connexion.php?error=access_denied");
        exit();
    }

    if (!$animal) {
        $error = "Animal non trouvé.";
    }
} else {
    $error = "ID d'animal manquant.";
}
?>

<!DOCTYPE html>
<html class="light" lang="fr">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Fiche de l'Animal - Zoo Virtuel ASSAD</title>
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


                    </div>
                    <a href="./reservation.php"
                        class="flex min-w-[84px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-10 px-4 bg-primary hover:bg-orange-600 transition-colors text-white text-sm font-bold leading-normal tracking-[0.015em]">
                        <span class="truncate">reserver</span>
                    </a>
                </div>
                <button class="lg:hidden text-[#1b140d]">
                    <span class="material-symbols-outlined">menu</span>
                </button>
            </div>
        </div>
    </header>

    <main class="flex-grow flex flex-col items-center py-10">
        <div class="w-full max-w-[1200px] px-4 md:px-10">
            <?php if (isset($error)): ?>
                <div class="p-6 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg">
                    <h2 class="font-bold text-xl mb-2">Erreur d'accès</h2>
                    <p><?= $error ?></p>
                    <a href="index.php" class="text-sm font-medium underline mt-2 inline-block">Retourner à la liste des animaux</a>
                </div>
            <?php else: ?>
                <div class="mb-8">
                    <a href="./animaux.php" class="flex items-center gap-1 text-primary hover:text-orange-600 text-sm font-bold transition-colors mb-4">
                        <span class="material-symbols-outlined text-lg">arrow_back</span>
                        Retour à la liste des animaux
                    </a>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <div class="lg:col-span-2 flex flex-col gap-6">

                        <div class="h-[450px] rounded-xl overflow-hidden relative shadow-2xl shadow-primary/20">
                            <img alt="<?= $animal['nom_animal'] ?>"
                                class="w-full h-full object-cover"
                                src="<?= ($animal['image_url']) ?>" />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <div class="absolute bottom-6 left-6 text-white">
                                <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-primary text-white text-sm font-bold shadow-lg mb-2">
                                    <span class="material-symbols-outlined text-[18px]">stars</span>
                                    <?= ($animal['alimentation_animal']) ?>
                                </span>
                                <h1 class="text-5xl font-black tracking-tight drop-shadow-lg"><?= ($animal['nom_animal']) ?></h1>
                                <p class="text-xl text-white/90 italic font-medium mt-1 drop-shadow-md"><?= ($animal['espece']) ?></p>
                            </div>
                        </div>



                    </div>

                    <div class="lg:col-span-1 flex flex-col gap-6">


                        <div class="bg-white p-6 rounded-xl shadow-lg border border-[#f3ede7]">
                            <h2 class="text-2xl font-bold text-primary mb-4 border-b border-gray-100 pb-2">À Propos de <?= ($animal['nom_animal']) ?></h2>

                            <div class="flex flex-wrap gap-4 mt-2 pt-2  border-gray-100">
                                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-orange-50 text-orange-600 text-sm font-bold">
                                    <span class="material-symbols-outlined text-lg">public</span>
                                    <?= ($animal['pays_origine']) ?>
                                </span>
                                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-red-50 text-red-600 text-sm font-bold">
                                    <span class="material-symbols-outlined text-lg">eco</span>
                                    <?= ($animal['nom_habitat']) ?>
                                </span>
                            </div>
                            <p class="text-gray-700 leading-relaxed border-b  m-2 p-2"><?= ($animal['description_animal']) ?></p>



                            <p class="text-gray-700 leading-relaxed"> </p>

                            <ul class="space-y-3 text-sm text-gray-700">
                                <li class="flex justify-between items-center"><span class="font-medium">Nom :</span> <span class="italic"><?= ($animal['nom_animal']) ?></span></li>
                                <li class="flex justify-between items-start"><span class="font-medium"> Régime :</span> <span class="w-1/2 text-right"><?= ($animal['alimentation_animal']) ?></span></li>
                                <li class="flex justify-between items-start"><span class="font-medium"> Habitat :</span> <span class="w-1/2 text-right"><?= ($animal['nom_habitat']) ?></span></li>
                                <li class="flex justify-between items-start"><span class="font-medium"> Type de climat :</span> <span class="w-1/2 text-right"><?= ($animal['type_climat']) ?></span></li>
                                <li class="flex justify-between items-start"><span class="font-medium"> zone :</span> <span class="w-1/2 text-right"><?= ($animal['zone_zoo']) ?></span></li>
                                <li class="flex justify-between items-start"><span class="font-medium"> Description d'habitat :</span> <span class="w-1/2 text-right"> </span></li>
                            </ul>
                            <p class="text-gray-700 leading-relaxed"><?= ($animal['description_habitat']) ?></p>
                        </div>



                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer class="bg-[#1b140d] text-white pt-16 pb-8 mt-auto">
        <div class="max-w-[1200px] mx-auto px-4 md:px-10">
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