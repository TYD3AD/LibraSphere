<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Médiathèque</title>
    <link rel="stylesheet" href="/public/style/main.css">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="/public/js/sweetalert2.all.min.js"></script>
    <script src="/public/js/vue.global.prod.js"></script>
    <script>
        // La séquence de touches que vous souhaitez détecter
        const SEQUENCE = ['ArrowUp', "ArrowDown", "ArrowUp", "ArrowDown", "ArrowLeft", "ArrowRight", "ArrowLeft", "ArrowRight", "b", "a"];
        let currentSequence = [];

        // La fonction que vous voulez exécuter
        function action() {
            alert('L\'œuf de pâques a été trouvé !');
        }

        // Fonction de gestion de l'événement de pression de touche
        document.addEventListener('keydown', function(event) {
            const key = event.key;
            if (currentSequence.length < SEQUENCE.length) {
                if (key === SEQUENCE[currentSequence.length]) {
                    currentSequence.push(key);
                    if (currentSequence.length === SEQUENCE.length) {
                        action();
                        currentSequence = [];
                    }
                } else {
                    currentSequence = [];
                }
            } else {
                currentSequence = [];
            }
        });
    </script>
</head>

<body class="bg-[#F2F4F7]">

    <!-- En-tête -->
    <header class="bg-white">
        <nav class="container mx-auto px-2 py-3 flex items-center justify-between">
            <div class="flex flex-row items-center">
                <a href="/" class="flex flex-row items-center text-2xl font-semibold text-gray-800">
                    <img src="/public/images/logo_LibraSphere.png" alt="Logo logo_LibraSphere" class="w-28 mr-4">
                    Médiathèque</a>
            </div>

            <ul class="space-x-4 flex">
                <li><a href="/catalogue/all" class="text-gray-600 hover:text-gray-800">Parcourir les ressources</a></li>
                <li><a href="/horaires" class="text-gray-600 hover:text-gray-800">Horaires</a></li>
                <li><a href="/aPropos" class="text-gray-600 hover:text-gray-800">A propos</a></li>
                <li>
                    <?php if (\utils\SessionHelpers::isLogin()) { ?>
                        <a href="/me" class="bg-indigo-600 text-white hover:bg-indigo-900 font-bold py-3 px-6 rounded-full">
                            Mon compte
                        </a>
                    <?php } else { ?>
                        <a href="/login" class="bg-indigo-600 text-white hover:bg-indigo-900 font-bold py-3 px-6 rounded-full">
                            Se connecter
                        </a>
                    <?php } ?>
                </li>
            </ul>
        </nav>
    </header>
    <div class="min-h-full p-10">