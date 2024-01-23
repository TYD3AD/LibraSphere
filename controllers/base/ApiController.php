<?php

namespace controllers\base;

class ApiController implements IBase
{
    function redirect($to)
    {
        // Do Nothing
    }

    // Retourne un JSON à partir des données passées en paramètre.
    function toJson($data): string
    {
        header('Content-Type: application/json'); // On précise que le contenu est du JSON
        header('Access-Control-Allow-Origin: *'); // On autorise les requêtes depuis n'importe quel domaine => RISQUE DE SECURITE

        return json_encode($data);
    }
}