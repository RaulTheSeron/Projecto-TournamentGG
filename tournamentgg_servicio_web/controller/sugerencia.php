<?php

header('Content-Type: application/json');

require_once("../config/conexion.php");
require_once("../model/Sugerencia.php");

$body = json_decode(file_get_contents("php://input"), true);
$sugerencia = new Sugerencia();


switch ($_GET["op"]) {

    case "listarSugerencias":
        $datos = $sugerencia->obtenerListaSugerencias();
        echo json_encode($datos);
        break;

    case "sugerenciaPorID":
        $datos = $sugerencia->obtenerSugerenciaPorID($body["id"]);
        echo json_encode($datos);
        break;

    case "insertarSugerencia":
        switch ($sugerencia->validarToken($body["token"])) {
            case -1:
                echo json_encode("Usuario no autorizado.");
                break;
            case 0:
                echo json_encode("Sesion expirada.");
                break;
            case 1:
                $sugerencia->renovarToken($body["token"]);
                $sugerencia->insertarSugerencia(
                        $body["usuario"],
                        $body["asunto"],
                        $body["descripcion"]);
                echo json_encode("Sugerencia enviada correctamente");
                break;
        }
        break;

    case "borrarSugerencia":
        switch ($sugerencia->validarToken($body["token"])) {
            case -1:
                echo json_encode("Usuario no autorizado.");
                break;
            case 0:
                echo json_encode("Sesion expirada.");
                break;
            case 1:
                $sugerencia->renovarToken($body["token"]);
                $sugerencia->borrarSugerencia($body["id"]);
                echo json_encode("Sugerencia eliminada");
                break;
        }
        break;
}
?>

