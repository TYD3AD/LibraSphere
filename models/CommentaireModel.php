<?php
namespace models;

use models\base\SQL;
use utils\SessionHelpers;

class CommentaireModel extends SQL
{
    public function __construct()
    {
        parent::__construct('categorie', 'idcategorie');
    }

    public function getACommente($id_ressource){
        
        if(SessionHelpers::isConnected()){
            try{
                $id_user = SessionHelpers::getConnected()->idemprunteur;
                $sql = 'SELECT * FROM commentaire WHERE id_ressource = ? and id_emprunteur = ?';
                $stmt = parent::getPdo()->prepare($sql);
                $stmt->execute([$id_ressource, $id_user]);
                $stmt->fetchAll(\PDO::FETCH_OBJ);
                if($stmt->rowCount() > 0){
                    return true;
                }else{
                    return false;
                }
            }catch(\PDOException $e){
                return false;
            }
        }
    }
}