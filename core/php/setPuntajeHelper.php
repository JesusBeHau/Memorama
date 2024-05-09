<?php

class setPuntajeHelper{
  protected $dbManager;

  public function setdb($databaseManager)
  {
      $this->dbManager = $databaseManager;
  }

  public function setPuntaje($idUsuario,$idMateria,$fecha,
    $dificultad,$puntaje,$foundPeers){
    $query = "INSERT INTO puntajes (id_usuario,id_materia,fecha,dificultad,
    puntaje,parejas_encontradas) VALUES('$idUsuario','$idMateria',
    '$fecha','$dificultad',$puntaje,$foundPeers)";
    $resultado = $this->dbManager->insertQuery($query);
    return $resultado;
}
}

