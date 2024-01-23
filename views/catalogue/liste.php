<?php  /* var_dump($exemplaireMediatheque[70]); die(); */   ?>
<div class="container mx-auto py-8 min-h-[calc(100vh-136px)]">
    <h2 class="text-3xl font-bold text-gray-800 mb-4"><?= strip_tags($titre) ?></h2>
    <div class="flex flex-column">


        <div class="m-4 w-52">
            <form id="formFiltre" action="/catalogue/filter" method="GET" class="flex flex-col">
                <!-- Liste des médiathèque -->
                <label for="ville" class="font-bold">Ville</label>
                <select name="ville" id="ville" class="border border-gray-300 rounded-md p-1 mb-2">
                    <option value="0">Toutes les médiathèques</option>
                    <?php
                    foreach ($villes as $ville) {
                        if (isset($_SESSION['ville'])) {
                            if ($ville->id_mediatheque == $_SESSION['ville']) {
                                $selected = 'selected';
                            } else {
                                $selected = '';
                            };
                        } else {
                            $selected = '';
                        };
                        echo '<option value="' . strip_tags($ville->id_mediatheque) . '" ' . $selected . '>' . strip_tags($ville->libelle_mediatheque) . '</option>';
                    } ?>
                </select>

                <?php
                foreach ($categories as $categorie) {
                    if (isset($_SESSION['filtre'])) {
                        if (in_array($categorie->libellecategorie, $_SESSION['filtre'])) {
                            $checked = 'checked';
                        } else {
                            $checked = '';
                        };
                    } else {
                        $checked = '';
                    };
                    echo '<div>';
                    echo '<input type="checkbox" name="categorie[]" id="' . strip_tags($categorie->libellecategorie) . '" value="' . strip_tags($categorie->libellecategorie) . '" class="mr-1"' . $checked . '>';
                    echo '<label for="' . strip_tags($categorie->libellecategorie) . '" class="hover:font-bold">' . strip_tags($categorie->libellecategorie) . '</label>';
                    echo '</div>';
                } ?>
                <input type="submit" value="Filtrer" class="bg-blue-600 text-white hover:bg-blue-900 font-bold py-1 px-2 rounded-full mb-2 mt-3 ">
                <a href="/catalogue/all" class="bg-red-600 text-white hover:bg-blue-900 font-bold py-1 px-2 rounded-full mb-6 text-center">Réinitialiser</a>
            </form>
            <script>
                // on vérifie si les cases sont cochées ou non, si oui on met le texte en gras
                const checkboxes = document.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(function(checkbox) {
                    const label = document.querySelector('label[for="' + checkbox.id + '"]');
                    if (checkbox.checked) {
                        label.style.fontWeight = 'bold';
                    } else {
                        label.style.fontWeight = 'normal';
                    }
                });

                document.addEventListener('DOMContentLoaded', function() {
                    const checkboxes = document.querySelectorAll('input[type="checkbox"]');

                    checkboxes.forEach(function(checkbox) {
                        checkbox.addEventListener('change', function() {
                            const label = document.querySelector('label[for="' + this.id + '"]');

                            if (this.checked) {
                                label.style.fontWeight = 'bold';
                            } else {
                                label.style.fontWeight = 'normal';
                            }
                        });
                    });
                });
            </script>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8 container mx-auto">
            <?php if ($catalogue != false) {
                foreach ($catalogue as $ressource) {
                    // Vérifier si l'image existe
                    if ($ressource->image == null || $ressource->image == "") {
                        // Utiliser une image par défaut si l'image n'existe pas
                        $image_url = "default_media.png";
                    }
                    else {
                        $image_url = $ressource->image;
                    }
            ?>

                    <a href="/catalogue/detail/<?= strip_tags($ressource->idressource) ?>" class="bg-white rounded-lg shadow-lg">
                        <img loading="lazy" src="/public/assets/<?= strip_tags($image_url) ?>" alt="<?= htmlspecialchars($ressource->titre) ?>" class="w-full h-64 object-cover object-center rounded-t-lg">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2 truncate"><?= strip_tags($ressource->titre) ?></h3>
                            <div class="w-fit flex justify-center items-center font-medium py-1 px-2 bg-white rounded-full text-blue-700 bg-blue-100 border border-blue-300 ">
                                <div class="text-xs font-normal leading-none max-w-full flex-initial">
                                    <?= strip_tags($ressource->libellecategorie) ?>

                                </div>
                            </div>


                            <?php
                            if (isset($exemplaireMediatheque[$ressource->idressource])) {
                                foreach ($exemplaireMediatheque[$ressource->idressource] as $idRessource => $libelleVille) {
                                    echo '<div class="w-fit flex justify-center items-center font-medium py-1 px-2 bg-white rounded-full text-blue-700 bg-blue-100 border border-blue-300 ">';
                                    echo '<div class="text-xs font-normal leading-none max-w-full flex-initial">';
                                    echo strip_tags($libelleVille);
                                    echo '</div>';
                                    echo '</div>';
                                }
                            } else {
                                echo '<div class="w-fit flex justify-center items-center font-medium py-1 px-2 bg-white rounded-full text-blue-700 bg-blue-100 border border-blue-300 ">';
                                echo '<div class="text-xs font-normal leading-none max-w-full flex-initial">';
                                echo 'Aucun exemplaire disponible';
                                echo '</div>';
                                echo '</div>';
                            }
                            ?>
                        </div>
                    </a>

                <?php }
            } else { ?><p class=" text-red-600 mb-2">
                    Aucun résultat pour votre recherche.
                </p> <?php } ?>
        </div>
    </div>
</div>