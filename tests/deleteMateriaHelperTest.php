<?php
declare(strict_types=1);
include_once('core/php/deleteMateriaHelper.php');
include_once('core/php/DataBaseManager.php');
class deleteMateriaHelperTest extends PHPUnit\Framework\TestCase {
  //Prueba negativa
  public function testDeleteMateriaFailure()
  {
    $dbMock = $this->createMock(DataBaseManager::class);
    $dbMock->expects($this->once())
      ->method('insertQuery')
      ->willReturn(false);
      $helper = new deleteMateriasHelper();
      $helper->setdb($dbMock);
      $result = $helper->deleteMateria('10');
    $this->assertFalse($result);
  }
  //Prueba positiva
  public function testDeleteMateriaSuccess()
  {
    // Mock para DataBaseManager
    $dbMock = $this->createMock(DataBaseManager::class);
    $dbMock->expects($this->once())
      ->method('insertQuery')
      ->willReturn(true);
    $helper = new deleteMateriasHelper();
    $helper->setdb($dbMock);
    $result = $helper->deleteMateria('1');
    $this->assertTrue($result);
  }


}
