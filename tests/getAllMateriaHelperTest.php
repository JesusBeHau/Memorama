<?php
declare(strict_types=1);
include_once('core/php/getAllMateriaHelper.php');
include_once('core/php/DataBaseManager.php');

class getAllMateriaHelperTest extends PHPUnit\Framework\TestCase{
    //Prueba negativa
    public function testGetAllMateriaEmptyTable() {
      $dbMock = $this->createMock(DataBaseManager::class);
      $dbMock->expects($this->once())
          ->method('realizeQuery')
          ->willReturn(null);
  
      $helper = new getAllMateriaHelper();
      $helper->setdb($dbMock);
      $result = $helper->getAllMateria();
  
      // Verificar que el método devuelve el mensaje adecuado para una tabla vacía
      $this->assertEquals("tabla materia vacia", $result);
  }
  
  //Preuba positiva
  public function testGetAllMateriaSuccess() {
    $dbMock = $this->createMock(DataBaseManager::class);
    $resultadosSimulados = [
      ['id' => 1, 'nombre' => 'Materia 1'], 
    ['id' => 2, 'nombre' => 'Materia 2'], 
    ['id' => 3, 'nombre' => 'Materia 3']
  ];
    $dbMock->expects($this->once())
        ->method('realizeQuery')
        ->willReturn($resultadosSimulados);

    $helper = new getAllMateriaHelper();
    $helper->setdb($dbMock);

    $result = $helper->getAllMateria();
    $this->assertJson($result);
    $this->assertEquals(3, count(json_decode($result, true)));
  }

}
