<?php



    namespace App\Controllers;
    use App\Core\Session;
    use App\Core\Controller;
    use App\Models\Prestation;
    use App\Models\Consultation;
    use Rakit\Validation\Validator;
    use App\Models\RendezVousModel;

    class RendezVousController extends Controller{
        private Consultation $consultation;
        private Prestation $prestation;
        private RendezVousModel $rv;

        public function __construct(){
            parent::__construct();
            $this->consultation=new Consultation;
            $this->prestation=new Prestation;
            $this->rv=new RendezVousModel;
        }

        public function addRendezVous(){
            $validator = new Validator;
            $validation = $validator->make($_POST, [
                                                        'date'                 => 'required',
                                                        'etat'              => 'required',
                                                        'numPatient'              => 'required',
                                                        'typeRendezVous'              => 'required'
                                                    ],
                                                    [
                                                        'required' => 'ce champ  est obligatoire',
                                                        'min' => 'Le :attribute doit avoir au minimun :min caracteres',
                                                    ]);
            $integerValide=0;
            if($_POST["typeRendezVous"]==1&&$_POST["medecin"]==""){
                $validation->setMessage("medecin","required");
                $integerValide=$integerValide+1;
            };
            if($_POST["typeRendezVous"]==0&&$_POST["type"]==""){
                $validation->addAttribute("type","required");
            }
            $validation->validate();
            if(!$validation->fails()){
                switch($_POST["typeRendezVous"]){
                    case 1:
                        $objet=new Consultation();
                        $objet->medecin=$_POST["medecin"];
                        break;
                    case 0:
                        $objet=new Prestation();
                        $objet->type=$_POST["type"];
                        break;
                }
                $objet->date=$_POST["date"];
                $objet->etat=$_POST["etat"];
                $objet->numP=$_POST["numPatient"];
                $objet->insert();
                $this->redirect("/rendez-vous/liste");
            }

            $errors = $validation->errors();
            Session::set("errors",  $errors);
            Session::set("data",$_POST);
            $this->redirect("/rendez-vous/new");
        }
    
        public function lister(){
            $rvs=$this->rv->findAll(true);
            $this->render("rendezVous/liste.html.php",["rvs"=>$rvs]);
        }
        public function showNewForm(){
            $this->render("rendezVous/new.rv.html.php");
        }
        
        public function delete(){
            $this->rv->queryRowUpdate("UPDATE personne SET etat=0 WHERE id=:id",["id"=>$_GET["id"]/45050]);
            $this->redirect("/user/liste-user");
        }
    }