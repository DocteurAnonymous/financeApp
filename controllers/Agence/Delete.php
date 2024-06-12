<?php 

    include_once dirname(__DIR__,2).DIRECTORY_SEPARATOR."models".DIRECTORY_SEPARATOR."Agence.php";
    include_once dirname(__DIR__,2).DIRECTORY_SEPARATOR."config".DIRECTORY_SEPARATOR."Db.php";
        
    if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data)) {
            $modelAgence = new Agence($dbi);
            $modelAgence->setId(cleanData($data->id));
            
            if ($modelAgence->delete()) {
                return print json_encode(['response' => "L'Agence supprimer avec succès"],JSON_PRETTY_PRINT);
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