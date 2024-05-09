<?php
declare(strict_types=1);
include_once('core/php/setPuntajeHelper.php');
include_once('core/php/DataBaseManager.php');
class setPuntajeHelperTest extends PHPUnit\Framework\TestCase {
    //Prueba mala
    public function testSetPuntajeFailure() {
        
        $dbMock = $this->createMock(DataBaseManager::class);
        $dbMock->expects($this->once())
            ->method('insertQuery')
            ->willReturn(false);

        $helper = new setPuntajeHelper();
        $helper->setdb($dbMock);
        $result = $helper->setPuntaje('1', '2', '20241-s0-15', 'extra', 90, 10);
        $this->assertFalse($result);
    }

  //Prueba buena
  public function testSetPuntajeSuccess() {
    $dbMock = $this->createMock(DataBaseManager::class);
    $dbMock->expects($this->once())
        ->method('insertQuery')
        ->willReturn(true);
    $helper = new setPuntajeHelper();
    $helper->setdb($dbMock);

    $result = $helper->setPuntaje('1', '10', '2024-04-15', 'facil', 100, 10);
    $this->assertTrue($result);
}

}
