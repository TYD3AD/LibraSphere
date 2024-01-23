<?php
namespace models;

use models\base\SQL;

class AdministrateurModel extends SQL
{
    public function __construct()
    {
        parent::__construct('administrateur', 'idadministrateur');
    }
    
    public function getData(){
        try{
            $sql = 'SELECT * FROM emprunteur';
            $stmt = parent::getPdo()->prepare($sql);
            $stmt->execute();
            $dataEmprunteur = $stmt->fetchAll(\PDO::FETCH_OBJ);
        }
        catch(\Exception $e){
            // erreur requête emprunteur
            die($e->getMessage());
        }

        try{
            $sql = 'SELECT * FROM ressource';
            $stmt = parent::getPdo()->prepare($sql);
            $stmt->execute();
            $dataRessource = $stmt->fetchAll(\PDO::FETCH_OBJ);
        }
        catch(\Exception $e){
            // erreur requête ressource
            die($e->getMessage());
        }

        try{
            $sql = 'SELECT * FROM exemplaire';
            $stmt = parent::getPdo()->prepare($sql);
            $stmt->execute();
            $dataExemplaire = $stmt->fetchAll(\PDO::FETCH_OBJ);
        }
        catch(\Exception $e){
            // erreur requête exemplaire
            die($e->getMessage());
        }

        try{
            $sql = 'SELECT * FROM emprunter';
            $stmt = parent::getPdo()->prepare($sql);
            $stmt->execute();
            $dataEmprunter = $stmt->fetchAll(\PDO::FETCH_OBJ);
        }
        catch(\Exception $e){
            // erreur requête exemplaire
            die($e->getMessage());
        }

        return array(
            'emprunteur' => $dataEmprunteur,
            'ressource' => $dataRessource,
            'exemplaire' => $dataExemplaire,
            'emprunter' => $dataEmprunter
        );
        
    }
}