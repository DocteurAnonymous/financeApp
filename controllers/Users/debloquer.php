<?php 

    include_once dirname(__DIR__,2).DIRECTORY_SEPARATOR."models".DIRECTORY_SEPARATOR."Users.php";
    include_once dirname(__DIR__,2).DIRECTORY_SEPARATOR."config".DIRECTORY_SEPARATOR."Db.php";
        
    if ($_SERVER["REQUEST_METHOD"] === "PUT") {
        
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data)) {
            $modelUser = new Users(
                $dbi,null,null,null,null
            );
            
            $modelUser->setId(cleanData($data->userId));

            if ($modelUser->debloquer()) {
                return print json_encode(['response' => "Utilisateur débloquer avec succès"],JSON_PRETTY_PRINT); 
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