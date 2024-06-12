<?php
    include "Person.php";
    class Users extends Person {
        private $id;
        private $fonction;
        private $table = "t_users";
        private $conn = null;
        private $dateCreate_at;

        //DECLARER LE CONSTRUCTEUR
        public function __construct($db,$prenom,$nom,$genre,$telephone)
        {
            parent::__construct($prenom,$nom,$genre,$telephone);
            if($this->conn === null){
                $this->conn = $db;
            }   
        }

        //LES GETTEURS ET SETTEUR POUR LES PROPRIETES
        public function getFonction()
        {
                return $this->fonction;
        }
        public function setFonction($fonction)
        {
                $this->fonction = $fonction;

                return $this;
        }
        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }

        //LES METHODES DE LA CLASSE USERS
        public function create(){
            $req = "INSERT INTO $this->table (prenom,nom,genre,telephone,fonction, dateCreate_at) 
            VALUES (:prenom, :nom, :genre, :telephone, :fonction, NOW())";

            try {
                $stm = $this->conn->prepare($req);
                return $stm->execute(
                    [
                        ":prenom" => $this->prenom,
                        ":nom" => $this->nom,
                        ":genre" => $this->genre,
                        ":telephone" => $this->telephone,
                        ":fonction" => $this->fonction,
                    ]
                );
            } catch (PDOException $e) {
                die(json_encode(["error" => "Erreur liée à la base de donnée:".$e->getMessage()],JSON_PRETTY_PRINT));
            } 
        }
        public function bloquer(){
            $req = "UPDATE $this->table SET u_status = 1 WHERE id = :id ";
            try {
                $stm = $this->conn->prepare($req);
                return $stm->execute([":id" => $this->id]);
            } catch (PDOException $e) {
                die(json_encode(["error" => "Erreur liée à la base de donnée:".$e->getMessage()],JSON_PRETTY_PRINT));
            } 
        }
        public function debloquer(){
            $req = "UPDATE $this->table SET u_status = 0 WHERE id = :id ";
            try {
                $stm = $this->conn->prepare($req);
                return $stm->execute([":id" => $this->id]);
            } catch (PDOException $e) {
                die(json_encode(["error" => "Erreur liée à la base de donnée { :".$e->getMessage()],JSON_PRETTY_PRINT));
            } 
        }

    }