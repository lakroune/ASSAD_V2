<?php



require_once '../Class/Admin.php';
require_once '../Class/Guide.php';
require_once '../Class/Visiteur.php';
require_once '../Class/utilisateur.php';


if (!Admin::isConnected("admin")) {
    header("location: ../../connexion.php?message=access_denied");
    exit();
}

$array_utilisateurs = Utilisateur::getAllUtilisateurs();

if ($_SERVER['REQUEST_METHOD'] === "POST" and isset($_POST['id_affiche']) and !empty($_POST['id_affiche'])) {

    $info_utilisateur = new Utilisateur();
    $info_utilisateur->getUtilisateur($_POST['id_affiche']);
}



function get_role_badge($role)
{
    if ($role == "guide") return '<span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300">Guide</span>';
    elseif ($role == "visiteur") return '<span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300">Visiteur</span>';
    else return  '<span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-gray-100 text-gray-700 dark:bg-gray-700/40 dark:text-gray-300">Inconnu</span>';
}

//for visiteur
function get_status_indicator_visiteur($status)
{
    if ($status == 1) return   '<span class="    text-green-500 inline-block mr-1" title="Actif">Actif</span>';
    elseif ($status == 0) return   '<span class="  text-red-500 inline-block mr-1" title="Suspendu">Suspendu</span>';
    else return '';
}
//for guide
function get_is_approuver_guide($status)
{
    if ($status == 1) return   '<span class="    text-green-500 inline-block mr-1" title="Approuver">Approuver</span>';
    elseif ($status == 0) return   '<span class="  text-red-500 inline-block mr-1" title="non approuver">non approuver</span>';
    else return '';
}

function get_status_indicator_color($status)
{
    return match ($status) {
        '1' => '<span class="w-2 h-2 rounded-full bg-green-500 inline-block mr-1" title="Actif"></span>',
        '0' => '<span class="w-2 h-2 rounded-full bg-red-500 inline-block mr-1" title="Suspendu"></span>',
        default => '',
    };
}

?>

