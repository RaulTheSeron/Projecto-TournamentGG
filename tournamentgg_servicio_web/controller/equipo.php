<?php

header('Content-Type: application/json');

require_once("../config/conexion.php");
require_once("../model/Equipo.php");

$body = json_decode(file_get_contents("php://input"), true);
$equipo = new Equipo();

switch ($_GET['op']) {

    case "listarInscritos":
        $datos = $equipo->obtenerListadoDeInscritosEnTorneo($body["torneo"]);
        echo json_encode($datos);
        break;

    case "insertarEquipo":
        switch ($equipo->validarToken($body["token"])) {
            case -1:
                echo json_encode("Usuario no autorizado.");
                break;
            case 0:
                echo json_encode("Sesion expirada.");
                break;
            case 1:
                $equipo->renovarToken($body["token"]);
                $datos = $equipo->insertarEquipo(
                        $body["torneo"],
                        $body["lider"],
                        $body["jugador1"],
                        $body["jugador2"],
                        $body["jugador3"],
                        $body["jugador4"],
                        $body["jugador5"]);
                if ($datos == 1)
                    echo json_encode("Inscripcion realizada!");
                else if ($datos == 0)
                    echo json_encode("ERROR: No ha sido posible inscribirse al torneo.");
                break;
        }
        break;

    case "borrarEquipo":
        switch ($equipo->validarToken($body["token"])) {
            case -1:
                echo json_encode("Usuario no autorizado.");
                break;
            case 0:
                echo json_encode("Sesion expirada.");
                break;
            case 1:
                $equipo->renovarToken($body["token"]);
                $equipo->borrarEquipo(
                        $body["torneo"],
                        $body["jugador"]);
                echo json_encode("Inscripcion anulada.");
                break;
        }
        break;

    case "comprobarInscripcion":
        $datos = $equipo->comprobarInscripcionEnTorneo($body["idTorneo"], $body["idJugador"]);
        if ($datos == null) {
            echo json_encode("false");
        } else {
            echo json_encode("true");
        }
        break;
}
?>