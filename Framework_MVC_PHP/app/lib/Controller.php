<?php

//Clase controlador principal
//Se encarga de cargar los modelos y las vistas
class Controller{
    //Cargar modelo
    public function model($model){
        //carga
        require_once '../app/models/'.$model.'.php';
        //Instanciar el modelo
        return new $model();
    }

    //Cargar vista
    public function view($view, $data = []){
        //checar si el archivo vista exite
        if(file_exists('../app/views/'.$view.'.php')){
            require_once '../app/views/'.$view.'.php';
        }else{
            //si el archivo no existe
            die('La vista no exite');
        }
    }
}

?>