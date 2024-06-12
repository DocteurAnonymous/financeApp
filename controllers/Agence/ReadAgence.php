<?php 

    include_once dirname(__DIR__,2).DIRECTORY_SEPARATOR."models".DIRECTORY_SEPARATOR."Agence.php";
    include_once dirname(__DIR__,2).DIRECTORY_SEPARATOR."config".DIRECTORY_SEPARATOR."Db.php";
        
    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        
        $modelAgence = new Agence($dbi);
        $agences = $modelAgence->read();
        if ($agences->rowCount() > 0) {
            $agences = $agences->fetchAll();    
            return print json_encode(['response' => $agences ],JSON_PRETTY_PRINT);
        }else {
            return print json_encode(['response' => "La liste des agences est vide"],JSON_PRETTY_PRINT);
        }      

    } else {
        return print json_encode(['erreur' => "Vous n'êtes pas autorisé"],JSON_PRETTY_PRINT);
    }

    function cleanData($data){
        return trim(htmlentities($data));
    }