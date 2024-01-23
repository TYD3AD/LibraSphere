<?php

namespace controllers;

use utils\Template;
use models\EmprunterModel;
use models\RessourceModel;
use models\ExemplaireModel;
use models\CommentaireModel;
use controllers\base\WebController;

class CatalogueController extends WebController
{

    private RessourceModel $ressourceModel;
    private ExemplaireModel $exemplaireModel;
    private EmprunterModel $emprunterModel;
    private CommentaireModel $commentaireModel;

    function __construct()
    {
        $this->ressourceModel = new RessourceModel();
        $this->exemplaireModel = new ExemplaireModel();
        $this->emprunterModel = new EmprunterModel();
        $this->commentaireModel = new CommentaireModel();
    }

    /**
     * Affiche la liste des ressources.
     * @param string $type
     * @return string
     */
    function liste(string $type): string
    {
        $villes = $this->ressourceModel->getVilles();

        $exemplaireMediatheque = $this->ressourceModel->getExemplaireVille();
        $catalogue = $this->ressourceModel->getAll();


        if ($type == "all") {
            // Récupération de l'ensemble du catalogue
            $categories = $this->ressourceModel->getCategories();
            unset($_SESSION['filtre']);
            unset($_SESSION['ville']);
            // Affichage de la page à l'utilisateur
            return Template::render("views/catalogue/liste.php", array("titre" => "Ensemble du catalogue", "catalogue" => $catalogue, "categories" => $categories, "villes" => $villes, "exemplaireMediatheque" => $exemplaireMediatheque));
        } else {
            if ($type == "filter") {
                if (isset($_GET['ville']) && $_GET['ville'] == 0 && !isset($_GET['categorie'])) {
                    unset($_SESSION['filtre']);
                    unset($_SESSION['ville']);
                    return $this->redirect("/catalogue/all");
                }

                $categories = $this->ressourceModel->getCategories();
                $LibelleCategorie = $this->ressourceModel->getLibelleCategories();
                $filtre = $_GET['categorie'] ?? $LibelleCategorie;
                // si on a un ou plusieurs filtres, on les met dans $_SESSION['filtre']
                isset($_GET['categorie']) ? $_SESSION['filtre'] = $_GET['categorie'] : null;
                $ville_filtre = $_GET['ville'];
                isset($_GET['ville']) ? $_SESSION['ville'] = $_GET['ville'] : null;
                $catalogueFiltre = array();
                $catalogueFiltreParVille = $this->ressourceModel->getFiltre($ville_filtre);

                // on vérifie si $catalogueFiltreParVille est vide ou non
                if ($catalogueFiltreParVille == null) {
                    $catalogueFiltre = false;
                } else {
                    foreach ($catalogueFiltreParVille as $ressource) {

                        if (in_array($ressource->libellecategorie, $filtre)) {
                            array_push($catalogueFiltre, $ressource);
                        }
                    }
                }

                return Template::render("views/catalogue/liste.php", array("titre" => "Ensemble du catalogue", "catalogue" => $catalogueFiltre, "categories" => $categories, "villes" => $villes, "exemplaireMediatheque" => $exemplaireMediatheque));
            } else {
                unset($_SESSION['filtre']);
                unset($_SESSION['ville']);
                return $this->redirect("/");
            }
        }
    }

    /**
     * Affiche le détail d'une ressource.
     * @param int $id
     * @return string
     */
    function detail(int $id): string
    {
        // Récupération de la ressource
        $ressource = $this->ressourceModel->getOne($id) ?: $this->redirect("/");

        // Récupération de ou des auteur(s) de la ressource
        $auteur = $this->ressourceModel->getAuthor($id);
        // Récupération des exemplaires de la ressource
        $exemplaires = $this->exemplaireModel->getByRessource($id);
        // Récupération des commentaires de la ressource
        $commentaires = $this->ressourceModel->getCommentaires($id);
        // Récupère les emprunts de l'utilisateur de la ressource pour vérification
        $aEmprunte = false;
        $aEmprunte = $this->emprunterModel->getAEmprunte($id);
        // Récupère les commentaires de l'utilisateur de la ressource pour vérification
        $aCommente = $this->commentaireModel->getACommente($id) ? true : false;


        // on met les auteurs dans un tableau
        $auteurs = array();
        foreach ($auteur as $a) {
            array_push($auteurs, $a->libelle_auteur);
        }

        $exemplaire = null;
        // Si on en trouve, on prend le premier.
        if ($exemplaires && sizeof($exemplaires) > 0) {
            $exemplaire = $exemplaires[0];

            // Si le premier exemplaire est emprunté, on en cherche un autre.
            if ($exemplaire && $exemplaire->iddispo != 1) {
                foreach ($exemplaires as $e) {
                    if ($e->iddispo == 1) {
                        $exemplaire = $e;
                    }
                }
            }

            // Si on en trouve aucun on met $indispo à true.
            $indispo = ($exemplaire == null) ?? true;

            // Si le dernier exemplaire est emprunté, on met $indispo à true.
            $indispo = ($exemplaire->iddispo != 1) ? true : false;
        } else {
            $indispo = true;
        }

        $emprunte = false;
        if ($aEmprunte) {
            foreach ($aEmprunte as $emprunt) {
                $emprunte = $emprunt->etatemprunt == 2 ? true : false;
            }
        }

        



        return Template::render("views/catalogue/detail.php", array("ressource" => $ressource, "exemplaire" => $exemplaire, "commentaires" => $commentaires, "aEmprunte" => $aEmprunte, "aCommente" => $aCommente, "emprunte" => $emprunte, "auteurs" => $auteurs, "indispo" => $indispo));
    }
}
