<div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-[calc(100vh-136px)] lg:py-0 container">

    <div class="flex flex-wrap">
        <!-- Colonne de gauche -->
        <div class="w-full md:w-1/2 px-4">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Créer un compte</h1>
            <p class="text-gray-600 mb-6">Remplissez les informations ci-dessous pour créer votre compte.</p>
            <ul class="list-disc mb-6 pl-6 space-y-2">
                <li>Emprunter des médias</li>
                <li>Accédez à votre historique</li>
                <li>Demander plus de temps avec votre médias</li>
                <li>Accédez à vos emprunts</li>
                <li>Voir vos points de fidélités</li>
            </ul>
            <div>
                <p class="text-blue-500 mb-6">Votre mot de passe doit correspondre à nos règles de sécurité,<br> il doit être composé de :</p>
                <ul class="list-disc mb-6 pl-6 space-y-2">
                    <li id="lenght" class="text-red-600">Minimum 8 caractères</li>
                    <li id="A-Z" class="text-red-600">Minimum 1 lettre majuscule</li>
                    <li id="a-z" class="text-red-600">Minimum 1 lettre minuscule</li>
                    <li id="0-9" class="text-red-600">Minimum 1 chiffre</li>
                    <li id="!!" class="text-red-600">Minimum 1 caractère spécial</li>
                </ul>
            </div>
        </div>

        <!-- Colonne de droite -->
        <div class="w-full md:w-1/2 px-4 mt-6 md:mt-0">
            <div class="bg-white shadow-lg rounded-lg px-6 py-4">

                <!-- Message d'erreur -->

                <?php if (isset($error)) { ?>
                    <div class="max-w-sm bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">Oups ! </strong>
                        <span class="block sm:inline"><?= $error ?></span>
                    </div>
                <?php } unset($error)?>

                <h2 class="text-xl font-semibold text-gray-800 mb-4">Informations personnelles</h2>

                <!-- Formulaire -->
                <form class="max-w-sm" method="post" action="/signup">
                    <div class="mb-4">
                        <label for="nom" class="block text-gray-800 font-semibold mb-2">Nom</label>
                        <input type="text" id="nom" name="nom" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <div class="mb-4">
                        <label for="prenom" class="block text-gray-800 font-semibold mb-2">Prénom</label>
                        <input type="text" id="prenom" name="prenom" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-gray-800 font-semibold mb-2">Email</label>
                        <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-gray-800 font-semibold mb-2">Mot de passe</label>
                        <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 " pattern="(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}" required>
                    </div>



                    <div class="mb-4">
                        <label for="confPassword" class="block text-gray-800 font-semibold mb-2">Confirmez mot de passe</label>
                        <input type="password" id="confPassword" name="confPassword" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <div class="mb-4">
                        <label for="tel" class="block text-gray-800 font-semibold mb-2">Téléphone</label>
                        <input type="tel" id="tel" name="tel" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <div class="mb-4">
                        <label for="etatTel" class="block text-gray-800 font-semibold mb-2">Affichage du Téléphone</label>
                        <input type="radio" id="etatTelN" name="etatTel" value="non" checked>
                        <label for="etatTelN">Non</label><br>
                        <input type="radio" id="etatTelY" name="etatTel" value="oui">
                        <label for="etatTelY">Oui</label><br>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="bg-indigo-600 text-white hover:bg-indigo-900 font-bold py-3 px-6 rounded-full">
                            Créer un compte
                        </button>
                        <hr class="m-5">
                        <p class="text-sm font-light text-gray-500">
                            Vous avez déjà un compte ?
                            <a href="/login" class="font-medium text-primary-600 hover:underline">
                                Connectez-vous
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    // on idique l'input du mot de passe
    var password = document.getElementById("password")
    // on indique les li de la liste des règles
    var lenght = document.getElementById("lenght")
    var A_Z = document.getElementById("A-Z")
    var a_z = document.getElementById("a-z")
    var zero_nine = document.getElementById("0-9")
    var special = document.getElementById("!!")

    // on indique les regex
    var regex_lenght = new RegExp("^(?=.{8,})")
    var regex_A_Z = new RegExp("^(?=.*?[A-Z])")
    var regex_a_z = new RegExp("^(?=.*?[a-z])")
    var regex_zero_nine = new RegExp("^(?=.*?[0-9])")
    var regex_special = new RegExp("^(?=.*?[#?!@$%^&*-])")

    // on indique les fonctions
    function check_lenght() {
        // si le mot de passe est supérieur ou égal à 8 caractères on met la li en vert
        if (regex_lenght.test(password.value)) {
            lenght.style.color = 'green'
        } else {
            lenght.style.color = 'red'
        }
    }

    function check_A_Z() {
        if (regex_A_Z.test(password.value)) {
            A_Z.style.color = 'green'
        } else {
            A_Z.style.color = 'red'
        }
    }

    function check_a_z() {
        if (regex_a_z.test(password.value)) {
            a_z.style.color = 'green'
        } else {
            a_z.style.color = 'red'
        }
    }

    function check_zero_nine() {
        if (regex_zero_nine.test(password.value)) {
            zero_nine.style.color = 'green'
        } else {
            zero_nine.style.color = 'red'
        }
    }

    function check_special() {
        if (regex_special.test(password.value)) {
            special.style.color = 'green'
        } else {
            special.style.color = 'red'
        }
    }

    // on ajoute les écouteurs d'évènements
    password.addEventListener("keyup", check_lenght)
    password.addEventListener("keyup", check_A_Z)
    password.addEventListener("keyup", check_a_z)
    password.addEventListener("keyup", check_zero_nine)
    password.addEventListener("keyup", check_special)


        
    
</script>