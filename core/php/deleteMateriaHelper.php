<?php
class deleteMateriasHelper
{
    protected $dbManager;
    public function setdb($databaseManager)
    {
        $this->dbManager = $databaseManager;
    }

    public function deleteMateria($idMateria){
      $query = "DELETE FROM materias WHERE id = '$idMateria'";
      $resultado = $this->dbManager->insertQuery($query);
      return $resultado;
  }
}
