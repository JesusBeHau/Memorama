<?php
class updateParejasHelper
{
    protected $dbManager;
    public function setdb($databaseManager)
    {
        $this->dbManager = $databaseManager;
    }
    public function updatePareja($id, $idMatter, $concept, $definition)
    {
        $query = "UPDATE parejas SET idmateria = '$idMatter', 
        concepto = '$concept', descripcion = '$definition' WHERE id = " . intval($id);
        $resultado = $this->dbManager->insertQuery($query);
        return $resultado;
    }
}
