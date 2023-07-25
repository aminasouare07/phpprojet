<?php 
    namespace App\Models;

    class Consultation extends RendezVousModel{

        public string $medecin;

        public function __construct(){
            parent::__construct();
            $this->typeRendezVous=1;
        }
        public function insert(){
            parent::insert($this->medecin);
        }

    }