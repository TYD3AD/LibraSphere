<!-- page de modification des informations d'un compte utilisateur -->

<div class="flex flex-row flex-between items-center justify-center px-6 py-8 mx-auto m-10 lg:py-0">
  <div class="bg-white shadow-lg rounded-lg px-6 py-4 mt-50 w-4/12 mb-10 mr-10">
    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl text-center">
      Modifier mes informations
    </h1>
    <form method="post" action="/user/updateUser" class="flex flex-col  ">
      <label for="nom">Nom :</label>
      <input type="text" name="nom" id="nom" value="<?= $user->nomemprunteur ?>" class="m-1 mb-1 p-1 border border-solid border-gray-800 rounded-md" required>

      <label for="prenom">Prénom :</label>
      <input type="text" name="prenom" id="prenom" value="<?= $user->prenomemprunteur ?>" class="m-1 mb-1 p-1 border border-solid border-gray-800 rounded-md" required>

      <label for="email">Email :</label>
      <input type="email" name="email" id="email" value="<?= $user->emailemprunteur ?>" class="m-1 mb-1 p-1 border border-solid border-gray-800 rounded-md" required>

      <label for="telephone">Téléphone :</label>
      <input type="tel" name="telephone" id="telephone" value="<?= $user->telportable ?>" class="m-1 mb-1 p-1 border border-solid border-gray-800 rounded-md" required>

      <label for="etatTel">Visibilité téléphone</label>
      <div>
        <div>
          <input type="radio" name="etatTel" id="etatTelY" value="1" <?php if ($user->etatTel == 1) { ?> checked <?php } ?> class="m-1 mb-1 p-1 border border-solid border-gray-800 rounded-md">
          <label for="etatTelY">Oui</label>
        </div>
        <div>
          <input type="radio" name="etatTel" id="etatTelN" value="0" <?php if ($user->etatTel == 0) { ?> checked <?php } ?> class="m-1 mb-1 p-1 border border-solid border-gray-800 rounded-md">
          <label for="etatTelN">Non</label>
        </div>
      </div>

      <label for="old_password">Mot de passe actuel :</label>
      <input type="password" name="old_password" id="old_password" class="m-1 mb-1 p-1 border border-solid border-gray-800 rounded-md">

      <label for="new_password">Nouveau mot de passe :</label>
      <input type="password" name="new_password" id="new_password" class="m-1 mb-1 p-1 border border-solid border-gray-800 rounded-md">

      <label for="confirm_password">Confirmer le nouveau mot de passe :</label>
      <input type="password" name="confirm_password" id="confirm_password" class="m-1 mb-1 p-1 border border-solid border-gray-800 rounded-md">
      <div class="flex  flex-row justify-around	">
        <a href="/me" class="bg-red-600 text-white hover:bg-red-900 font-bold py-3 px-6 rounded-full text-center w-2/5	">Annuler</a>
        <button type="submit" class="bg-indigo-600 text-white hover:bg-indigo-900 font-bold py-3 px-6 rounded-full w-2/5">
          Sauvegarder
        </button>

      </div>
    </form>
  </div>
  <div class="bg-white shadow-lg rounded-lg px-6 py-4">
    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl text-center mb-5  ">
      Suppression de compte
    </h1>
    <p class="mb-4">La suppression de compte est réversible, et peut être réactivé en contactant le service informatique</p>
    <form id="deleteUser" method="post" action="/user/deleteUser" class="flex flex-col">

      <label for="delete_email">Entrez votre adresse mail :</label>
      <input type="email" name="delete_email" id="delete_email" class="m-1 mb-1 p-1 border border-solid border-gray-800 rounded-md" required>

      <label for="delete_password">Mot de passe :</label>
      <input type="password" name="delete_password" id="delete_password" class="m-1 mb-1 p-1 border border-solid border-gray-800 rounded-md" required>


      <div>
        <input type="checkbox" name="check" id="check" class="m-1 mb-1 p-1 border border-solid border-gray-800 rounded-md" required>
        <label for="check">Je confirme qu'en poursuivant, mon compte sera supprimé</label>
      </div>

      <div class="flex  flex-row justify-around	">
        <button type="submit" class="bg-red-600 text-white hover:bg-red-900 font-bold py-3 px-6 rounded-full w-2/5">
          Supprimer mon compte
        </button>
      </div>
    </form>
  </div>
</div>
<script>
        document.querySelector("#deleteUser").addEventListener("submit", async (e) => {
            e.preventDefault()
            const result = await Swal.fire({
                title: 'Suppresion de compte',
                text: "Voulez-vous vraiment supprimer votre compte ? ",
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