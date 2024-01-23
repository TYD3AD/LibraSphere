<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Votre nouveau compte</title>
</head>
<body>
    <h1>Bienvenue sur le site de la mediathèque</h1>
    <p>
        Votre compte a bien été créé. Voici votre identifiant de connexion :
    </p>
    <ul>
        <li><strong>Identifiant : </strong> <?= $email ?></li>
    </ul>

    <p>
        <a href="http://<?= $url ?>" target="_blank">Pour finaliser votre inscription, merci de cliquer sur le lien.</a>
    </p>

    <p>
        A bientôt sur notre site !
    </p>
</body>
</html>