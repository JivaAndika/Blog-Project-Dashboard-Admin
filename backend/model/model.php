<?php
session_start();
require_once __DIR__ . "/../DB/Connection.php";
require_once __DIR__ . "/../interface/modelinterface.php";
abstract class Model extends Connection implements ModelInterface{
     public function create_data($datas,$table){
        $key = array_keys($datas);
        $value = array_values($datas);
        $key = implode(",",$key);
        $value = implode("','",$value);
        $query = "INSERT INTO $table ($key) VALUES ('$value')";
      
        $result = mysqli_query($this->db,$query);
        return $result;
    }
    public function all_data($table){
        $query = "SELECT * FROM $table";
        $result = mysqli_query($this->db, $query);
        return $this->convert_data($result);
    }
    public function convert_data($datas){
        $data = [];
        while($row = mysqli_fetch_assoc($datas)){
            $data[] = $row;

        }
        return $data;
        
    }
    public function find_data($id,$column,$table){
        $query = "SELECT * FROM $table WHERE $column = $id";
        $result = mysqli_query($this->db, $query);
        return $this->convert_data($result);
    }
    
    public function update_data($id,$column, $datas, $table){
    $key = array_keys($datas);
    $value = array_values($datas);
    $query = "UPDATE $table SET ";
    for($i = 0 ; $i < count($key); $i++){
        $query .= $key[$i] . " = '" . $value[$i] . "'";
        if($i != count($key) - 1){
            $query .= ", "; 
        }
    }
    $query .= " WHERE $column = $id";
    $result = mysqli_query($this->db, $query);
    if($result){
        return $datas;
    } else {
        return false;
    }
}

    public function delete_data($id,$column,$table){
        $query = "DELETE FROM $table WHERE $column = $id";
        $result = mysqli_query($this->db,$query);
        return $result;
        
    }
    public function search_data($keyword,$table){
        $query = "SELECT * FROM $table $keyword";
        $result = mysqli_query($this->db, $query);
        return $this->convert_data($result);
    }
    public function paggination_data($startData , $limit, $table ){
        $query = "SELECT * FROM $table  LIMIT $startData, $limit";
        $result = mysqli_query($this->db, $query);
        return $this->convert_data($result);
    
          
    }

}