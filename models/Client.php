<?php
    include "Person.php";
    class Client extends Person {
        private $id,$agence;
        private $dateCreate_at;
        private $conn = null;    
        private $table = "t_client";
        
        //DECLARER LE CONSTRUCTEUR
        public function __construct($db,$prenom,$nom,$genre,$telephone)
        {
            parent::__construct($prenom,$nom,$genre,$telephone);
            if($this->conn === null){
                $this->conn = $db;
            }   
        }

        //LA FONCTION POUR CREER UN CLIENT 
        public function createClient(){
            $req = "INSERT INTO $this->table (prenom,nom,genre,telephone,agence,dateCreate_at)
                    VALUES (:prenom, :nom, :genre, :telephone, :agence, NOW())";

            try {
                $stm = $this->conn->prepare($req);
                return $stm->execute(
                    [
                        ":prenom" => $this->prenom,
                        ":nom" => $this->nom,
                        ":genre" => $this->genre,
                        ":telephone" => $this->telephone,
                        ":agence" => $this->agence,
                    ]
                );
            } catch (PDOException $e) {
                die(json_encode(["error" => "Erreur liée à la base de donnée:".$e->getMessage()],JSON_PRETTY_PRINT));
            } 
        }
        public function dernierClientId(){
            $req = "SELECT id FROM $this->table ORDER BY id DESC LIMIT 1";

            try {
                $stm = $this->conn->prepare($req);
                $stm->execute();
                return $stm;
            } catch (PDOException $e) {
                die(json_encode(["error" => "Erreur Dernier Client".$e->getMessage()],JSON_PRETTY_PRINT));
            } 
        }
        public function readClientAgence(){
            $req = "SELECT c.prenom, c.nom, c.genre, c.telephone, a.nom, a.adresse 
            FROM $this->table c INNER JOIN t_agence a ON c.agence = a.id 
            ORDER BY c.datecreate_at DESC";

            try {
                $stm = $this->conn->prepare($req);
                $stm->execute();
                return $stm;

            } catch (PDOException $e) {
                die(json_encode(["error" => "Lecture client erreur :".$e->getMessage()],JSON_PRETTY_PRINT));
            }
        }
        public function readClientCompte(){
            $req = "SELECT c.prenom, c.nom, c.genre, c.telephone, co.id, co.typeC, co.solde 
            FROM $this->table c INNER JOIN t_compte co ON c.id = co.client";            

            try {
                $stm = $this->conn->prepare($req);
                $stm->execute();
                return $stm;

            } catch (PDOException $e) {
                die(json_encode(["error" => "Lecture client erreur :".$e->getMessage()],JSON_PRETTY_PRINT));
            }
        }
        public function read_a_client(){
            $req = "SELECT c.prenom, c.nom, c.genre, c.telephone, a.nom, a.adresse 
            FROM $this->table c INNER JOIN t_agence a ON c.agence = a.id
            WHERE c.id = :id";
            try {
                $stm = $this->conn->prepare($req);
                return $stm->execute([':id' => $this->id]);

            } catch (PDOException $e) {
                die(json_encode(["error" => "Lecture client erreur :".$e->getMessage()],JSON_PRETTY_PRINT));
            }
        }
        public function update(){
            $sql = "UPDATE $this->table SET prenom = :prenom, nom = :nom, genre = :genre, telephone = :telephone 
            WHERE id = :id";
            $values = [
                ":prenom" => $this->prenom,
                ":nom" => $this->nom,
                ":genre" => $this->genre,
                ":telephone" => $this->telephone,
                ":id" => $this->id,
            ];
            try {
                $stm = $this->conn->prepare($sql);
                return $stm->execute($values);
            } catch (PDOException $e) {
                die(json_encode(["error" => "Update client erreur :".$e->getMessage()],JSON_PRETTY_PRINT));
            } 
        }
        public function delete(){
            $sql = "DELETE FROM $this->table WHERE id=:id";
            try {
                $stm = $this->conn->prepare($sql);
                return $stm->execute([":id" => $this->id]);
            } catch (PDOException $e) {
                die(json_encode(["error" => "Delete client erreur :".$e->getMessage()],JSON_PRETTY_PRINT));
            } 
        }

     
        public function setAgence($agence)
        {
                $this->agence = $agence;

                return $this;
        }

        public function getId()
        {
                return $this->id;
        }

        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }
    }
    