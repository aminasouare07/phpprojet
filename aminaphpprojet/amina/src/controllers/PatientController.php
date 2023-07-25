<?php
    namespace App\Controllers;
    use Rakit\Validation\Validator;
    use App\Core\Session;
    use App\Core\Controller;
    use App\Models\Patient;
    class PatientController extends Controller{
        private Patient $patient;

        public function __construct(){
            parent::__construct();
            $this->patient=new Patient;
        }

        public function addPatient(){
            $validator = new Validator;
            $validation = $validator->make($_POST, [
                                                        'numPatient'              => 'required|min:5',
                                                        'nomComplet'                 => 'required'
                                                    ],
                                                    [
                                                        'required' => 'ce champ  est obligatoire',
                                                        'min' => 'Le :attribute doit avoir au minimun :min caracteres',
                                                    ]);
            
            $validation->validate();
            if(!$validation->fails()){
                $patient=new Patient();
                $patient->numPatient=$_POST["numPatient"];
                $patient->nomComplet=$_POST["nomComplet"];
                $patient->insert();
                $this->redirect("/patient/liste");
            }

            $errors = $validation->errors();
            Session::set("errors",  $errors);
            Session::set("data",$_POST);
            $this->redirect("/patient/new/form");
        }
    
        public function liste(){
            $patients=$this->patient->findAll();
            $this->render("patient/liste.html.php",["personnes"=>$patients]);
        }
        public function showAddForm(){
            $this->render("personne/new.html.php");
        }
        
        // public function delete(){
        //     $this->patient->queryRowUpdate("DELETE ",["id"=>$_GET["id"]/45050]);
        //     $this->redirect("/user/liste-user");
        // }
    }