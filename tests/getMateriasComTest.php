<?php
declare(strict_types=1);
include_once('core/php/MateriaManagerComplet.php');
include_once('core/php/DataBaseManager.php');

class getMateriasComTest extends PHPUnit\Framework\TestCase{
  //Preuba positiva
  public function testGetAllMateriaCompletSuccess() {
    $dbMock = $this->createMock(DataBaseManager::class);
    $resultadosSimulados = [
      ['id' => 1, 'nombre' => 'Materia 1'], 
    ['id' => 2, 'nombre' => 'Materia 2']
  ];

    $dbMock->expects($this->once())
        ->method('realizeQuery')
        ->willReturn($resultadosSimulados);

    $helper = new MateriaManagerComplet($dbMock);

    $result = $helper->getAllMateriaComplet();
    $this->assertJson($result);
    $this->assertEquals(2, count(json_decode($result, true)));
  }

    //Prueba negativa
    public function testGetAllMateriaCompletEmptyTable() {
      $dbMock = $this->createMock(DataBaseManager::class);
      $dbMock->expects($this->once())
          ->method('realizeQuery')
          ->willReturn(null);
  
      $helper = new MateriaManagerComplet($dbMock);
      $result = $helper->getAllMateriaComplet();
      
      // Verificar que el método devuelve el mensaje adecuado para una tabla vacía
      $this->assertEquals("tabla materia vacia", $result);
    }

}
