<?php
declare(strict_types=1);
include_once('core/php/createUserHelper.php');
include_once('core/php/DataBaseManager.php');

class createUserHelperTest extends PHPUnit\Framework\TestCase {
  //Prueba negativa
  public function testCreateUserFailure()
  {
    $dbMock = $this->createMock(DataBaseManager::class);
    $dbMock->expects($this->once())
      ->method('insertQuery')
      ->willReturn(false);
      $helper = new createUserHelper();
      $helper->setdb($dbMock);
      $result = $helper->setUser("Rodrigo","12345",10);
    $this->assertFalse($result);
  }
  //Prueba positiva
  public function testCreateUserSuccess()
  {
    // Mock para DataBaseManager
    $dbMock = $this->createMock(DataBaseManager::class);
    $dbMock->expects($this->once())
      ->method('insertQuery')
      ->willReturn(true);
    $helper = new createUserHelper();
    $helper->setdb($dbMock);
    $result = $helper->setUser("Rodrigo","12345",0);
    $this->assertTrue($result);
  }

}
