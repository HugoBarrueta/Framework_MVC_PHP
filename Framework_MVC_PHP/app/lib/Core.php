<?php

/*Mapear la url ingresada en el navegador
1- controlador
2- metodo
3- parametro
/articulo/actualizar/5
*/

class Core{
    protected $controladorActual = 'paginas';
    protected $metodoActual = 'index';
    protected $parametros = [];

    //Constructor
    public function __construct(){
        $url = $this->getUrl();
        //print_r($this->getUrl());

        //Buscar un controlador si el controlador existe
        if(file_exists('../app/controllers/'.ucwords($url[0]).'.php')){
            //si existe se coloca como controlador por defecto
            $this->controladorActual = ucwords($url[0]);

            //unset indice
            unset($url[0]);
        }

        //Requerir el controlador
        require_once '../app/controllers/' . $this->controladorActual . '.php';
        $this->controladorActual = new $this->controladorActual;

        //Verifivar la segunda parte de la url <Metodo> [1]
        if(isset($url[1])){
            if(method_exists($this->controladorActual, $url[1])){
                //checamos el metodo
                $this->metodoActual = $url[1];
                //unset indice
                unset($url[1]);
            }
        }
        //Para probar traer metodo
        //echo $this->metodoActual;

        //obtener los posibles parametros
        $this->parametros = $url ? array_values($url) : [];

        //llamar callback con parametros array
        call_user_func_array([$this->controladorActual, $this->metodoActual], $this->parametros);


    }

    public function getUrl(){
        //echo $_GET['url'];

        if(isset($_GET['url'])){
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            
            return $url;
        }
    }
}


?>