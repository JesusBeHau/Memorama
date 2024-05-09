<?php

class createParejaHelper{
  protected $dbManager;

  public function setdb($databaseManager)
  {
      $this->dbManager = $databaseManager;
  }

  public function setPareja($idmateria, $concepto, $descripcion) {
    $query = "INSERT INTO parejas (concepto,descripcion,idmateria) 
    VALUES('$concepto','$descripcion','$idmateria')";
    $resultado = $this->dbManager->insertQuery($query);
    return $resultado;
}
}

