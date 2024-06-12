<?php 

    include_once dirname(__DIR__,2).DIRECTORY_SEPARATOR."models".DIRECTORY_SEPARATOR."Client.php";
    include_once dirname(__DIR__,2).DIRECTORY_SEPARATOR."models".DIRECTORY_SEPARATOR."Compte.php";
    include_once dirname(__DIR__,2).DIRECTORY_SEPARATOR."config".DIRECTORY_SEPARATOR."Db.php";
        
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data)) {
            $modelClient = new Client(
                $dbi,
                cleanData($data->nom),
                cleanData($data->prenom),
                cleanData($data->genre),
                cleanData($data->telephone),
            );
            $modelClient->setAgence(cleanData($data->agence));
            if ($modelClient->createClient()) {
                /**Ajout du compte du client */
                $CurrentIdClient = $modelClient->dernierClientId();
                $CurrentIdClient = $CurrentIdClient->fetch();
                $modelCompte = new Compte($dbi);
                $modelCompte->setTypeC(cleanData($data->typeC));                
                $modelCompte->setSolde(cleanData($data->solde));                
                $modelCompte->setClient($CurrentIdClient->id); 

                if ($modelCompte->create()) {
                    return print json_encode(['response' => "Le client ".$data->prenom." ".$data->nom." ajouter avec succès"],JSON_PRETTY_PRINT);                    
                }              
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