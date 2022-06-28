<?php

class Usuario extends Conexion {

    public function obtenerListaUsuarios() {
        $conexion = parent::conectarBD();
        $sql = "SELECT id,nombre,fecna,correo,permisos,avatar,estado"
                . "  FROM usuario";
        $sql = $conexion->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function obtenertUsuarioPorID($idUsuario) {
        $conexion = parent::conectarBD();
        $sql = "SELECT id,nombre,contraseña,fecna,correo,permisos,avatar,estado"
                . " FROM usuario WHERE id = ?";
        $sql = $conexion->prepare($sql);
        $sql->bindValue(1, $idUsuario);
        $sql->execute();
        $resultado = $sql->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function comprobarLogin($usuario, $contraseña) {
        $conexion = parent::conectarBD();
        $sql = "SELECT id,estado,token,permisos FROM usuario "
                . "WHERE contraseña = ? "
                . "and (nombre = ? or correo = ?)";
        $sql = $conexion->prepare($sql);
        $sql->bindValue(1, $contraseña);
        $sql->bindValue(2, $usuario);
        $sql->bindValue(3, $usuario);
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function comprobarExistenciaUsuario($nombre, $correo) {
        $conexion = parent::conectarBD();
        $sql = "SELECT id FROM usuario "
                . "WHERE nombre = ? or correo = ?";
        $sql = $conexion->prepare($sql);
        $sql->bindValue(1, $nombre);
        $sql->bindValue(2, $correo);
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function insertarUsuario($nombre, $contraseña, $fechaNacimiento, $correo, $permisos,
            $avatar, $estado) {
        $conexion = parent::conectarBD();
        $sql = "INSERT INTO usuario("
                . "nombre, "
                . "contraseña, "
                . "fecna, "
                . "correo, "
                . "permisos, "
                . "avatar, "
                . "estado,"
                . "token,"
                . "token_exp) "
                . "VALUES(?,?,?,?,?,?,?,NULL,NULL)";
        $sql = $conexion->prepare($sql);
        $sql->bindValue(1, $nombre);
        $sql->bindValue(2, $contraseña);
        $sql->bindValue(3, $fechaNacimiento);
        $sql->bindValue(4, $correo);
        $sql->bindValue(5, $permisos);
        $sql->bindValue(6, $avatar);
        $sql->bindValue(7, $estado);

        if ($sql->execute())
            return 1;
        else
            return 0;
    }

    public function borrarUsuario($idUsuario) {

        $conexion = parent::conectarBD();

        $sql = "DELETE FROM usuario WHERE id = ?";
        $sql = $conexion->prepare($sql);
        $sql->bindValue(1, $idUsuario);
        $sql->execute();
    }

    public function actualizarUsuario($nombre, $fechaNacimiento, $correo, $permisos,
            $avatar, $estado, $idUsuario) {
        $conexion = parent::conectarBD();
        $sql = "UPDATE usuario SET "
                . "nombre = ?,"
                . "fecna = ?,"
                . "correo = ?,"
                . "permisos = ?,"
                . "avatar = ?,"
                . "estado = ? "
                . "WHERE id = ?";
        $sql = $conexion->prepare($sql);
        $sql->bindValue(1, $nombre);
        $sql->bindValue(2, $fechaNacimiento);
        $sql->bindValue(3, $correo);
        $sql->bindValue(4, $permisos);
        $sql->bindValue(5, $avatar);
        $sql->bindValue(6, $estado);
        $sql->bindValue(7, $idUsuario);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cambiarEstadoUsuario($idUsuario, $estado) {
        $conexion = parent::conectarBD();
        $sql = "UPDATE usuario SET "
                . "estado = ? "
                . "WHERE id = ?";
        $sql = $conexion->prepare($sql);
        $sql->bindValue(1, $estado);
        $sql->bindValue(2, $idUsuario);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function comprobarContraseñaPorID($idUsuario, $contraseña) {
        $conexion = parent::conectarBD();
        $sql = "SELECT nombre "
                . "FROM usuario "
                . "WHERE contraseña = ? "
                . "AND ID = ?";
        $sql = $conexion->prepare($sql);
        $sql->bindValue(1, $contraseña);
        $sql->bindValue(2, $idUsuario);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cambiarPass($idUsuario, $contraseña) {
        $conexion = parent::conectarBD();
        $sql = "UPDATE usuario "
                . "SET contraseña = ? "
                . "WHERE id = ?";
        $sql = $conexion->prepare($sql);
        $sql->bindValue(1, $contraseña);
        $sql->bindValue(2, $idUsuario);

        if ($sql->execute()) {
            return 1;
        } else {
            return 2;
        }
    }
}
?>

