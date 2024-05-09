<?php
class getAllParejasMateriaHelper
{
    protected $dbManager;

    public function setdb($databaseManager)
    {
        $this->dbManager = $databaseManager;
    }

    public function getAllParejasTheMateria($idMateria)
    {
        $query = "SELECT concepto,descripcion 
        FROM parejas WHERE idmateria = $idMateria";
        $resultado = $this->dbManager->realizeQuery($query);
        if ($resultado == null) {
            return "";
        } else {
            if (is_array($resultado)) {
                return json_encode($resultado);
            } else {
                return $resultado->num_rows;
            }
        }
    }
}
