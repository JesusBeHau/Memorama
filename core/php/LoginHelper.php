<?php
class LoginHelper{
    protected $db;
    protected $sesion;
    public function setDb($databaseManager){
        $this->db = $databaseManager;
    }
    public function setSesion($sesion){
        $this->sesion = $sesion;
    }
    public function verifyLogin($username, $password) {
        $query = "Select * FROM usuario WHERE 
        nombre = '$username' AND clave= '$password'";
        $result = $this->db->realizeQuery($query);
        $message = null;
        if(count($result) > 0){
            $user = array();
            $user['type'] = $result[0]['tipo'];
            $this->sesion->set("user",$result[0]['id']);
            $usersList[] = $user;
            echo json_encode($usersList);
        }else{
            echo json_encode($message);
        }
    }

}
