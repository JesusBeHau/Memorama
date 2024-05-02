<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../core/php/PuntajesManajer.php';

class PuntajesManagerTest extends TestCase{
    private $PM;

    public function setUp():void{
        $this->PM=PuntajesManajer::getInstance();
    }

    //PRUEBAS POSITIVAS
    public function testSetPuntaje(){
        $idUsuario = 1;
        $idMateria = 2;
        $fecha = '2024-02-28';
        $dificultad = 'facil';
        $puntaje = 90;
        $foundPeers = 10;

        $result = $this->PM->setPuntaje($idUsuario, $idMateria, $fecha, $dificultad, $puntaje, $foundPeers);
        // Verificar que el resultado es una cadena vacía, lo que indica que el puntaje se estableció correctamente
        $this->assertSame('', $result);
    }

    public function testGetAllPuntajesForUsario(){
        $idUsuario = 1;
        $result = $this->PM->getAllPuntajeForUsuario($idUsuario);
        //le pasamos el ID de un usuario que si existe así que esperamos que devuelva un valor
        $this->assertNotEmpty($result);
    }

    public function testGetAllPuntajeForMateria(){
        $idMateria = 1;
        $result = $this->PM->getAllPuntajeForMateria($idMateria);
        //le pasamos el ID de una materia que existe en BD, así que esperamos que devuelva un valor no nulo
        $this->assertNotEmpty($result);
    }

    public function testGetAllPuntajeForUsuarioAndMateria(){
        $idUsuario = 1;
        $idMateria = 1;
        $result = $this->PM->getAllPuntajeForUsuarioAndMateria($idUsuario, $idMateria);
        //le pasamos datos de un registro que existe en BD, así que esperamos que devuelva un valor no nulo
        $this->assertNotNull($result);
    }

    public function testGetAllPuntajeForMateriaAndDificultad(){
        $idMateria = 1;
        $dificultad = 'facil';
        $result = $this->PM->getAllPuntajeForMateriaAndDificultad($idMateria, $dificultad);
        //le pasamos datos de un registro que existe en BD, así que esperamos que devuelva un valor no nulo
        $this->assertNotNull($result);
    }

    public function testGetAllPuntajeForUsuarioAndMateriaAndDificultad(){
        $idUsuario = 1;
        $idMateria = 1;
        $dificultad = 'facil';
        $result = $this->PM->getAllPuntajeForUsuarioAndMateriaAndDificultad($idUsuario, $idMateria, $dificultad);
        //le pasamos datos de un registro que existe en BD, así que esperamos que devuelva un valor no nulo
        $this->assertNotNull($result);
    }

    //PRUEBAS NEGATIVAS
    public function testSetPuntajeExistingId(){
        $idUsuario = 1;
        $idMateria = 1;
        $fecha = '2024-02-28';
        $dificultad = 'facil';
        $puntaje = 90;
        $foundPeers = 10;

        $result = $this->PM->setPuntaje($idUsuario, $idMateria, $fecha, $dificultad, $puntaje, $foundPeers);
        //Ya existe en la BD un puntaje correspondiente al usuario 1 en la materia 1, por lo que debe devolver el mensaje de error
        $this->assertSame("Error al insertar el puntaje", $result);
    }

    public function testGetAllPuntajesForUsarioNotExists(){
        $idUsuario = 999;
        $result = $this->PM->getAllPuntajeForUsuario($idUsuario);
        //le pasamos el ID de un usuario que no existe así que esperamos que devuelva el mensaje "tabla materia vacia"
        $this->assertNull($result);
    }

    public function testGetAllPuntajeForNotExists(){
        $idMateria = -1;
        $result = $this->PM->getAllPuntajeForMateria($idMateria);
        //le pasamos el ID de una materia que no existe en BD, así que esperamos que devuelva un NULL
        $this->assertNull($result);
    }
    
    public function testGetAllPuntajeForUsuarioAndMateriaNotExists(){
        $idUsuario = 999;
        $idMateria = 1;
        $result = $this->PM->getAllPuntajeForUsuarioAndMateria($idUsuario, $idMateria);
        //le pasamos datos de un registro que no existe en BD, así que esperamos que devuelva un NULL
        $this->assertNull($result);
    }
    
    public function testGetAllPuntajeForMateriaAndDificultadNotExists(){
        $idMateria = 1;
        $dificultad = 'dificil';
        $result = $this->PM->getAllPuntajeForMateriaAndDificultad($idMateria, $dificultad);
        //le pasamos datos de un registro que no existe en BD, así que esperamos que devuelva un valor nulo
        $this->assertNull($result);
    }

    public function testGetAllPuntajeForUsuarioAndMateriaAndDificultadNotExists(){
        $idUsuario = 1;
        $idMateria = 999;
        $dificultad = 'facil';
        $result = $this->PM->getAllPuntajeForUsuarioAndMateriaAndDificultad($idUsuario, $idMateria, $dificultad);
        //le pasamos datos de un registro que no existe en BD, así que esperamos que devuelva un valor nulo
        $this->assertNull($result);
    }
}