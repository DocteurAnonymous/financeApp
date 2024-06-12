<?php 

    include_once dirname(__DIR__,2).DIRECTORY_SEPARATOR."models".DIRECTORY_SEPARATOR."Client.php";
    include_once dirname(__DIR__,2).DIRECTORY_SEPARATOR."models".DIRECTORY_SEPARATOR."Compte.php";
    include_once dirname(__DIR__,2).DIRECTORY_SEPARATOR."config".DIRECTORY_SEPARATOR."Db.php";
        
    if ($_SERVER["REQUEST_METHOD"] === "PUT") {
        
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data)) {
            $modelCompte = new Compte($dbi);
            $modelCompte->setId(cleanData($data->id));
            $ancienSolde = $modelCompte->soldeCompte()->fetch()->solde;
            $nouveauSolde = intval($ancienSolde) - intval(cleanData($data->soldeSaisie));
            $modelCompte->setSolde($nouveauSolde);

            if ($nouveauSolde < 0) {
                return print json_encode(['response' => "Le solde saisi : ".$data->soldeSaisie." est supérieur à votre compte actuel qui est de : ".$ancienSolde],JSON_PRETTY_PRINT);
            }

            if ($modelCompte->transaction()) {
                return print json_encode(['response' => "Retrait de ".$data->soldeSaisie." effectuer avec Succès\n Votre nouveau solde est de : ".$nouveauSolde],JSON_PRETTY_PRINT);
            }

        }else {
            return print json_encode(['response' => "La liste des données est vide"],JSON_PRETTY_PRINT);
        }
       

    } else {
        return print json_encode(['erreur' => "Vous n'êtes pas autorisé"],JSON_PRETTY_PRINT);
    }

    function cleanData($data){
        return trim(htmlentities($data));
    }