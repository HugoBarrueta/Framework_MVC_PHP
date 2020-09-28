<?php

class Paginas extends Controller{
    public function __construct(){
       
    }

    public function index(){


        $data = [
            'titulo' => 'Bienvenidos a MVC Prueba'
        ];

        $this->view('pages/inicio', $data);
    }
    
}

?>