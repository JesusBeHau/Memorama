<?php
class getAllUsersHelper
{
    protected $dbManager;
    public function setdb($databaseManager)
    {
        $this->dbManager = $databaseManager;
    }
    public function getAllUsers()
    {
        $query = "SELECT * FROM usuario";
        $resultado = $this->dbManager->realizeQuery($query);

        if ($resultado == null) {
            return "Tabla usuario vacia";
        } else {
            if (is_array($resultado)) {
                return json_encode($resultado);
            } else {
                return $resultado->num_rows;
            }
        }
    }
}
