<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Confirmation de votre emprunt</title>
</head>

<body>
    <h1>Bonjour <?= $user ?></h1>
    <p>
        Voici le récapitulatif de votre emprunt : <br>
    </p>
    <ul>
        <strong>Ressource empruntée : </strong> <?= $ressource ?> <br>
        <strong>Date d'emprunt : </strong> <?= $dateEmprunt ?> <br>
        <strong>Date de retour : </strong> <?= $dateRetour ?> <br>
    </ul>

    <p>
        En cas de problème, veuillez contacter la médiathèque au 01 23 45 67 89.
    </p>

    <p>
        A bientôt !
    </p>
</body>

</html>