<?php
class createUserHelper
{
    protected $dbManager;
    public function setdb($databaseManager)
    {
        $this->dbManager = $databaseManager;
    }
    public function setUser($name, $password, $tipo){
      $query = "INSERT INTO usuario (nombre, clave, tipo) 
      VALUES('$name','$password','$tipo')";
      $resultado = $this->dbManager->insertQuery($query);
      return $resultado;
  }
}
