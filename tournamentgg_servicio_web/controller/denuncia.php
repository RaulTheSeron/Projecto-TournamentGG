<?php

header('Content-Type: application/json');

require_once("../config/conexion.php");
require_once("../model/Denuncia.php");

$body = json_decode(file_get_contents("php://input"), true);
$denuncia = new Denuncia();

switch ($_GET["op"]) {

    case "listarDenuncias":
        $datos = $denuncia->obtenerListaDenuncias();
        echo json_encode($datos);
        break;

    case "denunciaPorID":
        $datos = $denuncia->obtenerDenunciaPorID($body["id"]);
        echo json_encode($datos);
        break;

    case "denunciasDeUsuario":
        $datos = $denuncia->obtenerDenunciasDeUsuario($body["id"]);
        echo json_encode($datos);
        break;

    case "listaUsuariosConIndicencias":
        $datos = $denuncia->obtenerListaUsuariosConIncidencias();
        echo json_encode($datos);
        break;

    case "insertarDenuncia":
        switch ($denuncia->validarToken($body["token"])) {
            case -1:
                echo json_encode("Usuario no autorizado.");
                break;
            case 0:
                echo json_encode("Sesion expirada.");
                break;
            case 1:
                $denuncia->renovarToken($body["token"]);
                $datos = $denuncia->insertarDenuncia(
                        $body["denunciado"],
                        $body["denunciante"],
                        $body["asunto"],
                        $body["descripcion"]);
                echo json_encode("Reporte creado");
                break;
        }
        break;

    case "borrarDenuncia":
        switch ($denuncia->validarToken($body["token"])) {
            case -1:
                echo json_encode("Usuario no autorizado.");
                break;
            case 0:
                echo json_encode("Sesion expirada.");
                break;
            case 1:
                $denuncia->renovarToken($body["token"]);
                $denuncia->borrarDenuncia($body["id"]);
                echo json_encode("Denuncia elminada");
                break;
        }
        break;
}
?>
