<?php

namespace models;

use models\base\SQL;

class RessourceModel extends SQL
{
    public function __construct()
    {
        parent::__construct('ressource', 'idressource');
    }

    public function getAll(): array
    {
        $sql = 'SELECT * FROM ressource r LEFT JOIN categorie c ON c.idcategorie = r.idcategorie JOIN exemplaire e ON r.idressource=e.idressource where r.archive = 0 AND iddispo = 1 GROUP BY r.idressource';
        // SELECT * FROM ressource r LEFT JOIN categorie c ON c.idcategorie = r.idcategorie where r.archive = 0
        $stmt = parent::getPdo()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getAllExemplaires(): array
    {
        $sql = 'SELECT * FROM exemplaire e';
        $stmt = parent::getPdo()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getRandomRessource($limit = 3)
    {
        $sql = 'SELECT * FROM ressource r LEFT JOIN categorie c ON c.idcategorie = r.idcategorie where r.archive = 0 ORDER BY RAND() LIMIT ?';
        $stmt = parent::getPdo()->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getLastRessource($limit = 3)
    {
        // sélectionne les ressources non archivées et les exemplaires non archivés et ne met pas les doublons
        $sql = 'SELECT DISTINCT * FROM ressource LEFT JOIN categorie ON categorie.idcategorie = ressource.idcategorie INNER JOIN exemplaire ON ressource.idressource = exemplaire.idressource where exemplaire.archive = 0 and ressource.archive = 0 GROUP BY ressource.idressource ORDER BY dateentree desc LIMIT ?';
        $stmt = parent::getPdo()->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getCategories()
    {
        $sql = 'SELECT * FROM categorie';
        $stmt = parent::getPdo()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getCommentaires($id_ressource)
    {

        $sql = 'SELECT id_commentaire, id_ressource, commentaire, date_commentaire, evaluation, prenomemprunteur, emailemprunteur FROM commentaire c INNER JOIN emprunteur e ON c.id_emprunteur=e.idemprunteur where c.id_ressource = ? and c.etat_commentaire = 1 ORDER BY date_commentaire DESC';
        $stmt = parent::getPdo()->prepare($sql);
        $stmt->execute([$id_ressource]);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getVilles()
    {
        try {
            $sql = 'SELECT * FROM mediatheque';
            $stmt = parent::getPdo()->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getExemplaires()
    {
        try {
            $sql = 'SELECT * FROM exemplaire e INNER JOIN ressource r ON e.idressource = r.idressource INNER JOIN categorie c ON r.idcategorie = c.idcategorie INNER JOIN mediatheque m ON e.idville = m.idmediatheque where e.archive = 0 and r.archive = 0';
            $stmt = parent::getPdo()->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getFiltre($ville_filtre)
    {
        if ($ville_filtre == 0) {
            $filtre = '';
        } else {
            $filtre = 'and m.id_mediatheque = ' . $ville_filtre . '';
        }

        try {
            $sql = 'SELECT DISTINCT r.*, c.* FROM ressource r INNER JOIN categorie c ON r.idcategorie = c.idcategorie INNER JOIN exemplaire e ON r.idressource = e.idressource INNER JOIN mediatheque m ON e.id_mediatheque = m.id_mediatheque where e.archive = 0 and e.iddispo = 1 and r.archive = 0 ' . $filtre . '';
            $stmt = parent::getPdo()->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getLibelleCategories()
    {
        $sql = 'SELECT libellecategorie FROM categorie';
        $stmt = parent::getPdo()->prepare($sql);
        $stmt->execute();

        $categories = array();
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $categories[] = $row['libellecategorie'];
        }
        return $categories;
    }

    public function getExemplaireVille()
    {
        try {
            $sql = 'SELECT DISTINCT e.idressource, v.libelle_ville FROM exemplaire e INNER JOIN mediatheque m ON e.id_mediatheque = m.id_mediatheque INNER JOIN ville v ON m.id_ville = v.id_ville WHERE e.archive = 0';
            $stmt = parent::getPdo()->prepare($sql);
            $stmt->execute();
            $ressourceMediatheque = $stmt->fetchAll(\PDO::FETCH_OBJ);
            // Organiser le tableau résultat en tableau associatif
            $resultatAssociatif = array();
            foreach ($ressourceMediatheque as $row) {
                $idRessource = $row->idressource;
                $libelleVille = $row->libelle_ville;

                if (!isset($resultatAssociatif[$idRessource])) {
                    $resultatAssociatif[$idRessource] = array();
                }

                $resultatAssociatif[$idRessource][] = $libelleVille;
            }
            /* var_dump($resultatAssociatif);
            die(); */
            return $resultatAssociatif;
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }
}
