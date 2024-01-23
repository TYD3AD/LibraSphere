<?php use utils\SessionHelpers; ?>

<div class="container mx-auto py-8 min-h-[calc(100vh-136px)]">
    <?php
    if (isset($_SESSION['validation'])) { ?>
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">&#128161; Merci ! </strong>
            <span class="block sm:inline"><?= $_SESSION['validation'] ?></span>
        </div>
    <?php }
    unset($_SESSION['validation']); ?>
    <div class="flex flex-wrap">
        <!-- Colonne de gauche -->
        <div class="w-full md:w-1/2 px-4">
            <img src="/public/assets/<?= $ressource->image ?>" alt="Image du livre" class="mb-4 rounded-lg object-cover m-auto h-[70vh]">
        </div>

        <!-- Colonne de droite -->
        <div class="w-full md:w-1/2 px-4 mt-6 md:mt-0">
            <div class="bg-white shadow-lg rounded-lg px-6 py-4">
                <h1 class="text-3xl font-bold text-gray-900 mb-4"><?= $ressource->titre ?></h1>
                <p class="text-gray-600 mb-2">Année de publication: <span class="font-semibold"><?= $ressource->anneesortie ?></span></p>
                <p class="text-gray-600 mb-2">Langue : <span class="font-semibold"><?= $ressource->langue ?></span></p>
                <p class="text-gray-600 mb-2">ISBN : <span class="font-semibold"><?= $ressource->isbn ?></span></p>
                <p class="text-gray-600 mb-2">Description: <span class="font-semibold"><?= $ressource->description ?></p>
                <p class="text-gray-600 mb-2">Auteur(s) : <span class="font-semibold"><?php foreach ($auteurs as $auteur) {
                                                                                            echo $auteur . ' ';
                                                                                        } ?></span></p>

                <!-- Bouton pour emprunter un exemplaire -->
                <?php if ($exemplaire) { ?>
                    <?php if (SessionHelpers::isConnected()) {
                        if (!$emprunte) {
                            if ($indispo == false) { ?>
                                <form id="exemplaire" method="post" class="text-center pt-5 pb-3" action="/catalogue/emprunter">
                                    <input type="hidden" name="idRessource" value="<?= $ressource->idressource ?>">
                                    <input type="hidden" name="idExemplaire" value="<?= $exemplaire->idexemplaire ?>">
                                    <button type="submit" class="bg-indigo-600 text-white hover:bg-indigo-900 font-bold py-3 px-6 rounded-full">
                                        Emprunter
                                    </button>
                                    <?php ?>
                                </form>
                <?php }else {
                                echo '<p class="text-red-600 mb-2">Aucun exemplaire de disponible actuellement</p>';
                            }
                        
                        } else {
                            echo '<p class="text-green-600 mb-2">Vous empruntez déjà cette ressource</p>';
                        }
                    } else {
                        echo '<br><br><p class="text-red-600 mb-2">Vous devez être connecté pour emprunter un exemplaire</p>';
                    }
                } ?>
            </div>
            <div>
                <!-- ESPACE COMMENTAIRES -->
                <div class="bg-white shadow-lg rounded-lg px-6 py-4 mt-6">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">Espace commentaires</h1>
                    <?php if (SessionHelpers::isConnected()) {
                        if ($aEmprunte) {
                            if (!$aCommente) { ?>
                                <form method="post" action="/catalogue/commenter">
                                    <input type="hidden" name="idRessource" value="<?= $ressource->idressource ?>">
                                    <input type="hidden" name="rating" value="0">
                                    <textarea name="commentaire" class="w-full border border-gray-300 rounded-lg p-2 mb-4" placeholder="Votre commentaire"></textarea>
                                    <div class="stars">
                                        <i class="star stargrey fas fa-star" data-index="0"></i>
                                        <i class="star stargrey fas fa-star" data-index="1"></i>
                                        <i class="star stargrey fas fa-star" data-index="2"></i>
                                        <i class="star stargrey fas fa-star" data-index="3"></i>
                                        <i class="star stargrey fas fa-star" data-index="4"></i>
                                    </div>
                                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                                    <script type="text/javascript" src="/public/js/rate.js"></script>
                                    <button type="submit" class="bg-indigo-600 text-white hover:bg-indigo-900 font-bold py-3 px-6 rounded-full">
                                        Publier
                                    </button>
                                </form>
                            <?php } else {
                                echo '<p class="text-green-600 mb-2">Vous avez déjà donné votre avis sur cette ressource</p>';
                            }
                        } else { ?>
                            <p class="text-blue-600 mb-2">&#128161; Vous devez avoir emprunté cette ressource pour pouvoir donner votre avis</p>
                        <?php }
                    } else { ?>
                        <p class="text-blue-600 mb-2">&#128161; Vous devez être connecté pour donner votre avis</p>
                    <?php
                    }
                    if ($commentaires != null) {
                        foreach ($commentaires as $commentaire) {

                            echo '<div class="bg-gray-100 rounded-lg p-4 mb-4">';
                            echo '<div class="flex items-center mb-4">';
                            echo '<img src="' . \utils\Gravatar::get_gravatar($commentaire->emailemprunteur) . '" alt="Photo de profil" class="rounded-full h-32 w-32">';
                            echo '<div class="flex flex-col ml-4">';
                            echo '<h2 class="text-xl font-bold text-gray-900 mb-4">' . $commentaire->prenomemprunteur . '</h2>';
                            echo '<p class="text-gray-600 mb-2">Publié le ' . $commentaire->date_commentaire . '</p>';
                            // affichage des étoiles
                            echo '<p class="text-gray-600 mb-2">Evaluation : ';
                            for ($i = 0; $i < $commentaire->evaluation; $i++) {
                                echo '<i class="star yellow fas fa-star"></i>';
                            }
                            for ($i = 0; $i < 5 - $commentaire->evaluation; $i++) {
                                echo '<i class="star stargrey fas fa-star"></i>';
                            }
                            echo '</div>';
                            echo '</div>';
                            echo '<p class="text-gray-600 mb-2">' . $commentaire->commentaire . '</p>';

                            echo '</div>';
                        }
                    } else {
                        echo '<p class="mt-4 text-gray-600 mb-2">Soyez le premier à donner votre avis !</p>';
                    } ?>
                </div>
                <!-- ESPACE COMMENTAIRES -->
            </div>
        </div>
    </div>

    <script>
        document.querySelector("#exemplaire").addEventListener("submit", async (e) => {
            e.preventDefault()
            const result = await Swal.fire({
                title: 'Confirmer l\'emprunt ?',
                text: "Souhaitez-vous emprunter cette ressource ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui',
                cancelButtonText: 'Non'
            })
            if (result.isConfirmed) {
                e.target.submit()
            }
        });
    </script>