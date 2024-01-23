<?php

namespace models;

use models\base\SQL;
use utils\SessionHelpers;

class EmprunterModel extends SQL
{
    public function __construct()
    {
        parent::__construct('emprunter', 'idemprunter');
    }

    /**
     * Déclare un emprunt dans la base de données.
     * @param $idRessource identifiant de la ressource empruntée (idressource)
     * @param $idExemplaire identifiant de l'exemplaire emprunté (idexemplaire)
     * @param $idemprunteur identifiant de l'emprunteur (lecteur)
     * @return bool true si l'emprunt a été déclaré, false sinon.
     */
    public function declarerEmprunt($idRessource, $idExemplaire, $idemprunteur): bool
    {
        
        try {
            $sql = 'INSERT INTO emprunter (idressource, idexemplaire, idemprunteur, datedebutemprunt, dureeemprunt, dateretour, etatemprunt) VALUES (?, ?, ?, NOW(), 30, DATE_ADD(NOW(), INTERVAL 1 MONTH), ?)';
            $stmt = parent::getPdo()->prepare($sql);
            $stmt->execute([$idRessource, $idExemplaire, $idemprunteur, 2]);
            
            

            $sql = 'UPDATE exemplaire SET iddispo = 2 WHERE idressource = ? AND idexemplaire = ?';
            $stmt = parent::getPdo()->prepare($sql);
            $stmt->execute([$idRessource, $idExemplaire]);

            return $stmt->execute();
        } catch (\PDOException $e) {
            var_dump($e->getMessage());
            die();
            return false;
        }
    }

    /**
     * Récupère les emprunts d'un emprunteur en fonction de son id (idemprunteur)
     * @param $idemprunteur
     * @return bool
     */
    public function getEmprunts($idemprunteur): bool|array
    {
        try {
            $sql = 'SELECT * FROM emprunter LEFT JOIN ressource ON emprunter.idressource = ressource.idressource LEFT JOIN categorie ON categorie.idcategorie = ressource.idcategorie WHERE idemprunteur = ? AND etatemprunt = 2 OR etatemprunt = 4';
            $stmt = parent::getPdo()->prepare($sql);
            $stmt->execute([$idemprunteur]);
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Retourne les 5 ressources les plus empruntées.
     * @return array|false
     */
    public function getTopEmprunts(): array
    {
        try {
            $sql = 'SELECT COUNT(emprunter.idressource) AS nbEmprunt, titre, emprunter.idressource FROM emprunter LEFT JOIN ressource ON emprunter.idressource = ressource.idressource GROUP BY emprunter.idressource ORDER BY nbEmprunt DESC LIMIT 5';
            $stmt = parent::getPdo()->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return [];
        }
    }

    public function getAEmprunte($id): bool|array
    {
        if (!SessionHelpers::isLogin()) {
            return false;
        } else {
            $iduser = SessionHelpers::getConnected()->idemprunteur;

            try {
                $sql = 'SELECT * FROM emprunter WHERE idressource = ? and idemprunteur = ?';
                $stmt = parent::getPdo()->prepare($sql);
                $stmt->execute([$id, $iduser]);
                return $stmt->fetchAll(\PDO::FETCH_OBJ);
            } catch (\PDOException $e) {
                return false;
            }
        }
    }

    public function getNbEmpruntEnCours($user){

        try {
            $sql = 'SELECT COUNT(emprunter.idressource) AS nbEmprunt FROM emprunter WHERE idemprunteur = ? AND etatemprunt = 2';
            $stmt = parent::getPdo()->prepare($sql);
            $stmt->execute([$user]);
            return $stmt->fetch(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return [];
        }
    }
}
