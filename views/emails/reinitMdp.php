<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Reinitialisez votre mot de passe</title>
</head>
<body>
    <h1>Bonjour <?= $email ?></h1>
    <p>
        Nous avons reçu une demande de réinitialisation de votre mot de passe.<br>
        Si vous n'êtes pas à l'origine de cette demande, contactez le support technique. <br><br>

        Si vous êtes à l'origine de cette demande, merci de cliquer sur le lien ci-dessous pour réinitialiser votre mot de passe. <br>
        Vous disposez de 30 minutes pour le réinitialiser. Passé ce délai, vous devrez refaire une demande de réinitialisation.
    </p>
    
    <p>
        <a href="http://<?= $url ?>" target="_blank">Pour finaliser votre inscription, merci de cliquer sur le lien.</a>
    </p>

    <p>
        A bientôt sur notre site !
    </p>
</body>
</html>