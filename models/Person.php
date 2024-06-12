<?php
    class Person{
        //LES PROPRIETES DE LA CLASSE PERSONNE
       
        protected $prenom;
        protected $nom;
        protected $genre;
        protected $telephone;

        public function __construct($nom, $prenom, $genre, $telephone)
        {
            $this->nom = $nom;
            $this->prenom = $prenom;
            $this->genre = $genre;
            $this->telephone = $telephone;
        }

        //LES GETTERS ET SETTEURS POUR CES PROPRIETES
      
        public function getPrenom()
        {
                return $this->prenom;
        }        
        public function setPrenom($prenom)
        {
                $this->prenom = $prenom;

                return $this;
        }        
        public function getNom()
        {
                return $this->nom;
        }        
        public function setNom($nom)
        {
                $this->nom = $nom;

                return $this;
        }         
        public function getGenre()
        {
                return $this->genre;
        }        
        public function setGenre($genre)
        {
                $this->genre = $genre;

                return $this;
        }        
        public function getTelephone()
        {
                return $this->telephone;
        }        
        public function setTelephone($telephone)
        {
                $this->telephone = $telephone;

                return $this;
        }        
       


    }