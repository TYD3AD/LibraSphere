<div class="text-white mx-auto py-8 min-h-[calc(100vh-136px)] bg-[#131C27] mx-auto px-6 p-20 md:px-8 lg:p-20 xl:p-30">
    <div class="max-w-screen-lg mx-auto">
        <h1 class="text-3xl font-bold text-white text-center mb-4">👋 Bienvenue dans l'espace développeur 🧑‍💻</h1>

        <p class="text-white">
            La médiathèque met à disposition de toutes et tous des jeux de données produits dans le cadre de ses
            missions de
            service public.
            <br/><br/>
            Ces données sont enrichies progressivement en fonction d’une part de la collecte des données issues des
            services
            publics et des partenaires, et d’autre part de la demande des citoyens
        </p>

        <div class="grid grid-cols-2 md:grid-cols-3 p-5 gap-5">
            <a href="/api/le-top" target="_blank"
               class="bg-red-600 text-white hover:bg-red-900 font-bold py-3 px-6 rounded-full">
                Les plus empruntées
            </a>

            <a href="/api/catalogue/all" target="_blank"
               class="bg-red-600 text-white hover:bg-red-900 font-bold py-3 px-6 rounded-full">
                Les ressources
            </a>

            <a href="/api/catalogue/random/10" target="_blank"
               class="bg-red-600 text-white hover:bg-red-900 font-bold py-3 px-6 rounded-full">
                10 ressources aléatoires
            </a>

            <a href="/api/categories" target="_blank"
               class="bg-red-600 text-white hover:bg-red-900 font-bold py-3 px-6 rounded-full">
                Les catégories
            </a>

            <a href="/api/lecteurs" target="_blank"
               class="bg-red-600 text-white hover:bg-red-900 font-bold py-3 px-6 rounded-full">
                Les lecteurs
            </a>

            <!--
            Lien vers la documentation Swagger, pour simplifier, on utilise un gist github.
            Mais le YAML est également dans le projet, lien /api/swagger.

            En utilisant le gist, il est possible de charger le YAML dans l'éditeur Swagger en ligne. C'est juste par praticité.
            -->
            <a href="https://editor.swagger.io/?url=https://gist.githubusercontent.com/c4software/919e053cac0fa27f79ce8c3a1f7af8c4/raw/8c4fc0dffe16597ab0cea575eeb308be42c77f03/swagger.yaml"
               target="_blank"
               class="bg-green-600 text-white hover:bg-green-900 font-bold py-3 px-6 rounded-full">
                Documentation Swagger →
            </a>
        </div>

        <hr class="mb-10">

        <div class="md:flex">

            <div>
                <h1 class="text-2xl font-bold text-gray-900 mb-4">Comment utiliser nos API ?</h1>
                <p class="text-white">
                    Nos API sont accessibles à tous et ne nécessitent pas d'authentification.
                    <br><br>
                    Vous pouvez utiliser nos API de différentes manières :
                </p>

                <ul class="list-disc mb-6 pl-6 pt-5 space-y-2">
                    <li>Ajax</li>
                    <li>PHP</li>
                    <li>Flutter</li>
                    <li>...</li>
                </ul>
            </div>


            <div class="pl-5">
                <h1 class="text-2xl font-bold text-white mb-4">Qui utilise nos API ?</h1>

                <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 gap-3">
                    <div class="bg-blue-90 border-gradient-blue-90 p-10 rounded-lg text-white">
                        <h3 class="text-xl font-semibold text-white mb-2">Media Mobile</h3>
                        <p class="text-white">L'application mobile permettant d'accéder au catalogue</p>
                    </div>

                    <div class="bg-blue-90 border-gradient-blue-90 p-10 rounded-lg text-white">
                        <h3 class="text-xl font-semibold text-white mb-2">Mediavore</h3>
                        <p class="text-white">Réseau social permettant la mise en relation des lecteurs.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>