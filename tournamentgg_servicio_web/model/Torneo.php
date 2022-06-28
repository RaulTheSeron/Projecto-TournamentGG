<?php

class Torneo extends Conexion {

    public function obtenerListaTorneos() {
        $conexion = parent::conectarBD();
        $sql = "SELECT * FROM torneo";
        $sql = $conexion->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function obtenerTorneoPorID($idTorneo) {
        $conexion = parent::conectarBD();
        $sql = "SELECT * FROM torneo WHERE id = ?";
        $sql = $conexion->prepare($sql);
        $sql->bindValue(1, $idTorneo);
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC); 
        return $resultado; 
    }

    public function obtenerTorneosPorOrganizador($organizador) {
        $conexion = parent::conectarBD();
        $sql = "SELECT * FROM torneo WHERE organizador = ? ";
        $sql = $conexion->prepare($sql);
        $sql->bindValue(1, $organizador);
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function obtenerEquiposInscritos($idTorneo) {
        $conexion = parent::conectarBD();
        $sql = "select COUNT(lider) as inscritos from equipo where torneo = ?";
        $sql = $conexion->prepare($sql);
        $sql->bindValue(1, $idTorneo);
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function obtenerTorneosDeJugador($idJugador) {
        $conexion = parent::conectarBD();
        $sql = "SELECT * FROM torneo WHERE id in "
                . "(select torneo from equipo where "
                . "lider = ?"
                . "or jugador1 = ?"
                . "or jugador2 = ?"
                . "or jugador3 = ?"
                . "or jugador4 = ?"
                . "or jugador5 = ?)";
        $sql = $conexion->prepare($sql);
        $sql->bindValue(1, $idJugador);
        $sql->bindValue(2, $idJugador);
        $sql->bindValue(3, $idJugador);
        $sql->bindValue(4, $idJugador);
        $sql->bindValue(5, $idJugador);
        $sql->bindValue(6, $idJugador);
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function insertarTorneo($nombre, $juego, $plataforma, $fecha, $hora,
            $fecha_max, $tipo_torneo, $localizacion, $premio, $tipo_enfrentamiento,
            $num_participantes, $organizador, $comunicacion) {
        $conexion = parent::conectarBD();
        $sql = "INSERT INTO torneo("
                . "nombre, "
                . "juego, "
                . "plataforma, "
                . "fecha, "
                . "hora, "
                . "fecha_max, "
                . "tipo_torneo, "
                . "localizacion, "
                . "premio, "
                . "tipo_enfrentamiento, "
                . "num_participantes, "
                . "organizador, "
                . "comunicacion) "
                . "VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $sql = $conexion->prepare($sql);
        $sql->bindValue(1, $nombre);
        $sql->bindValue(2, $juego);
        $sql->bindValue(3, $plataforma);
        $sql->bindValue(4, $fecha);
        $sql->bindValue(5, $hora);
        $sql->bindValue(6, $fecha_max);
        $sql->bindValue(7, $tipo_torneo);
        $sql->bindValue(8, $localizacion);
        $sql->bindValue(9, $premio);
        $sql->bindValue(10, $tipo_enfrentamiento);
        $sql->bindValue(11, $num_participantes);
        $sql->bindValue(12, $organizador);
        $sql->bindValue(13, $comunicacion);

        if ($sql->execute())
            return 1;
        else
            return 0;
    }

    public function borrarTorneo($id) {
        $conexion = parent::conectarBD();
        $sql = "DELETE FROM torneo WHERE id = ? ";
        $sql = $conexion->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();
    }

    public function actualizarTorneo($idTorneo, $nombre, $fecha, $hora, $fecha_max,
            $tipo_torneo, $localizacion, $premio, $tipo_enfrentamiento,
            $num_participantes, $comunicacion) {
        $conexion = parent::conectarBD();
        $sql = "UPDATE torneo SET "
                . "nombre = ?,"
                . "fecha = ?,"
                . "hora = ?,"
                . "fecha_max = ?,"
                . "tipo_torneo = ?,"
                . "localizacion = ?,"
                . "premio = ?,"
                . "tipo_enfrentamiento = ?,"
                . "num_participantes = ?,"
                . "comunicacion = ? "
                . "WHERE id = ?";
        $sql = $conexion->prepare($sql);
        $sql->bindValue(1, $nombre);
        $sql->bindValue(2, $fecha);
        $sql->bindValue(3, $hora);
        $sql->bindValue(4, $fecha_max);
        $sql->bindValue(5, $tipo_torneo);
        $sql->bindValue(6, $localizacion);
        $sql->bindValue(7, $premio);
        $sql->bindValue(8, $tipo_enfrentamiento);
        $sql->bindValue(9, $num_participantes);
        $sql->bindValue(10, $comunicacion);
        $sql->bindValue(11, $idTorneo);

        if ($sql->execute())
            return 1;
        else
            return 0;
    }
}

?>
