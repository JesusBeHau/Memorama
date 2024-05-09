<?php
declare(strict_types=1);
include_once('core/php/getAllParejasMateriaHelper.php');
include_once('core/php/DataBaseManager.php');
class getAllParejasMateriaHelperTest extends PHPUnit\Framework\TestCase{
  //Prueba negativa
  public function testGetAllParejasTheMateriaEmptyResult() {
    $dbMock = $this->createMock(DataBaseManager::class);
    // Configurar el mock para devolver null, simulando una tabla de parejas vacía
    $dbMock->expects($this->once())
        ->method('realizeQuery')
        ->willReturn(null);

    $helper = new getAllParejasMateriaHelper();
    $helper->setdb($dbMock);
    $result = $helper->getAllParejasTheMateria(2); 
    $this->assertEquals("", $result);
  }
  //Preuba positiva
  public function testGetAllParejasTheMateriaSuccess() {
    $dbMock = $this->createMock(DataBaseManager::class);
    $resultadosSimulados = [['concepto' => 'Concepto 1',
    'descripcion' => 'Descripción 1'],
      ['concepto' => 'Concepto 2', 
      'descripcion' => 'Descripción 2']];
    $dbMock->expects($this->once())
        ->method('realizeQuery')
        ->willReturn($resultadosSimulados);
    $helper = new getAllParejasMateriaHelper();
    $helper->setdb($dbMock);

    $result = $helper->getAllParejasTheMateria(1);
    $this->assertJson($result);
    // Verificar que se devuelven 2 parejas
    $this->assertEquals(2, count(json_decode($result, true))); 
  }

}