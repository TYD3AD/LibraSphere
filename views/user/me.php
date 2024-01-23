<div class="container mx-auto py-8 min-h-[calc(100vh-136px)]">
    <div class="me flex flex-col">
        <?php if (isset($_SESSION["Erreur"])) {
            echo '<div class="bg-red-600 text-white font-bold py-3 px-6 rounded-full mb-5 ml-5">';
            echo $_SESSION["Erreur"];
            unset($_SESSION["Erreur"]);
            echo '</div>';
        } ?>
        <?php if (isset($_SESSION["validation"])) {
            echo '<div class="bg-green-600 text-white font-bold py-3 px-6 rounded-full mb-5 ml-5">';
            echo $_SESSION["validation"];
            unset($_SESSION["validation"]);
            echo '</div>';
        } ?>

        <div class="flex flex-wrap">
            <!-- Colonne de gauche -->
            <div class="w-full md:w-1/3 px-4">
                <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg px-6 py-4">
                    <div class="flex items-center justify-center mb-4">
                        <img src="<?= \utils\Gravatar::get_gravatar($user->emailemprunteur) ?>" alt="Photo de profil" class="rounded-full h-32 w-32">
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">👋 <?= $user->prenomemprunteur ?></h1>
                    <div class="mb-4">
                        <h2 class="text-xl font-semibold text-gray-800 mb-2">Informations personnelles</h2>
                        <p class="text-gray-600 mb-2"><span class="font-semibold">Email:</span> <?= $user->emailemprunteur ?></p>
                        <p class="text-gray-600 mb-2"><span class="font-semibold">Nom:</span> <?= $user->nomemprunteur ?></p>
                        <p class="text-gray-600 mb-2"><span class="font-semibold">Prénom:</span> <?= $user->prenomemprunteur ?></p>
                        <?php if ($user->etatTel == 1) { ?>
                            <p class="text-gray-600 mb-2"><span class="font-semibold">Téléphone:</span> <?= $user->telportable ?></p>
                        <?php } ?>
                    </div>

                    <div class="flex flex-col pt-0 p-5 text-center">
                        <a class="bg-green-600 text-white hover:bg-green-900 font-bold py-3 px-6 rounded-full" href="/user/dlDataUser">Télécharger vos données</a>
                        <div class="flex flex-row justify-around mt-3">
                            <a class="bg-blue-600 text-white hover:bg-blue-900 font-bold py-3 px-6 rounded-full" href="/user/updateUser">Éditer le profil</a>
                            <a class="bg-red-600 text-white hover:bg-red-900 font-bold py-3 px-6 rounded-full" href="/logout">Déconnexion</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonne de droite -->
            <div class="w-full md:w-2/3 px-4 mt-6 md:mt-0">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Mes emprunts</h1>

                <?php if (!$emprunts) { ?>
                    <!-- Message si aucun emprunt -->
                    <div class="bg-white shadow-lg rounded-lg px-6 py-4 mt-5">
                        <p class="text-gray-600 mb-2">Vous n'avez aucun emprunt en cours.</p>
                    </div>
                <?php } else { ?>
                    <!-- Tableau des emprunts en retard -->




                    <?php
                    $enCours = array();
                    $enRetard = array();

                    foreach ($emprunts as $emprunt) {
                        $finCalcul = date_format(date_create($emprunt->dateretour), "Y/m/d");
                        $date = date("Y/m/d");
                        if ($finCalcul < $date) {
                            $enRetard[] = $emprunt; // Ajoute l'emprunt au tableau $enRetard
                        } else {
                            $enCours[] = $emprunt; // Ajoute l'emprunt au tableau $enCours
                        }
                    }
                    if (count($enRetard) >= 1) {
                        echo '<h2 class="text-xl font-bold text-gray-900 mb-2 ml-5">Emprunts en retard</h2>';
                    } ?>
                    <div class="flex flex-wrap sm:grid-cols-2 md:grid-cols-3 gap-4 mt-5 ml-5">
                        <?php


                        foreach ($enRetard as $emprunt) {
                            $debut = date_format(date_create($emprunt->datedebutemprunt), "d/m/Y");
                            $fin = date_format(date_create($emprunt->dateretour), "d/m/Y");
                            $frais = 0;
                            // calcule le nombre de jours entre la date de retour et la date actuelle:
                            $dateR = new DateTime($emprunt->dateretour);
                            $date = new DateTime(date("Y-m-d"));
                            $interval = $dateR->diff($date);
                            $nbJours = $interval->format('%a') + 1;
                        ?>

                            <div class="bg-red-200 shadow-lg rounded-lg px-6 py-4">
                                <h2 class="text-xl font-semibold text-gray-800 mb-2"><?= $emprunt->titre ?></h2>
                                <p class="text-gray-600 mb-2">Type: <span class="font-semibold"><?= $emprunt->libellecategorie ?></span></p>
                                <p class="text-gray-600 mb-2">
                                    Date d'emprunt:
                                    <span class="font-semibold"><?= $debut ?></span>
                                </p>
                                <p class="text-red-600 mb-2">
                                    Date de retour prévue:
                                    <span class="font-semibold"><?= $fin ?></span>
                                </p>
                                <p>Frais de retard :
                                    <span class="font-semibold"><?= $nbJours ?> €</span>
                                </p>

                            </div>
                        <?php } ?>



                    </div>
                    <!-- 
    
 -->

                    <!-- Tableau des emprunts en cours -->

                    <h2 class="text-xl font-bold text-gray-900 mb-2 ml-5 mt-5">Mes emprunts en cours</h2>
                    <div class="flex flex-wrap gap-4 mt-5 ml-5">

                        <!-- Liste des emprunts -->
                        <?php foreach ($enCours as $emprunt) {
                            $debut = date_format(date_create($emprunt->datedebutemprunt), "d/m/Y");
                            $fin = date_format(date_create($emprunt->dateretour), "d/m/Y");

                        ?>
                            <div class="flex flex-row sm:grid-cols-2 md:grid-cols-3 gap-4 mt-5 bg-white shadow-lg rounded-lg px-6 py-4">
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-800 mb-2"><?= $emprunt->titre ?></h2>
                                    <p class="text-gray-600 mb-2">Type: <span class="font-semibold"><?= $emprunt->libellecategorie ?></span></p>
                                    <p class="text-gray-600 mb-2">
                                        Date d'emprunt:
                                        <span class="font-semibold"><?= $debut ?></span>
                                    </p>
                                    <p class="text-grey-600 mb-2">
                                        Date de retour prévue:
                                        <span class="font-semibold"><?= $fin ?></span>
                                    </p>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                <?php } ?>
            </div>
        </div>
    </div>
</div>