<!DOCTYPE html>
<html class="light" lang="fr">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Gestion des Utilisateurs - ASSAD Admin</title>
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
                        href="./admin_animaux.php">
                        <span
                            class="material-symbols-outlined text-2xl group-hover:text-primary transition-colors">pets</span>
                        <span class="text-sm font-medium">Gestion Animaux</span>
                    </a>
                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-text-secondary-light dark:text-text-secondary-dark hover:bg-primary/10 hover:text-primary transition-colors group"
                        href="./admin_habitats.php">
                        <span
                            class="material-symbols-outlined text-2xl group-hover:text-primary transition-colors">nature</span>
                        <span class="text-sm font-medium">Habitats</span>
                    </a>

                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-primary text-white shadow-md shadow-primary/20"
                        href="admin_users.php">
                        <span
                            class="material-symbols-outlined text-2xl fill-current">group</span>
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
                        <h1 class="text-3xl font-black tracking-tight text-text-light dark:text-text-dark">Gestion des Utilisateurs</h1>
                        <p
                            class="text-text-secondary-light dark:text-text-secondary-dark text-sm font-medium flex items-center gap-1">
                            Contrôle total sur les comptes Guides et Visiteurs
                        </p>
                    </div>

                </div>
            </div>
            </div>
        </header>
        <div class="flex-1 overflow-y-auto bg-background-light dark:bg-background-dark">
            <div class="max-w-7xl mx-auto w-full px-6 py-8 flex flex-col gap-8">

                <div class="flex flex-col md:flex-row justify-between items-center gap-4 p-4 bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
                    <div class="flex flex-wrap gap-3">
                        <button class="px-4 py-2 text-sm font-bold rounded-lg bg-primary text-white shadow-sm">Tous (<?= count($array_utilisateurs) ?>)</button>
                        <button class="px-4 py-2 text-sm font-medium rounded-lg bg-gray-100 dark:bg-gray-800 text-text-secondary-light dark:text-text-secondary-dark hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">Guides (<?php echo count(array_filter($array_utilisateurs, fn($u) => $u->getRoleUtilisateur() == 'guide')) ?>)</button>
                        <button class="px-4 py-2 text-sm font-medium rounded-lg bg-gray-100 dark:bg-gray-800 text-text-secondary-light dark:text-text-secondary-dark hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">Visiteurs (<?= count(array_filter($array_utilisateurs, fn($u) => $u->getRoleUtilisateur() == 'visiteur')) ?>)</button>
                        <!-- <button class="px-4 py-2 text-sm font-medium rounded-lg bg-gray-100 dark:bg-gray-800 text-text-secondary-light dark:text-text-secondary-dark hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">Actif (<?php //$visiteur= new Visiteur();   echo count(array_filter($array_utilisateurs, fn($u) => ($visiteur->getVisteur($u->getIdUtilisateur()))->getStatusVisiteur() === '1')) 
                                                                                                                                                                                                                                                ?>)</button> -->
                        <!-- <button class="px-4 py-2 text-sm font-medium rounded-lg bg-gray-100 dark:bg-gray-800 text-text-secondary-light dark:text-text-secondary-dark hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">Suspendu (<?php // count(array_filter($array_utilisateurs, fn($u) => $u['statut_utilisateur'] === '0')) 
                                                                                                                                                                                                                                                ?>)</button> -->
                        <!-- <button class="px-4 py-2 text-sm font-medium rounded-lg bg-gray-100 dark:bg-gray-800 text-text-secondary-light dark:text-text-secondary-dark hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">Approuver (<?php // count(array_filter($array_utilisateurs, fn($u) => $u['Approuver_utilisateur'] === '0')) 
                                                                                                                                                                                                                                                    ?>)</button> -->
                    </div>
                    <!-- <div class="relative w-full md:w-auto">
                         <span
                             class="material-symbols-outlined absolute left-2.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm">search</span>
                         <input
                             class="pl-8 pr-3 py-1.5 rounded-lg border-gray-200 dark:border-gray-700 bg-white dark:bg-surface-dark text-sm w-full md:w-64 focus:ring-primary/20 focus:border-primary"
                             placeholder="Rechercher par nom ou email..." type="text" />
                     </div> -->
                </div>

                <div
                    class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-xl border border-gray-100 dark:border-gray-800 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm whitespace-nowrap">
                            <thead
                                class="bg-gray-50/50 dark:bg-gray-800/30 border-b border-gray-100 dark:border-gray-800">
                                <tr>
                                    <th
                                        class="px-6 py-3 font-semibold text-text-secondary-light dark:text-text-secondary-dark">
                                        Utilisateur</th>
                                    <th
                                        class="px-6 py-3 font-semibold text-text-secondary-light dark:text-text-secondary-dark">
                                        Rôle</th>
                                    <th
                                        class="px-6 py-3 font-semibold text-text-secondary-light dark:text-text-secondary-dark">
                                        Statut</th>
                                    <th
                                        class="px-6 py-3 font-semibold text-text-secondary-light dark:text-text-secondary-dark">
                                        Origine</th>
                                    <th
                                        class="px-6 py-3 font-semibold text-text-secondary-light dark:text-text-secondary-dark text-right">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody id="card-user" class="divide-y divide-gray-100 dark:divide-gray-800">
                                <?php foreach ($array_utilisateurs as $user) : ?>
                                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors group">
                                        <td class="px-6 py-3">
                                            <div class="flex items-center gap-3">
                                                <div class="flex flex-col">
                                                    <span class="font-bold text-text-light dark:text-text-dark"><?= ($user->getNomUtilisateur()) ?></span>
                                                    <span class="text-xs text-text-secondary-light truncate"><?= ($user->getEmail()) ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-3">
                                            <?= get_role_badge($user->getRoleUtilisateur()) ?>
                                        </td>
                                        <td class="px-6 py-3">
                                            <?php
                                            $visiteur = new Visiteur();
                                            $guide = new Guide();
                                            if ($user->getRoleUtilisateur() == 'visiteur') {
                                                $visiteur->getVisiteur($user->getIdUtilisateur());
                                                echo get_status_indicator_color($visiteur->getStatusVisiteur());
                                            } else 
                                            if ($user->getRoleUtilisateur() == 'guide') {
                                                $guide->getGuide($user->getIdUtilisateur());
                                                echo get_status_indicator_color($guide->getIsApprouver());
                                            }
                                            ?>
                                            <span class="text-xs text-gray-500 capitalize">
                                                <?php
                                                if ($user->getRoleUtilisateur() == 'visiteur')
                                                    get_status_indicator_visiteur(($visiteur->getStatusVisiteur()));
                                                elseif ($user->getRoleUtilisateur() == 'guide')
                                                    // int tosring  
                                                    get_is_approuver_guide(($guide->getIsApprouver()));

                                                ?></span>
                                            </span>
                                        </td>
                                        <td class="px-6 py-3 text-text-secondary-light">
                                            <?= ($user->getPaysUtilisateur()) ?>
                                        </td>
                                        <td class="px-6 py-3 text-right">
                                            <div
                                                class="flex items-center justify-end gap-1">
                                                <!-- voici le button quand click sur il  ybano les info fi pop  -->
                                                <form action="" method="POST" class="visibility">
                                                    <input type="hidden" name="id_affiche" value="<?= $user->getIdUtilisateur() ?>">
                                                    <button
                                                        class="p-1.5 rounded hover:bg-gray-100 dark:hover:bg-gray-700 text-blue-500"
                                                        title="Voir/Éditer le profil">
                                                        <span class="material-symbols-outlined text-lg">visibility</span>
                                                    </button>
                                                </form>
                                                <?php if ($visiteur && $user->getRoleUtilisateur() == 'visiteur' && $visiteur->getStatusVisiteur() == 1): ?>
                                                    <form action="" method="POST" class="lock">
                                                        <input type="hidden" name="id_suspendu" value="<?= $user->getIdUtilisateur() ?>">
                                                        <button type="button"
                                                            class="p-1.5 rounded hover:bg-gray-100 dark:hover:bg-gray-700 text-yellow-500"
                                                            title="Suspendre">
                                                            <span class="material-symbols-outlined text-lg">lock</span>
                                                        </button>
                                                    </form>
                                                <?php elseif ($visiteur && $user->getRoleUtilisateur() == 'visiteur' && $visiteur->getStatusVisiteur() == 0): ?>
                                                    <form action="" method="POST" class="lock_open">
                                                        <input type="hidden" name="id_activer" value="<?= $user->getIdUtilisateur() ?>">
                                                        <button type="button"
                                                            class="p-1.5 rounded hover:bg-gray-100 dark:hover:bg-gray-700 text-green-500"
                                                            title="Activer">
                                                            <span class="material-symbols-outlined text-lg">lock_open</span>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>

                                                <?php if ($guide && $user->getRoleUtilisateur() === 'guide' && $guide->getIsApprouver() == 0): ?>
                                                    <form action="" method="POST" class="Approuver">
                                                        <input type="hidden" name="id_Approuver_utilisateur" value="<?= $user->getIdUtilisateur() ?>">
                                                        <button type="button"
                                                            class="p-1.5 rounded hover:bg-gray-100 dark:hover:bg-gray-700 text-red-500"
                                                            title="Approuver ">
                                                            <span class="material-symbols-outlined text-lg">check_circle</span>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>




                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php if (empty($array_utilisateurs)): ?>
                            <div class="p-6 text-center text-text-secondary-light dark:text-text-secondary-dark text-sm">
                                Aucun utilisateur trouvé.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <?php if (isset($info_utilisateur)): ?>
        <div id="userModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">

            <div class="bg-surface-light dark:bg-surface-dark w-full max-w-lg rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-800 overflow-hidden transform transition-all">

                <div class="px-6 py-4 flex justify-between items-center bg-primary/10 border-b border-primary/20">
                    <h3 class="text-xl font-bold flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">account_circle</span>
                        Détails de l'utilisateur
                    </h3>
                    <button onclick="closeModal()" class="hover:bg-gray-200 dark:hover:bg-gray-700 rounded-full p-1 transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <div class="p-6">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="h-20 w-20 rounded-full bg-gradient-to-tr from-primary to-orange-300 flex items-center justify-center text-white text-3xl font-bold shadow-lg">
                            <?= strtoupper(substr($info_utilisateur->getNomUtilisateur(), 0, 1)) ?>
                        </div>
                        <div>
                            <h4 class="text-2xl font-black text-text-light dark:text-text-dark leading-tight">
                                <?= ($info_utilisateur->getNomUtilisateur()) ?>
                            </h4>
                            <div class="flex gap-2 mt-1">
                                <?= get_role_badge($info_utilisateur->getRoleUtilisateur()) ?>
                                <span class="text-xs bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded-full flex items-center gap-1">
                                    ID: #<?= $info_utilisateur->getIdUtilisateur() ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-y-6 gap-x-4">

                        <div class="col-span-2 sm:col-span-1">
                            <p class="text-xs text-text-secondary-light dark:text-text-secondary-dark font-bold uppercase tracking-wider">Email</p>
                            <p class="flex items-center gap-2 font-medium truncate">
                                <span class="material-symbols-outlined text-sm">mail</span>
                                <?= ($info_utilisateur->getEmail()) ?>
                            </p>
                        </div>

                        <div class="col-span-2 sm:col-span-1">
                            <p class="text-xs text-text-secondary-light dark:text-text-secondary-dark font-bold uppercase tracking-wider">Localisation</p>
                            <p class="flex items-center gap-2 font-medium">
                                <span class="material-symbols-outlined text-sm">location_on</span>
                                <?= ($info_utilisateur->getPaysUtilisateur() ?? 'Non défini') ?>
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-text-secondary-light dark:text-text-secondary-dark font-bold uppercase tracking-wider">État du compte</p>
                            <div class="mt-1">
                                <?php
                                if ($info_utilisateur->getRoleUtilisateur() == "visiteur") {
                                    $visitor = new Visiteur();
                                    $visitor->getVisiteur($info_utilisateur->getIdUtilisateur());
                                    get_status_indicator_color($visitor->getStatusVisiteur());
                                } else
                                    get_status_indicator_color(1);

                                ?>
                                <span class="font-bold">
                                    <?php
                                    if ($info_utilisateur->getRoleUtilisateur() == "visiteur") {
                                        $visitor = new Visiteur();
                                        $visitor->getVisiteur($info_utilisateur->getIdUtilisateur());
                                        if ($visitor->getStatusVisiteur() == 1)
                                            echo "Actif";
                                        else
                                            echo "Suspendu";
                                    }
                                    ?>

                            </div>
                        </div>

                        <div>
                            <p class="text-xs text-text-secondary-light dark:text-text-secondary-dark font-bold uppercase tracking-wider">Approbation</p>
                            <p class="mt-1 font-bold <?php
                                                        if ($info_utilisateur->getRoleUtilisateur() == "guide") {
                                                            $guide1 = new Guide();
                                                            $guide1->getGuide($info_utilisateur->getIdUtilisateur());
                                                            if ($guide1->getIsApprouver() == 1)
                                                                echo "text-green-500";
                                                            else
                                                                echo "text-orange-500";
                                                        } else  echo "text-green-500";



                                                        ?>  flex items-center gap-2">
                                <?php
                                if ($info_utilisateur->getRoleUtilisateur() == "guide") {
                                    $guide1 = new Guide();
                                    $guide1->getGuide($info_utilisateur->getIdUtilisateur());
                                    if ($guide1->getIsApprouver() == 1)
                                        echo "✓ Approuvé' ";
                                    else
                                        echo "⌛ En attente";
                                } else  echo "✓ Approuvé' ";
                                ?>

                            </p>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/40 flex justify-end gap-3">
                    <button onclick="closeModal()" class="px-5 py-2 text-sm font-bold text-gray-500 hover:text-gray-700">Fermer</button>
                    <button class="px-5 py-2 text-sm font-bold bg-primary text-white rounded-lg shadow-md hover:bg-primary-dark transition-all">
                        Modifier le profil
                    </button>
                </div>
            </div>
        </div>

        <script>
            function closeModal() {
                document.getElementById('userModal').classList.add('hidden');
            }
        </script>
    <?php endif; ?>

    <script>
        document.getElementById('card-user').addEventListener('click', (e) => {
            const ele_click = e.target;
            if (ele_click.tagName === 'SPAN') {
                const form = ele_click.closest('form.lock_open');
                if (form)
                    if (confirm("Voulez-vous vraiment  Suspender cet utilisateur "))
                        form.submit();
            }
        });
        document.getElementById('card-user').addEventListener('click', (e) => {
            const ele_click = e.target;
            if (ele_click.tagName === 'SPAN') {
                const form = ele_click.closest('form.lock');
                if (form)
                    if (confirm("Voulez-vous vraiment activer cet utilisateur"))
                        form.submit();
            }
        });
        document.getElementById('card-user').addEventListener('click', (e) => {
            const ele_click = e.target;
            if (ele_click.tagName === 'SPAN') {
                const form = ele_click.closest('form.Approuver');
                if (form)
                    if (confirm("Voulez-vous vraiment Approuver ce guide"))
                        form.submit();
            }
        });

        function closeModal() {
            const modal = document.getElementById('userModal');
            if (modal) {
                modal.classList.add('hidden');

            }
        }


        window.onclick = function(event) {
            const modal = document.getElementById('userModal');
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
</body>

</html>