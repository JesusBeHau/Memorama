<?php
declare(strict_types=1);
include_once('core/php/getAllParejasHelper.php');
include_once('core/php/DataBaseManager.php');
class getAllParejasHelperTest extends PHPUnit\Framework\TestCase{
  // Prueba negativa
  public function testGetAllParejasEmptyTable() {
    $dbMock = $this->createMock(DataBaseManager::class);
    $dbMock->expects($this->once())
        ->method('realizeQuery')
        ->willReturn(null);

    $helper = new getAllParejasHelper();
    $helper->setdb($dbMock);

    $result = $helper->getAllParejas();

    $this->assertEquals("tabla materia vacia", $result);
  }
  
  // Prueba positiva
  public function testGetAllParejasSuccess() {
    // Simular datos de parejas
    $resultadosSimulados = [];
    for ($i = 1; $i <= 10; $i++) {
        $resultadosSimulados[] = [
            'id' => $i,'idmateria' => rand(1, 5), 
            'concepto' => "Concepto $i",'descripcion' => "Descripción $i"
        ];
    }
    $dbMock = $this->createMock(DataBaseManager::class);
    $dbMock->expects($this->once())
        ->method('realizeQuery')
        ->willReturn($resultadosSimulados);
    $helper = new getAllParejasHelper();
    $helper->setdb($dbMock);

    $result = $helper->getAllParejas();
    // Verificar que el método devuelve un JSON con los datos de todas las parejas
    $this->assertJson($result);
    $this->assertEquals(10, count(json_decode($result, true)));
}


}