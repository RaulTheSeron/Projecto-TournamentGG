<?php

class Denuncia extends Conexion {

    public function obtenerListaDenuncias() {
        $conexion = parent::conectarBD();
        $sql = "SELECT * FROM denuncia";
        $sql = $conexion->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function obtenerDenunciaPorID($idDenuncia) {
        $conexion = parent::conectarBD();
        $sql = "SELECT * FROM denuncia WHERE id = ?";
        $sql = $conexion->prepare($sql);
        $sql->bindValue(1, $idDenuncia);
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function obtenerDenunciasDeUsuario($idUsuario) {
        $conexion = parent::conectarBD();
        $sql = "SELECT * FROM denuncia WHERE denunciado = ?";
        $sql = $conexion->prepare($sql);
        $sql->bindValue(1, $idUsuario);
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function obtenerListaUsuariosConIncidencias() {
        $conexion = parent::conectarBD();
        $sql = "SELECT d.denunciado, u.nombre, COUNT(d.id) as indicencias "
                . "from denuncia as d join usuario as u "
                . "on d.denunciado = u.id "
                . "group by d.denunciado";
        $sql = $conexion->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function insertarDenuncia($idDenunciado, $idDenunciante, $asunto, $descripcion) {
        $conexion = parent::conectarBD();
        $sql = "INSERT INTO denuncia("
                . "denunciado, "
                . "denunciante, "
                . "asunto, "
                . "descripcion) "
                . "VALUES (?,?,?,?)";
        $sql = $conexion->prepare($sql);
        $sql->bindValue(1, $idDenunciado);
        $sql->bindValue(2, $idDenunciante);
        $sql->bindValue(3, $asunto);
        $sql->bindValue(4, $descripcion);
        $sql->execute();
    }

    public function borrarDenuncia($idDenuncia) {
        $conexion = parent::conectarBD();
        $sql = "DELETE FROM denuncia WHERE id = ?";
        $sql = $conexion->prepare($sql);
        $sql->bindValue(1, $idDenuncia);
        $sql->execute();
    }
}
?>
