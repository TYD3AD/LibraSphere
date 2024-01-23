<section class="min-h-[calc(100vh-136px)]">

    <?php if (isset($_SESSION['ErreurCompte'])) {
        echo '<div class="bg-red-600 text-white font-bold py-3 px-6 rounded-full mb-5 ml-5">';
        echo $_SESSION['ErreurCompte'];
        unset($_SESSION['ErreurCompte']);
        echo '</div>';
    }
    if (isset($_SESSION['Erreur'])) {
        echo '<div class="bg-red-600 text-white font-bold py-3 px-6 rounded-full mb-5 ml-5">';
        echo $_SESSION['Erreur'];
        unset($_SESSION['Erreur']);
        echo '</div>';
    }
    if (isset($_SESSION['Success'])) {
        echo '<div class="bg-green-600 text-white font-bold py-3 px-6 rounded-full mb-5 ml-5">';
        echo $_SESSION['Success'];
        unset($_SESSION['Success']);
        echo '</div>';
    }
    ?>

    <!-- Bannière principale -->
    <section class="bg-gradient-to-r from-blue-500 to-indigo-600">
        <div class="container mx-auto px-4 py-16">
            <div class="max-w-xl mx-auto text-center">
                <h1 class="text-5xl font-bold text-white mb-6">Bienvenue à la médiathèque</h1>
                <p class="text-xl text-white">Découvrez notre vaste collection de livres, films et musique.</p>
                <div class="mt-8">
                    <a href="/catalogue/all" class="bg-white text-indigo-600 hover:bg-indigo-600 hover:text-white font-bold py-3 px-6 rounded-full">
                        Parcourir les ressources
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Contenu principal -->
    <main class="container mx-auto px-4 py-8">

        <h2 class="text-3xl font-bold text-gray-800 mb-4">
            Nos dernières ressources
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-7 gap-8 container mx-auto" id="app">

            <!-- On boucle sur les ressources -->
            <!-- Le :href=… permet de définir le lien vers lequel on sera redirigé au clic -->
            <!-- Le : signifie que l'élément sera géré par VueJS -->
            <a v-for="r in ressources" :href="`/catalogue/detail/${r.idressource}`" class="bg-white rounded-lg shadow-lg">

                <!-- On affiche l'image de la ressource (:src=…).  -->
                <!--  le : signifie que l'élément sera géré par VueJS -->
                
                <img loading="lazy" :src="`/public/assets/${r.image ? r.image : 'default_media.png'}`" class="w-full h-64 object-cover object-center rounded-t-lg">

                <!-- On affiche le titre et la catégorie de la ressource -->
                <!-- via la syntaxe {{ … }} qui permet d'insérer le contenu d'une variable dans du HTML -->
                <!-- C'est une possibilité offerte par VueJS -->
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2 truncate" :title="r.titre">{{ r.titre }}</h3>
                    <div class="w-fit flex justify-center items-center font-medium py-1 px-2 bg-white rounded-full text-blue-700 bg-blue-100 border border-blue-300 ">
                        <div class="text-xs font-normal leading-none max-w-full flex-initial">
                            {{ r.libellecategorie }}
                        </div>
                    </div>
                </div>
            </a>

        </div>

        <h2 class="text-3xl font-bold text-gray-800 mb-4 mt-10">
            On sait pas quoi choisir ?
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-7 gap-8 container mx-auto" id="rand">

            <!-- On boucle sur les ressources -->
            <!-- Le :href=… permet de définir le lien vers lequel on sera redirigé au clic -->
            <!-- Le : signifie que l'élément sera géré par VueJS -->
            <a v-for="r in ressources" :href="`/catalogue/detail/${r.idressource}`" class="bg-white rounded-lg shadow-lg">

                <!-- On affiche l'image de la ressource (:src=…).  -->
                <!--  le : signifie que l'élément sera géré par VueJS -->
                <img loading="lazy" :src="`/public/assets/${r.image ? r.image : 'default_media.png'}`" class="w-full h-64 object-cover object-center rounded-t-lg">

                <!-- On affiche le titre et la catégorie de la ressource -->
                <!-- via la syntaxe {{ … }} qui permet d'insérer le contenu d'une variable dans du HTML -->
                <!-- C'est une possibilité offerte par VueJS -->
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2 truncate" :title="r.titre">{{ r.titre }}</h3>
                    <div class="w-fit flex justify-center items-center font-medium py-1 px-2 bg-white rounded-full text-blue-700 bg-blue-100 border border-blue-300 ">
                        <div class="text-xs font-normal leading-none max-w-full flex-initial">
                            {{ r.libellecategorie }}
                        </div>
                    </div>
                </div>
            </a>

            <div class="hidden lg:block self-center cursor-pointer w-fit" v-if="ressources.length > 0">
                <!-- On ajoute un événement au clic sur le SVG. -->
                <svg @click="getRessources()" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                </svg>
            </div>

        </div>
    </main>
</section>

