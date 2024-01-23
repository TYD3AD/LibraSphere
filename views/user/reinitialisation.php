<div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-[calc(100vh-136px)] lg:py-0">
    <div class="bg-white shadow-lg rounded-lg px-6 py-4">
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
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">

            <?php if (isset($_SESSION['error'])) { ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Oups ! </strong>
                    <span class="block sm:inline"><?= $_SESSION['error'] ?></span>
                </div>
            <?php }
            unset($_SESSION['error']); ?>
            <?php if (isset($_SESSION['data'])) { ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Oups ! </strong>
                    <span class="block sm:inline"><?= $_SESSION['data'] ?></span>
                </div>
            <?php }
            unset($_SESSION['data']); ?>


            <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                Reinitialisation de votre mot de passe
            </h1>
            <form class="space-y-4 md:space-y-6" action="/reinitMdp/<?=$uuid?>" method="post">
                <input type="hidden" value="<?=$uuid?>">
                <div>
                    <label for="email" class="block text-gray-800 font-semibold mb-2">Nouveau mot de passe</label>
                    <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required>
                </div>
                <div>
                    <label for="email" class="block text-gray-800 font-semibold mb-2">Confirmez nouveau mot de passe</label>
                    <input type="password" name="confPassword" id="confPassword" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required>
                </div>

                <div class="text-center">
                    <button type="submit" class="bg-indigo-600 text-white hover:bg-indigo-900 font-bold py-3 px-6 rounded-full">
                        Reinitialiser
                    </button>
                </div>
            </form>
            <?php
            ?>
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