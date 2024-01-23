<?php

namespace models;

use models\base\SQL;
use utils\SessionHelpers;

class ExemplaireModel extends SQL
{
    public function __construct()
    {
        parent::__construct('exemplaire', 'idexemplaire');
    }

    public function getByRessource(int $id): bool|array
    {
        try {
            $sql = 'SELECT * FROM exemplaire WHERE idressource = ?';
            $stmt = parent::getPdo()->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            return false;
        }
    }

    
}
