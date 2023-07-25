<?php
namespace App\Core;

class Controller{
    protected string  $layout="base";
    protected string $path;
    public function __construct()
    {
    }

    public function render($view, array $data=[]){
        extract($data);
        ob_start();
        require_once "./../views/".$view;
       $contentView=ob_get_clean();
       require_once "./../views/layout/".$this->layout.".layout.html.php"; 
    }
    public function redirect(string $path){
        header("location:".BASE_URL."$path");//GET
        exit;
    }
}