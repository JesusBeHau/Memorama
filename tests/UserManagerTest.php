<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../core/php/userManager.php';

class UserManagerTest extends TestCase{
    private $UM;

    public function setUp():void{
        $this->UM=userManager::getInstance();
    }

    //PRUEBAS POSITIVAS
    public function testSetUser(){
        $name='Juan';
        $password='JuanPass';
        $tipo=0;
        $result = $this->UM->setUser($name, $password, $tipo);
        //el usuario debe insertarse correctamente, y debe devolver un true
        $this->assertTrue($result);
    }

    public function testGetUser(){
        $name = 'pepe';
        $password = 'camello';
        $result = $this->UM->getUser($name, $password);
        //usuario y contraseña correcta, debe devolver el usuario
        $this->assertNotNull($result);
    }

    public function testGetUserById(){
        $id = 1;
        $result = $this->UM->getUserById($id);
        //existe el usuario con el id 1, por lo que no debe devolver null
        $this->assertNotNull($result);
    }

    //PRUEBAS NEGATIVAS
    public function testSetUserExistingt(){
        $name='pepe';
        $password='pepePass';
        $tipo=0;
        $result = $this->UM->setUser($name, $password, $tipo);
        //el usuario no debe insertarse ya que ya existe otro con ese nombre
        //por lo que debe devolver false
        $this->assertFalse($result);
    }

    public function testGetUserNotExists(){
        $name = 'pepe';
        $password = 'pepepassword';
        $result = $this->UM->getUser($name, $password);
        //usuario y contraseña incorrecta, debe devolver un NULL
        $this->assertNull($result);
    }

    public function testGetUserByIdNotExists(){
        $id = 999;
        $result = $this->UM->getUserById($id);
        //no existe el usuario con el id 999, por lo que debe devolver null
        $this->assertNull($result);
    }
}