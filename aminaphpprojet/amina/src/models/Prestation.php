<?php
    namespace App\Models;

    class Prestation extends RendezVousModel{
        public int $type;

        public function __construct(){
            parent::__construct();
            $this->typeRendezVous=0;
        }

        public function insert(){
            parent::insert($this->type);
        }

    }
