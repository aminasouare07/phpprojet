<?php 
namespace App\Core; 
class Model {
    protected string $tableName;
    protected \PDO $pdo; 
    
    public function __construct()
    {
       try {
          $this->pdo=new \PDO("mysql:host=localhost;dbname=ratrapage","root","");
       } catch (\Exception $ex) {
         die($ex->getMessage());
       }
       
    }
    public function findByPaginate(int $offset,int $nbreParPage):array{
        try{
            $sql="select * from $this->tableName where etat=:etat limit $offset,$nbreParPage ";  //Requete Non preparee
            return $this->query($sql,["etat"=>1]);
        }catch(\Throwable $th){
            $sql="select * from $this->tableName limit $offset,$nbreParPage";  //Requete Non preparee
            return $this->query($sql);
        }
    }

    public function coutQuery():int{
        $sql="select count(*) as nbre from $this->tableName";
        return $this->query($sql,[],true)->nbre;
    }

    public function findAll($desc=false):array{
        if(!$desc){
            $sql="select * from $this->tableName";
            $stmt= $this->pdo->query($sql);
            return $stmt->fetchAll(\PDO::FETCH_CLASS,get_called_class()); 
        }else{
            $sql="select * from $this->tableName order by id desc";
            $stmt= $this->pdo->query($sql);
            return $stmt->fetchAll(\PDO::FETCH_CLASS,get_called_class()); 
        }
    }
   
 
    public function query(string $sql,$data=[],$single=false){
        $stmt= $this->pdo->prepare($sql);
        $stmt->setFetchMode(\PDO::FETCH_CLASS,get_called_class());
        $stmt->execute($data);
        if($single){
            return $stmt->fetch();
        }else{
            return $stmt->fetchAll(\PDO::FETCH_CLASS,get_called_class());   
        }
        
    }
 
    public function queryRowUpdate(string $sql,$data=[]){
        $stmt= $this->pdo->prepare($sql);
        $stmt->execute($data);
        return $stmt->rowCount();
    }

    public function findBy(string $key,$keyValue,$single=true){
        return $this->query("select * from $this->tableName where $key=:x",["x"=>$keyValue],$single);
    }

    public function remove(int $id):int{
        $sql="Delete  from $this->tableName where id=:x";
        $stmt= $this->pdo->prepare($sql);
        $stmt->execute(["x"=>$id]);
        return $stmt->rowCount();
    }
}