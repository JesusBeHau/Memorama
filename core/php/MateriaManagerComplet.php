<?php
class MateriaManagerComplet
{
    protected $dbManager;
    public function __construct($dbManager)
    {
        $this->dbManager = $dbManager;
    }

    //Funcion para mantenimiento
    public function getAllMateriaComplet()
    {
        $query = "
          SELECT m.id, m.nombre, COUNT(p.id) AS total_parejas
          FROM materias m
          LEFT JOIN parejas p ON m.id = p.idmateria
          GROUP BY m.id
          HAVING total_parejas >= 9;
      ";

        $resultados = $this->dbManager->realizeQuery($query);

        if ($resultados === null) {
            return "tabla materia vacia";
        } else {
            return json_encode($resultados);
        }
    }
}
