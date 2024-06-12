<?php
    class Agence{
        private $id, $nom, $adresse, $dateCreate_at, $table = "t_agence";
        private $conn = null;

        public function __construct($db)
        {
            if ($this->conn === null){
                $this->conn = $db;
            }
        }

       /** LES SETTEURS DES ATTRIBUTS DE LA CLASSE AGENCE */
        public function setNom($nom)
        {
                $this->nom = $nom;

                return $this;
        }       
        public function setAdresse($adresse)
        {
                $this->adresse = $adresse;

                return $this;
        }
        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }
        
        /** LES METHODES DE LA CLASSE AGENCE */
        public function create(){
            $req = "INSERT INTO $this->table (nom,adresse,dateCreate_at) 
            VALUES (:nom, :adresse, NOW())";
            try {
                $stm = $this->conn->prepare($req);
                return $stm->execute(
                    [                        
                        ":nom" => $this->nom,
                        ":adresse" => $this->adresse
                    ]
                );
            } catch (PDOException $e) {
                die(json_encode(["error" => "Erreur liée à la base de donnée:".$e->getMessage()],JSON_PRETTY_PRINT));
            } 
        }
        public function read(){
            $req = "SELECT * FROM $this->table";
            try {
                $stm = $this->conn->prepare($req);
                $stm->execute();
                return $stm;

            } catch (PDOException $e) {
                die(json_encode(["error" => "Lecture Agence erreur :".$e->getMessage()],JSON_PRETTY_PRINT));
            }
        }
        public function update(){
            $sql = "UPDATE $this->table SET nom = :nom, adresse = :adresse 
            WHERE id = :id";
            $values = [
                ":nom" => $this->nom,
                ":adresse" => $this->adresse,
                ":id" => $this->id
            ];
            try {
                $stm = $this->conn->prepare($sql);
                return $stm->execute($values);
            } catch (PDOException $e) {
                die(json_encode(["error" => "Update Agence erreur :".$e->getMessage()],JSON_PRETTY_PRINT));
            } 
        }
        public function delete(){
            $sql = "DELETE FROM $this->table WHERE id=:id";
            try {
                $stm = $this->conn->prepare($sql);
                return $stm->execute([":id" => $this->id]);
            } catch (PDOException $e) {
                die(json_encode(["error" => "Delete Agence erreur :".$e->getMessage()],JSON_PRETTY_PRINT));
            } 
        }



       
        
    }