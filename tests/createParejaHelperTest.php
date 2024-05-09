<?php
declare(strict_types=1);
include_once('core/php/createParejaHelper.php');
include_once('core/php/DataBaseManager.php');
class createParejaHelperTest extends PHPUnit\Framework\TestCase {
    // Prueba negativa
    public function testSetParejaFailure() {
        $dbMock = $this->createMock(DataBaseManager::class);
        $dbMock->expects($this->once())
            ->method('insertQuery')
            ->willReturn('Error al insertar');
        $helper = new createParejaHelper();
        $helper->setdb($dbMock);
        $result = $helper->setPareja(9, 'concepto', 'descripcion');
        $this->assertEquals('Error al insertar', $result);
    }

    // Prueba positiva
    public function testSetParejaSuccess() {
        $dbMock = $this->createMock(DataBaseManager::class);
        $dbMock->expects($this->once())
            ->method('insertQuery')
            ->willReturn(true);
        $helper = new createParejaHelper();
        $helper->setdb($dbMock);
        $result = $helper->setPareja(1, 'concepto', 'descripcion');
        $this->assertTrue($result);
    }

}
