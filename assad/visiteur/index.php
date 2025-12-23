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


    $sql = " select * from  animaux order by rand() limit 2";
    $resultat = $conn->query($sql);

    $array_animaux = array();
    while ($ligne =  $resultat->fetch_assoc())
        array_push($array_animaux, $ligne);
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
    <title>Accueil - Zoo Virtuel ASSAD</title>
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
                        <a class="text-primary text-sm font-bold hover:text-primary transition-colors"
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

    <main class="flex-grow flex flex-col items-center">
        <div id="top" class="w-full max-w-[1200px] px-4 md:px-10 py-6">
            <div class="rounded-3xl overflow-hidden relative min-h-[450px] flex flex-col justify-center items-center text-center p-8 bg-cover bg-center shadow-xl shadow-primary/10"
                style='background-image: linear-gradient(rgba(0, 0, 0, 0.4) 0%, rgba(0, 0, 0, 0.7) 100%), url("https://lh3.googleusercontent.com/aida-public/AB6AXuB7tV0MbXCZTrttbfuFt8CqKgYEiMryvuxkVWJ6WjvseE_KC2bRS8wOCXpRA4lgDfHgikgjgeCdHsMWdoTr4UFYTYVRoaXexOq-BoOXf5Yo4UcENg5bt1enOCEyrAifv40q_DFANZ1CKEoehRrYDWpLP4S40C7IO1NzrxJat8xe6LbEld6MWZxqsFZoxikvEa865GjFKpz8yY8X5kFjlAlJsm2eNUry4Us0zUZHNEz_wQNZStdhBmsEhv7mpEWzSrjunYXj4bxh4v0h");'>
                <span
                    class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/20 backdrop-blur-sm border border-white/30 text-white text-sm font-bold uppercase tracking-wider mb-4">
                    <span class="material-symbols-outlined text-base">rocket_launch</span>
                    Le Zoo Virtuel nouvelle génération
                </span>
                <h1 class="text-white text-4xl md:text-6xl font-black leading-tight tracking-tight mb-4 max-w-4xl drop-shadow-lg">
                    Découvrez les <span class="text-primary">Légendes de l'Afrique</span> en Réalité Virtuelle
                </h1>
                <p class="text-white/90 text-base md:text-lg font-medium max-w-2xl drop-shadow-md mb-8">
                    Explorez la faune africaine, soutenez la conservation et réservez votre visite guidée en direct.
                </p>
                <div class="flex gap-4">
                    <a href="reservation.php"
                        class="h-12 px-6 bg-primary hover:bg-orange-600 text-white font-bold rounded-xl transition-all shadow-lg shadow-orange-500/30 flex items-center gap-2">
                        <span class="material-symbols-outlined">confirmation_number</span>
                        Réserver une Visite
                    </a>
                    <a href="animaux.php"
                        class="h-12 px-6 bg-white hover:bg-gray-100 text-[#1b140d] font-bold rounded-xl transition-all shadow-lg flex items-center gap-2">
                        <span class="material-symbols-outlined">pets</span>
                        Voir tous les Animaux
                    </a>
                </div>
            </div>
        </div>

        <section class="w-full max-w-[1200px] px-4 md:px-10 py-10 mb-8">
            <h2 class="text-3xl font-extrabold text-[#1b140d] mb-4 text-center">Nos Résidents Populaires</h2>
            <p class="text-center text-gray-500 mb-8">Cliquez pour voir les fiches détaillées de nos espèces emblématiques.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php foreach ($array_animaux as $animal) : ?>
                    <div class="bg-white rounded-xl overflow-hidden shadow-lg group flex items-center border border-[#f3ede7]">
                        <img src="<?= ($animal['image_url']) ?>" alt="<?= ($animal['nom_animal']) ?>"
                            class="w-32 h-32 object-cover shrink-0 group-hover:scale-105 transition-transform duration-300" />
                        <div class="p-4 flex-grow">
                            <h3 class="text-xl font-bold text-[#1b140d]"><?= ($animal['nom_animal']) ?></h3>
                            <p class="text-gray-500 text-sm mb-3">Découvrez son habitat et son statut de conservation.</p>
                            <a href="animal_detail.php?id=<?= ($animal['id_animal']) ?>" class="text-primary text-sm font-bold hover:underline">
                                Voir la fiche complète &rarr;
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="text-center mt-8">
                <a href="animaux.php" class="inline-flex items-center justify-center gap-2 px-6 py-3 border border-[#e5e5e5] hover:border-primary text-[#1b140d] hover:text-primary font-bold rounded-xl transition-all bg-white hover:bg-orange-50">
                    Voir la liste complète (<?= count($array_animaux) * 4 ?> animaux)
                    <span class="material-symbols-outlined">arrow_forward</span>
                </a>
            </div>
        </section>

     

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