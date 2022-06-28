<?php

header('Content-Type: application/json');

require_once("../config/conexion.php");
require_once("../model/Torneo.php");

$body = json_decode(file_get_contents("php://input"), true);
$torneo = new Torneo();


switch ($_GET["op"]) {

    case "listarTorneos":
        $datos = $torneo->obtenerListaTorneos();
        echo json_encode($datos);
        break;

    case "torneoPorID":
        $datos = $torneo->obtenerTorneoPorID($body["id"]);
        echo json_encode($datos);
        break;

    case "numeroDeInscritos":
        $datos = $torneo->obtenerEquiposInscritos($body["id"]);
        echo json_encode($datos[0]['inscritos']);
        break;

    case "torneosPorOrganizador":
        $datos = $torneo->obtenerTorneosPorOrganizador($body["organizador"]);
        echo json_encode($datos);
        break;

    case "torneosPorJugador":
        $datos = $torneo->obtenerTorneosDeJugador($body["jugador"]);
        echo json_encode($datos);
        break;

    case "insertarTorneo":
        switch ($torneo->validarToken($body["token"])) {
            case -1:
                echo json_encode("Usuario no autorizado.");
                break;
            case 0:
                echo json_encode("Sesion expirada.");
                break;
            case 1:
                $torneo->renovarToken($body["token"]);
                $datos = $torneo->insertarTorneo(
                        $body["nombre"],
                        $body["juego"],
                        $body["plataforma"],
                        $body["fecha"],
                        $body["hora"],
                        $body["fecha_max"],
                        $body["tipo_torneo"],
                        $body["localizacion"],
                        $body["premio"],
                        $body["tipo_enfrentamiento"],
                        $body["num_participantes"],
                        $body["organizador"],
                        $body["comunicacion"]);

                if ($datos == 1)
                    echo json_encode("Torneo registrado correctamente");
                else if ($datos == 0)
                    echo json_encode("ERROR: Ya existe un torneo con ese nombre.");
                break;
        }
        break;

    case "borrarTorneo":
        switch ($torneo->validarToken($body["token"])) {
            case -1:
                echo json_encode("Usuario no autorizado.");
                break;
            case 0:
                echo json_encode("Sesion expirada.");
                break;
            case 1:
                $torneo->renovarToken($body["token"]);
                $torneo->borrarTorneo($body["id"]);
                echo json_encode("Torneo eliminado correctamente");
                break;
        }
        break;
    
    case "actualizarTorneo":
        switch ($torneo->validarToken($body["token"])) {
            case -1:
                echo json_encode("Usuario no autorizado.");
                break;
            case 0:
                echo json_encode("Sesion expirada.");
                break;
            case 1:
                $torneo->renovarToken($body["token"]);
                $inscritos = $torneo->obtenerEquiposInscritos($body["id"]);

                if ($inscritos[0]['inscritos'] > $body["num_participantes"]) {
                    echo json_encode("No se pueden fijar menos participantes"
                            . " de los ya inscritos: ");
                } else {
                    $datos = $torneo->actualizarTorneo(
                            $body["id"],
                            $body["nombre"],
                            $body["fecha"],
                            $body["hora"],
                            $body["fecha_max"],
                            $body["tipo_torneo"],
                            $body["localizacion"],
                            $body["premio"],
                            $body["tipo_enfrentamiento"],
                            $body["num_participantes"],
                            $body["comunicacion"]);

                    if ($datos == 1)
                        echo json_encode("Torneo actualizado correctamente.");
                    else if ($datos == 0)
                        echo json_encode("ERROR: ya existe un torneo con ese nombre.");
                }
                break;
        }
        break;
}
?>

