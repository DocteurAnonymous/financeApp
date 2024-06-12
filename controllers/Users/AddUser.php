<?php 

    include_once dirname(__DIR__,2).DIRECTORY_SEPARATOR."models".DIRECTORY_SEPARATOR."Users.php";
    include_once dirname(__DIR__,2).DIRECTORY_SEPARATOR."config".DIRECTORY_SEPARATOR."Db.php";
        
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data)) {
            $modelUser = new Users(
                $dbi,
                cleanData($data->nom),
                cleanData($data->prenom),
                cleanData($data->genre),
                cleanData($data->telephone),
            );
            
            $modelUser->setFonction(cleanData($data->fonction));

            if ($modelUser->create()) {
                return print json_encode(['response' => "Utilisateur ".$data->prenom." ".$data->nom." ajouter avec succès"],JSON_PRETTY_PRINT);
                
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