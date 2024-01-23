<?php
namespace controllers;

use controllers\base\WebController;
use utils\Template;

/**
 * Controleur de la documentation de l'API
 */
class ApiDocController extends WebController
{
    function liste(): string
    {
        return Template::render("views/apidoc/liste.php", array());
    }
}