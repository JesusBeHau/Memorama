<?php
class getAllMateriaHelper
{
    protected $dbManager;
    public function setdb($databaseManager)
    {
        $this->dbManager = $databaseManager;
    }

    public function getAllMateria()
    {
        $query = "SELECT * FROM materias";
        $resultado = $this->dbManager->realizeQuery($query);
        if ($resultado == null) {
            return "tabla materia vacia";
        } else {
            if (is_array($resultado)) {
                return json_encode($resultado);
            } else {
                return $resultado->num_rows;
            }
        }
    }
}