<script>
    const {
        createApp,
        ref
    } = Vue

    /*
     * Pour rendre dynamique le contenu de la page, on va utiliser Vue.js.
     * Vue.js est un framework JavaScript qui permet de créer des applications web.
     * Il permet de créer des composants réutilisables.
     *
     * Nous pourrions utiliser jQuery pour rendre dynamique le contenu de la page, mais c'est ancien. Et, il faut
     * l'avouer, VueJS est tellement mieux.
     *
     * Pour vous aider à comprendre le fonctionnement, voici un exemple d'appel Ajax et de composant réactif
     * avec VueJS.
     *
     * Documentation : https://fr.vuejs.org/guide/introduction.html
     */

    // Création de l'application Vue, createApp est une fonction qui prend en paramètre un objet.
    createApp({
        setup() {
            // La méthode setup() est appelée avant le rendu du composant.
            // C'est-à-dire avant que la page ne soit interprété.
            // On peut donc y définir des variables qui seront utilisées dans le template.

            // On déclare une variable ressources qui sera utilisée dans le template.
            // C'est une variable réactive, c'est-à-dire que si on la modifie, le template sera mis à jour.
            const ressources = ref([]);

            // Fonction qui permet de récupérer les ressources.
            // La fonction fera un appel Ajax à l'API pour récupérer les ressources.
            // Une fois les ressources récupérées, on met à jour la variable ressources.
            function getRessources() {
                fetch('/api/catalogue/last/6') // Appel Ajax à l'API en utilisant la fonction fetch.
                    .then(res => res.json()) // Conversion la réponse en JSON (objet JavaScript).
                    .then(data => ressources.value = data) // Mise à jour de la variable ressources (variable réactive).
            }

            // On appelle la fonction pour récupérer les ressources.
            getRessources();

            // La fonction setInterval permet d'appeler une fonction à intervalle régulier.
            // Ici, on appelle la fonction getRessources toutes les 1 minute.
            // Cela permet de mettre à jour les ressources toutes les 1 minute.
            setInterval(() => {
                getRessources();
            }, 60000); // On appelle la fonction toutes les 1 minute.

            // On retourne les variables et fonctions qui seront utilisables dans le template.
            // ressources : variable réactive qui contient les ressources (donc des livres, films ou musiques).
            //              - C'est un tableau d'objets. Chaque objet représente une ressource.
            //              - Chaque objet contient les propriétés suivantes : idressource, titre, image, libellecategorie.
            //              - Utilisable dans le template via {{ ressources[0].titre }} par exemple, ou via une boucle v-for.
            //              - Exemple de boucle v-for : <div v-for="r in ressources">{{ r.titre }}</div>
            //              - Documentation : https://fr.vuejs.org/v2/guide/list.html
            // getRessources : fonction qui permet de récupérer les ressources (utilisée dans le template via le @click).
            return {
                ressources,
                getRessources
            }
        }
    }).mount('#app') // On monte l'application Vue sur l'élément HTML qui a l'id "app", c'est-à-dire la div dans laquelle on a écrit le template.

    createApp({
        setup() {
            // La méthode setup() est appelée avant le rendu du composant.
            // C'est-à-dire avant que la page ne soit interprété.
            // On peut donc y définir des variables qui seront utilisées dans le template.

            // On déclare une variable ressources qui sera utilisée dans le template.
            // C'est une variable réactive, c'est-à-dire que si on la modifie, le template sera mis à jour.
            const ressources = ref([]);

            // Fonction qui permet de récupérer les ressources.
            // La fonction fera un appel Ajax à l'API pour récupérer les ressources.
            // Une fois les ressources récupérées, on met à jour la variable ressources.
            function getRessources() {
                fetch('/api/catalogue/random/6') // Appel Ajax à l'API en utilisant la fonction fetch.
                    .then(res => res.json()) // Conversion la réponse en JSON (objet JavaScript).
                    .then(data => ressources.value = data) // Mise à jour de la variable ressources (variable réactive).
            }

            // On appelle la fonction pour récupérer les ressources.
            getRessources();

            // La fonction setInterval permet d'appeler une fonction à intervalle régulier.
            // Ici, on appelle la fonction getRessources toutes les 1 minute.
            // Cela permet de mettre à jour les ressources toutes les 1 minute.
            setInterval(() => {
                getRessources();
            }, 60000); // On appelle la fonction toutes les 1 minute.

            // On retourne les variables et fonctions qui seront utilisables dans le template.
            // ressources : variable réactive qui contient les ressources (donc des livres, films ou musiques).
            //              - C'est un tableau d'objets. Chaque objet représente une ressource.
            //              - Chaque objet contient les propriétés suivantes : idressource, titre, image, libellecategorie.
            //              - Utilisable dans le template via {{ ressources[0].titre }} par exemple, ou via une boucle v-for.
            //              - Exemple de boucle v-for : <div v-for="r in ressources">{{ r.titre }}</div>
            //              - Documentation : https://fr.vuejs.org/v2/guide/list.html
            // getRessources : fonction qui permet de récupérer les ressources (utilisée dans le template via le @click).
            return {
                ressources,
                getRessources
            }
        }
    }).mount('#rand') // On monte l'application Vue sur l'élément HTML qui a l'id "app", c'est-à-dire la div dans laquelle on a écrit le template.
</script>