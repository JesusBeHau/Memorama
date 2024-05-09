<?php declare(strict_types=1);
include_once('core/php/LoginHelper.php');
include_once('core/php/DataBaseManager.php');
include_once('core/php/Session.php');

class LoginHelperTest extends PHPUnit\Framework\TestCase {
    protected $lh;

    protected function setUp(): void {
        $this->lh = new LoginHelper;
    }

    protected function tearDown(): void {
    }

    public function testVerifyLoginFailure() {
        $ses = $this->createMock(session::class);
        $db = $this->createMock(DataBaseManager::class);
        $db->method('realizeQuery')->willReturn(array());
        $this->lh->setSesion($ses);
        $this->lh->setDb($db);
        ob_start();
        $this->lh->verifyLogin("u", "incorrect_password"); // Contraseña incorrecta
        $response = ob_get_contents();
        ob_end_clean();
        $this->assertEquals('null', $response); // Esperamos que la respuesta sea 'null' para una contraseña incorrecta
    }

    public function testVerifyLogin() {
        $ses = $this->createMock(session::class);
        $db = $this->createMock(DataBaseManager::class);
        $db->method('realizeQuery')->willReturn(array(0 => array("id" => 1, "nombre" => "u", "tipo" => 0, "clave" => "p")));
        $this->lh->setSesion($ses);
        $this->lh->setDb($db);
        ob_start();
        $this->lh->verifyLogin("u", "p");
        $response = ob_get_contents();
        ob_end_clean();
        $this->assertNotNull(json_decode($response, false));
        $userResponse = json_decode($response, false);
        $this->assertNotNull($userResponse);
        $val = $userResponse[0]->type;
        $this->assertEquals($val, 0);
    }
}
