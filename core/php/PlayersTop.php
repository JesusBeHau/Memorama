<?php
class PlayersTop
{
  protected $dbManager;
  public function __construct($dbManager)
  {
    $this->dbManager = $dbManager;
  }

  public function getTopTenPuntajes()
  {
    $query = "
      SELECT u.nombre, p.puntaje, p.dificultad
      FROM puntajes p
      JOIN usuario u ON p.id_usuario = u.id
      ORDER BY p.puntaje DESC
      LIMIT 10
    ";

    $resultado = $this->dbManager->realizeQuery($query);

    if ($resultado === null) {
      return "No se pudo recuperar los puntajes.";
    } else {
      return json_encode($resultado);
    }
  }
}
