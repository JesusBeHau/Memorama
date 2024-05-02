<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../core/php/MateriasManager.php';

class MateriasManagerTest extends TestCase{
    private $MM;

    public function setUp():void{
        $this->MM=MateriasManager::getInstance();
    }

    //PRUEBAS POSITIVAS
    public function testGetMateria(){
        $idMateria = 1;
        $result = $this->MM->getMateria($idMateria);
        //verificar que el resultado no esta vacío, ya que la materia con id 1 si existe en BD
        $this->assertNotNull($result);
    }

    //PRUEBAS NEGATIVAS
    public function testGetMateriaNotExists(){
        $idMateria = 999;
        $result = $this->MM->getMateria($idMateria);
        //verificar que el resultado es null, ya que la materia con id 999 no existe en BD
        $this->assertNull($result);
    }
}


