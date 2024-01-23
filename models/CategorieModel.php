<?php
namespace models;

use models\base\SQL;

class CategorieModel extends SQL
{
    public function __construct()
    {
        parent::__construct('categorie', 'idcategorie');
    }
}