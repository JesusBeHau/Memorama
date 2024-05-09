<?php
declare(strict_types=1);
include_once('core/php/getAllUsersHelper.php');
include_once('core/php/DataBaseManager.php');
class getAllUsersHelperTest extends PHPUnit\Framework\TestCase{
  //Prueba negativa
  public function testGetAllUsersEmptyTable() {
    $dbMock = $this->createMock(DataBaseManager::class);
    $dbMock->expects($this->once())
        ->method('realizeQuery')
        ->willReturn(null);
    $helper = new getAllUsersHelper();
    $helper->setdb($dbMock);
    $result = $helper->getAllUsers();
    $this->assertEquals("Tabla usuario vacia", $result);
}
  //Prueba positiva
  public function testGetAllUsersSuccess() {
    $resultadosSimulados = [
        ['id' => 1, 'nombre' => 'Usuario 1', 
        'email' => 'usuario1@example.com'], 
        ['id' => 2, 'nombre' => 'Usuario 2', 
        'email' => 'usuario2@example.com'], 
        ['id' => 3, 'nombre' => 'Usuario 3', 
        'email' => 'usuario3@example.com']
    ];
    $dbMock = $this->createMock(DataBaseManager::class);
    $dbMock->expects($this->once())
        ->method('realizeQuery')
        ->willReturn($resultadosSimulados);

    $helper = new getAllUsersHelper();
    $helper->setdb($dbMock);

    $result = $helper->getAllUsers();
    $this->assertJson($result);
    $this->assertEquals(count($resultadosSimulados), count(json_decode($result, true)));
}

}