<?php

namespace controllers;

use controllers\base\ApiController;
use models\CategorieModel;
use models\EmprunterModel;
use models\EmprunteurModel;
use models\RessourceModel;
use utils\Template;

/**
 * Controleur de l'API
 */
class MainApiController extends ApiController
{
    private RessourceModel $ressourceModel;
    private EmprunteurModel $emprunteurModel;
    private CategorieModel $categorieModel;
    private EmprunterModel $emprunterModel;

    public function __construct()
    {
        $this->ressourceModel = new RessourceModel();
        $this->emprunteurModel = new EmprunteurModel();
        $this->emprunterModel = new EmprunterModel();
        $this->categorieModel = new CategorieModel();
    }

    public function swaggerYaml(){
        header('Content-Type: application/yaml');
        header('Content-Disposition: attachment; filename="swagger.yaml"');

        return Template::render("views/apidoc/swagger.yaml", [], false);
    }

    /**
     * Retourne l'ensemble des catégories présentes dans la base de données.
     * @return string JSON contenant l'ensemble des catégories.
     */
    function getCategories(): string
    {
        $categories = $this->categorieModel->getAll();

        if (!$categories) {
            return parent::toJSON([]);
        } else {
            return parent::toJSON($categories);
        }
    }

    /**
     * Retourne tous les lecteurs présents dans la base de données.
     * @return string JSON contenant l'ensemble des lecteurs.
     */
    function getLecteurs(): string
    {
        $lecteurs = $this->emprunteurModel->getAllWithoutPassword();

        if (!$lecteurs) {
            return parent::toJSON([]);
        } else {
            return parent::toJSON($lecteurs);
        }
    }

    /**
     * Retourne toutes les ressources présentes dans la base de données.
     * @return string JSON contenant l'ensemble des ressources.
     */
    function getAllRessources($type = "all"): string
    {
        // Récupération de l'ensemble du catalogue présent dans la base de données
        // TODO: Gérer la pagination

        $ressources = null;

        // Pour l'instant, on ne gère qu'un type de ressource.
        if ($type == "all") {
            $ressources = $this->ressourceModel->getAll();
        }


        if (!$ressources) {
            return parent::toJSON([]);
        } else {
            return parent::toJSON($ressources);
        }
    }

    /**
     * Retourne une liste de ressources aléatoires.
     * @param int $limite (optionnel) Nombre de ressources à retourner.
     * @return string JSON contenant X ressources aléatoires (10 par défaut).
     */
    function getRessourcesRandom(int $limite = 10): string
    {
        $ressources = $this->ressourceModel->getRandomRessource($limite);

        if (!$ressources) {
            return parent::toJSON([]);
        } else {
            return parent::toJSON($ressources);
        }
    }

    function getLastRessources(int $limite = 10): string
    {
        $ressources = $this->ressourceModel->getLastRessource($limite);

        if (!$ressources) {
            return parent::toJSON([]);
        } else {
            return parent::toJSON($ressources);
        }
    }

    

    /**
     * Retourne les 5 ressources les plus empruntées.
     */
    function getRessourcesLesPlusEmpruntees(): string
    {
        $ressources = $this->emprunterModel->getTopEmprunts();

        if (!$ressources) {
            return parent::toJSON([]);
        } else {
            return parent::toJSON($ressources);
        }
    }
}