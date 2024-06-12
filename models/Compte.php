<?php
    class Compte{
        private $id,$typeC,$solde,$client;

        private $conn = null;
        private $table = "t_compte";        

        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }

        public function setTypeC($typeC)
        {
                $this->typeC = $typeC;

                return $this;
        }
        public function setSolde($solde)
        {
                $this->solde = $solde;

                return $this;
        }

        public function setClient($client)
        {
                $this->client = $client;

                return $this;
        }

        /**Le constructeur de la classe */
        public function __construct($db)
        {
            if ($this->conn === null){
                $this->conn = $db;
            }
        }

        public function create(){
            $req = "INSERT INTO $this->table (typeC,solde,client) 
            VALUES (:typeC, :solde, :client)";
            try {
                $stm = $this->conn->prepare($req);
                return $stm->execute(
                    [ 
                        ":typeC" => $this->typeC,
                        ":solde" => $this->solde,
                        ":client" => $this->client
                    ]
                );
            } catch (PDOException $e) {
                die(json_encode(["error" => "Erreur liée à la base de donnée:".$e->getMessage()],JSON_PRETTY_PRINT));
            } 
        }
        
        public function update(){
            $sql = "UPDATE $this->table SET typeC = :typeC 
            WHERE id = :id";
            $values = [
                ":typeC" => $this->typeC,
                ":id" => $this->id
            ];
            try {
                $stm = $this->conn->prepare($sql);
                return $stm->execute($values);
            } catch (PDOException $e) {
                die(json_encode(["error" => "Update Agence erreur :".$e->getMessage()],JSON_PRETTY_PRINT));
            } 
        }

        public function soldeCompte(){
            $sql = "SELECT solde FROM $this->table WHERE id = :id";
            try {
                $stm = $this->conn->prepare($sql);
                $stm->execute([':id' => $this->id]);
                return $stm;
            } catch (PDOException $e) {
                die(json_encode(["error" => "Lecture solde erreur :".$e->getMessage()],JSON_PRETTY_PRINT));
            } 
        }

        public function transaction(){
            $sql = "UPDATE $this->table SET solde = :solde 
            WHERE id = :id";
            $values = [
                ":solde" => $this->solde,
                ":id" => $this->id
            ];
            try {
                $stm = $this->conn->prepare($sql);
                return $stm->execute($values);
            } catch (PDOException $e) {
                die(json_encode(["error" => "Transaction Compte erreur :".$e->getMessage()],JSON_PRETTY_PRINT));
            } 
        }

        
    }