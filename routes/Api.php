<?php

namespace routes;

use controllers\MainApiController;
use routes\base\Route;
use utils\Template;

class Api
{
    function __construct()
    {
        $mainApiController = new MainApiController();

        // Documentation SWAGGER de l'API
        Route::Add('/api/swagger', [$mainApiController, 'swaggerYaml']);

        // Retourne la liste des ressources les plus empruntées
        Route::Add('/api/le-top', [$mainApiController, 'getRessourcesLesPlusEmpruntees']);

        // Retourne toutes les catégories
        Route::Add('/api/categories', [$mainApiController, 'getCategories']);

        // Retourne tous les lecteurs
        Route::Add('/api/lecteurs', [$mainApiController, 'getLecteurs']);

        // Retourne X ressources aléatoires, API utilisée pour la page d'accueil
        Route::Add('/api/catalogue/random/{limite}', [$mainApiController, 'getRessourcesRandom']);
        Route::Add('/api/catalogue/last/{limite}', [$mainApiController, 'getLastRessources']);

        // Retourne toutes les ressources
        Route::Add('/api/catalogue/{type}', [$mainApiController, 'getAllRessources']);
    }
}

