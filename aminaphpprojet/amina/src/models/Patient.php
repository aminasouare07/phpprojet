<?php
    namespace App\Models;
    use App\Core\Model;

    class Patient extends Model{
        public string $numPatient;
        public string $nomComplet;

        public function __construct(){
            parent::__construct();
            $this->tableName="patient";
        }
        public function insert():int{
            $sql="INSERT INTO $this->tableName  VALUES (:numPatient,:nomComplet)";
            $stmt= $this->pdo->prepare($sql);
            $stmt->execute([
                        "numPatient"=>$this->numPatient,
                        "nomComplet"=>$this->nomComplet
                        ]);
            return $stmt->rowCount();
        }
    }