<?php
declare(strict_types=1);
include_once('core/php/PlayersTop.php');
include_once('core/php/DataBaseManager.php');

class getTopPlayersTest extends PHPUnit\Framework\TestCase{
   //Preuba positiva
  public function testGetTopTenPuntajesReturnsJsonOnSuccess()
  {
      // Crear un mock para el objeto DataBaseManager
      $dbManagerMock = $this->createMock(DataBaseManager::class);
      $dbManagerMock->method('realizeQuery')
                    ->willReturn([
                        ['nombre' => 'John Doe', 'puntaje' => 95, 'dificultad' => 'Alta'],
                        ['nombre' => 'Jane Doe', 'puntaje' => 90, 'dificultad' => 'Media']
                    ]);

      $playersTop = new PlayersTop($dbManagerMock);
      $result = $playersTop->getTopTenPuntajes();

      $this->assertJson($result);
      $this->assertSame(json_encode($dbManagerMock->realizeQuery('')), $result);
  }
   //Preuba negativa
  public function testGetTopTenPuntajesReturnsErrorMessageOnFailure()
  {
      $dbManagerMock = $this->createMock(DataBaseManager::class);
      $dbManagerMock->method('realizeQuery')->willReturn(null);

      $playersTop = new PlayersTop($dbManagerMock);
      $result = $playersTop->getTopTenPuntajes();

      $this->assertSame("No se pudo recuperar los puntajes.", $result);
  }

}