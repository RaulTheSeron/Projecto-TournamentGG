<?php

class Equipo extends Conexion {

    public function obtenerListadoDeInscritosEnTorneo($idTorneo) {
        $conexion = parent::conectarBD();
        $sql = "SELECT * FROM equipo WHERE torneo = ?";
        $sql = $conexion->prepare($sql);
        $sql->bindValue(1, $idTorneo);
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function insertarEquipo($idTorneo, $idLider, $jugador1, $jugador2,
            $jugador3, $jugador4, $jugador5) {
        $conexion = parent::conectarBD();
        $sql = "INSERT INTO equipo"
                . "(torneo, "
                . "lider, "
                . "jugador1, "
                . "jugador2, "
                . "jugador3, "
                . "jugador4, "
                . "jugador5) "
                . "VALUES (?,?,?,?,?,?,?)";
        $sql = $conexion->prepare($sql);
        $sql->bindValue(1, $idTorneo);
        $sql->bindValue(2, $idLider);
        $sql->bindValue(3, $jugador1);
        $sql->bindValue(4, $jugador2);
        $sql->bindValue(5, $jugador3);
        $sql->bindValue(6, $jugador4);
        $sql->bindValue(7, $jugador5);

        if ($sql->execute())
            return 1;
        else
            return 0;
    }

    public function borrarEquipo($idTorneo, $idJugador) {
        $conexion = parent::conectarBD();
        $sql = "DELETE FROM equipo "
                . "WHERE torneo = ? "
                . "AND (lider = ? "
                . "or jugador1 = ? "
                . "or jugador2 = ? "
                . "or jugador3 = ? "
                . "or jugador4 = ? "
                . "or jugador5 = ?) ";
        $sql = $conexion->prepare($sql);
        $sql->bindValue(1, $idTorneo);
        $sql->bindValue(2, $idJugador);
        $sql->bindValue(3, $idJugador);
        $sql->bindValue(4, $idJugador);
        $sql->bindValue(5, $idJugador);
        $sql->bindValue(6, $idJugador);
        $sql->bindValue(7, $idJugador);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function comprobarInscripcionEnTorneo($idTorneo, $idJugador) {
        $conexion = parent::conectarBD();
        $sql = "SELECT * FROM equipo "
                . "WHERE torneo = ? "
                . "AND (lider = ? "
                . "OR jugador1 = ? "
                . "OR jugador2 = ? "
                . "OR jugador3 = ? "
                . "OR jugador4 = ? "
                . "OR jugador5 = ?)";
        $sql = $conexion->prepare($sql);
        $sql->bindValue(1, $idTorneo);
        $sql->bindValue(2, $idJugador);
        $sql->bindValue(3, $idJugador);
        $sql->bindValue(4, $idJugador);
        $sql->bindValue(5, $idJugador);
        $sql->bindValue(6, $idJugador);
        $sql->bindValue(7, $idJugador);
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }
}
?>
