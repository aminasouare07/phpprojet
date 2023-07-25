<?php 
namespace App\Models;
use App\Core\Model;

class RendezVousModel extends Model{
    public int $id;
    public string $date;
    public string $etat;
    public int $typeRendezVous;
    public string $numP;

    private Patient $patient;


    public function __construct()
    {
        parent::__construct();
        $this->tableName="rendezvous"; 
        $this->patient =new Patient;
    }

    public function insert($data=null):int{
        $sql="INSERT INTO $this->tableName  VALUES (NULL,:date,:etat,:type,:medecin,:numP,:typeRendez)";
        $stmt= $this->pdo->prepare($sql);
        $stmt->execute([
                    "date"=>$this->date,
                    "etat"=>$this->etat,
                    "type"=>$this->typeRendezVous==0?$data:null,
                    "medecin"=>$this->typeRendezVous==1?$data:null,
                    "numP"=>$this->numP,
                    "typeRendez"=>$this->typeRendezVous
                    ]);
        return $stmt->rowCount();
    }

}