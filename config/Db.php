<?php
    class Db{
        private $host = "localhost";
        private $dbname = "Financeapp";
        private $user = "root";
        private $password = "";
        private $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ];

        //METHODE DE CONNEXION A LA BASE DE DONNEES
        public function getDbInstance(){
            $conn = null;
            try {
                $conn = new PDO("mysql:host=$this->host;dbname=$this->dbname;char_set=utf8",$this->user,$this->password,$this->options);

            } catch (\PDOException $e) {
                die(json_encode(["Erreur de connexion à la base de données".$e->getMessage()],JSON_PRETTY_PRINT));
            }
            return $conn;
        }
    }

    //CREATION DE L'INSTANCE DE LA BASE DE DONNEES
    $db = new Db();
    $dbi = $db->getDbInstance();