<?php
require_once 'UserManager.php';

$response = array(); // Para almacenar la respuesta a enviar al cliente

// Comprueba si se proporcionaron los parámetros requeridos
if (isset($_POST['name']) && isset($_POST['password'])) {
    $name = $_POST['name'];
    $password = $_POST['password'];

    // Instancia del gestor de usuarios
    $userManager = UserManager::getInstance();

    // Llama al método para actualizar la contraseña
    $updateResult = $userManager->updatePassword($name, $password);

    if ($updateResult === "") {
        $response['status'] = "success";
        $response['message'] = "Contraseña actualizada con éxito.";
    } else {
        $response['status'] = "error";
        $response['message'] = "Error al actualizar la contraseña.";
    }
} else {
    $response['status'] = "error";
    $response['message'] = "Datos incompletos.";
}

// Devolver la respuesta como JSON
echo json_encode($response);
?>
