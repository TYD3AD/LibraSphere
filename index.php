<?php

use routes\base\Router;
use utils\SessionHelpers;

include("autoload.php"); // Pour les classes internes au projet.
include("vendor/autoload.php"); // Pour les librairies externes. (PHPMailer, etc.)

/*
 * Permet l'utilisation du serveur PHP interne et l'affichage des contenus static.
 */
if (php_sapi_name() == 'cli-server') {
    if (str_starts_with($_SERVER["REQUEST_URI"], '/public/')) {
        return false;
    }
}

class EntryPoint
{
    private Router $router;
    private SessionHelpers $sessionHelpers;

    function __construct()
    {
        // Démarrage de la session (pour les variables globales).
        $this->sessionHelpers = new SessionHelpers();

        // Création du routeur et chargement de la page demandée.
        $this->router = new Router();
        $this->router->LoadRequestedPath(); // Charge la page demandée (en fonction de l'URL).
    }
}

// Lancement de l'application.
new EntryPoint();