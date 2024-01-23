<?php

namespace models;

use models\base\SQL;

/**
 * Modèle d'exemple pour la création d'un modèle.
 * Le modèle doit hériter de la classe SQL. Il possède donc les méthodes :
 * - getAll() : récupère toutes les données de la table
 * - getOne() : récupère une donnée de la table
 * - deleteOne() : supprime une donnée de la table
 * - updateOne() : met à jour une donnée de la table
 * - getPdo() : retourne l'instance PDO
 *
 * Il est évidemment possible de créer des méthodes spécifiques au modèle, comme dans l'exemple ci-dessous.
 */

class SampleModel extends SQL
{
    public function __construct()
    {
        parent::__construct('votre-table', 'cle-de-votre-table');
    }

    /**
     * Méthode d'exemple permettant l'accès aux données avec une
     * requête préparée.
     */
    public function getSampleData(string $filterEl): \stdClass
    {
        $stmt = $this->getPdo()->prepare("SELECT * from `votre-table` WHERE col = ?");
        $stmt->execute([$filterEl]);
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * Méthode d'exemple d'ajout de données avec une requête préparée.
     * @param string $col
     * @param string $col2
     * @return bool
     */
    public function createSampleData(string $col, string $col2): bool
    {
        $stmt = $this->getPdo()->prepare("INSERT INTO `votre-table` (col, col2) VALUES (?, ?)");
        return $stmt->execute([$col, $col2]);
    }
}