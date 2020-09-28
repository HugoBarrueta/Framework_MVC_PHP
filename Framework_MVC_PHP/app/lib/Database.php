<?php

//Clase para conectar a la bd y ejecutar consultas PDO
class Database{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $name = DB_NAME;

    private $dbh;
    private $stmt;
    private $error;

    public function __construct(){
        //configurar la conexion
        $dsn = 'mysql:host='.$this->host.';dbname='.$this->name;
        $opciones = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        //Crear instancia de PDO
        try{
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $opciones);
            $this->dbh->exec('set names utf8');
        }catch (Exeption $e){
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    //PReparamos la consulta
    public function query($sql){
        $this->stmt = $this->dbh->prepare($sql);
    }

    //Funcion para vincular la consulta con bind
    public function bind($param, $value, $type = null){
        if(is_null($type)){
            switch (true) {
                case is_int():
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool():
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null():
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;  
                break;                
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    //Ejecuta la consulta
    public function execute(){
        return $this->stmt->execute();
    }

    //Obtener los registros de la consulta
    public function registros(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    //Obtener un unico registro
    public function registro(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    //Obtenere la cantidad de registros con el metodo rowCount
    public function rowCount(){
        return $this->stmt->rowCount();
    }
}

?>