<?php

header('Content-Type: application/json');

require_once("../config/conexion.php");
require_once("../model/Usuario.php");

$body = json_decode(file_get_contents("php://input"), true);
$usuario = new Usuario();

switch ($_GET["op"]) {

    case "listarUsuarios":
        $datos = $usuario->obtenerListaUsuarios();
        echo json_encode($datos);
        break;

    case "usuarioPorID":
        switch ($usuario->validarToken($body["token"])) {
            case -1:
                echo json_encode("Usuario no autorizado.");
                break;
            case 0:
                echo json_encode("Sesion expirada.");
                break;
            case 1:
                $usuario->renovarToken($body["token"]);

                $datos = $usuario->obtenertUsuarioPorID($body["id"]);
                echo json_encode($datos);
                break;
        }
        break;

    case "comprobarLogin":
        $datos = $usuario->comprobarLogin(
                $body["usuario"],
                encriptarContraseña($body["pass"]));

        if ($datos != null) {
            
            if ($datos[0]['estado'] == 1) {
                $nombreUsuario = $body["usuario"];
                $id = $datos[0]['id'];
                $permisos = $datos[0]['permisos'];
                $token = $usuario->generarToken($id, $nombreUsuario);
                $tokenEncriptado = $usuario->encriptarToken($token);
                $usuario->actualizarToken($id, $tokenEncriptado, $token["exp"]);

                echo json_encode([["id" => $id, "permisos" => $permisos, "token" => $tokenEncriptado]]);
            } else {
                echo json_encode("La cuenta del usuario indicado está suspendida", JSON_UNESCAPED_UNICODE);
            }
        } else
            echo json_encode("Usuario o contraseña incorrectos", JSON_UNESCAPED_UNICODE);
        break;

    case "existeUsuario":
        $datos = $usuario->comprobarExistenciaUsuario(
                $body["nombre"],
                $body["correo"]);

        if ($datos == null) {
            echo json_encode("false");
        } else {
            echo json_encode("true");
        }
        break;

    case "obtenerIdUsuario":
        $datos = $usuario->comprobarExistenciaUsuario(
                $body["nombre"],
                $body["correo"]);

        if ($datos == null) {
            echo json_encode("Uno de los usuarios indicados no existe");
        } else {
            echo json_encode($datos[0]["id"]);
        }
        break;


    case "insertarUsuario":
        $datos = $usuario->insertarUsuario(
                $body["nombre"],
                encriptarContraseña($body["pass"]),
                $body["fecna"],
                $body["correo"],
                $body["permisos"],
                $body["avatar"],
                $body["estado"]);

        if ($datos == 1)
            echo json_encode("Cuenta registrada correctamente");
        else if ($datos == 0)
            echo json_encode("Ha habido un error al registrar la cuenta");
        break;

    case "borrarUsuario":
        switch ($usuario->validarToken($body["token"])) {
            case -1:
                echo json_encode("Usuario no autorizado.");
                break;
            case 0:
                echo json_encode("Sesion expirada.");
                break;
            case 1:
                $usuario->renovarToken($body["token"]);
                $datos = $usuario->borrarUsuario($body["id"]);
                echo json_encode("Usuario eliminado correctamente");
                break;
        }
        break;

    case "actualizarUsuario":
        switch ($usuario->validarToken($body["token"])) {
            case -1:
                echo json_encode("Usuario no autorizado.");
                break;
            case 0:
                echo json_encode("Sesion expirada.");
                break;
            case 1:
                $usuario->renovarToken($body["token"]);
                $datos = $usuario->actualizarUsuario(
                        $body["nombre"],
                        $body["fecna"],
                        $body["correo"],
                        $body["permisos"],
                        $body["avatar"],
                        $body["estado"],
                        $body["id"]);
                echo json_encode("Cambios realizados correctamente");
                break;
        }
        break;

    case "comprobarContraseña":
        $datos = $usuario->comprobarContraseñaPorID($body["id"], encriptarContraseña($body["pass"]));

        if ($datos != null) {
            echo json_encode("true");
        } else {
            echo json_encode("false");
        }
        break;

    case "cambiarContraseña":
        $usuario->cambiarPass($body["id"], encriptarContraseña($body["pass"]));
        echo json_encode("Cambios realizados correctamente");
        break;

    case "CambioEstadoUsuario":
        switch ($usuario->validarToken($body["token"])) {
            case -1:
                echo json_encode("Usuario no autorizado.");
                break;
            case 0:
                echo json_encode("Sesion expirada.");
                break;
            case 1:
                $usuario->renovarToken($body["token"]);
                $datos = $usuario->cambiarEstadoUsuario(
                        $body["id"],
                        $body["estado"]);

                if (($body["estado"]) == "0") {
                    echo json_encode("Usuario " . $body["id"] . " baneado");
                } else {
                    echo json_encode("Usuario " . $body["id"] . " activado");
                }
                break;
        }
        break;
}

function encriptarContraseña($contraseña) {
    return( md5($contraseña) );
}

?>