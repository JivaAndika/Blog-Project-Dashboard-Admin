<?php
define("DB_HOST","localhost");
define("DB_USER","root");
define("DB_PASSWORD","");
define("DB_NAME","dashboard");

class Connection{
    public $db;
    public function __construct(){
        $connection = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        if(!$connection){
            die("Gagal terhubung ke database" . mysqli_connect_error());
        } else{
            $this->db = $connection;
            return $this->db;
        }

    }
}
