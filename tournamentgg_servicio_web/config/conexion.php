<?php

require_once ("../vendor/autoload.php");

use Firebase\JWT\JWT;

class Conexion {

    protected function conectarBD() {

        $nombreBD = "app_torneos";
        $host = "localhost";
        $usuarioBD = "root";
        $contraseñaBD = "admin";
        
        $cadenaConexion = "mysql:host=$host;dbname=$nombreBD";
        $codificacion = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'");

        try {
            $conexion = new PDO($cadenaConexion, $usuarioBD, $contraseñaBD, $codificacion);
            return $conexion;
        } catch (Exception $ex) {
            echo json_encode("¡Error de conexion a BD! " . $ex->getMessage());
            die();
        }
    }

    static public function generarToken($idUsuario, $nombreUsuario) {
        $horaActual = time();
        $token = [
            "iat" => $horaActual,
            "exp" => $horaActual + (5 * 60), //Expiracion en 5 min
            "data" => [
                "id" => $idUsuario,
                "nombre" => $nombreUsuario
            ]
        ];
        return $token;
    }

    static public function encriptarToken($token) {
        $horaActual = time();
        $llaveEncriptado = "ldkfjik13dfdsag213" . $horaActual;
        $algoritmoEncriptado = "HS512";
        $tokenEncriptado = JWT::encode($token, $llaveEncriptado, $algoritmoEncriptado);
        return $tokenEncriptado;
    }

    static public function desencriptarToken($tokenEncriptado) {

        $ArrayPartesToken = explode(".", $tokenEncriptado);
        $algoritmoEncriptadoDelToken = base64_decode($ArrayPartesToken[0]);
        $informacionEncriptadaDelToken = base64_decode($ArrayPartesToken[1]);
        $algoritmoDesencriptado = json_decode($algoritmoEncriptadoDelToken);
        $informacionDesencriptada = json_decode($informacionEncriptadaDelToken, true);

        return $informacionDesencriptada;
    }

    private function obtenerTokenDeUsuario($idUsuario) {

        $conexion = $this::conectarBD();

        $sql = "SELECT token, token_exp FROM usuario WHERE id = ?";
        $sql = $conexion->prepare($sql);
        $sql->bindValue(1, $idUsuario);
        $sql->execute();

        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @return int: 0 = Sesion expirada || 1 = Token validado || -1 = Token no validado
     */
    public function validarToken($tokenEncriptado) {
        $tokenDesencriptado = $this::desencriptarToken($tokenEncriptado);

        if ($tokenDesencriptado != null) {
            $datosUsuario = $tokenDesencriptado["data"];
            $infoUsuario = $this::obtenerTokenDeUsuario($datosUsuario["id"]);
            
            if ($infoUsuario == null) {
                return -1;
                
            } else if ($tokenEncriptado == $infoUsuario[0]["token"]) {
                $horaActual = time();
                
                if ($infoUsuario[0]["token_exp"] <= $horaActual) {
                    return 0;
                } else {
                    return 1;
                }
            } else {

                return -1;
            }
        } else {
            return -1;
        }
    }

    public function renovarToken($tokenActualEncriptado) {
        $datosToken = $this::desencriptarToken($tokenActualEncriptado);
        $datosUsuario = $datosToken["data"];
        $idUsuario = $datosUsuario["id"];
        $nombreUsuario = $datosUsuario["nombre"];
        $nuevoToken = $this::generarToken($idUsuario, $nombreUsuario);
        $this::expandirDuracionToken($idUsuario, $nuevoToken["exp"]);
    }

    public function actualizarToken($idUsuario, $token, $tiempoExpiracionToken) {
        $conexion = $this::conectarBD();
        $sql = "UPDATE usuario SET "
                . "token = ?,"
                . "token_exp = ?"
                . "WHERE id = ?";
        $sql = $conexion->prepare($sql);
        $sql->bindValue(1, $token);
        $sql->bindValue(2, $tiempoExpiracionToken);
        $sql->bindValue(3, $idUsuario);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function expandirDuracionToken($idUsuario, $tiempoExpiracionToken) {
        $conexion = $this::conectarBD();
        $sql = "UPDATE usuario SET "
                . "token_exp = ?"
                . "WHERE id = ?";
        $sql = $conexion->prepare($sql);
        $sql->bindValue(1, $tiempoExpiracionToken);
        $sql->bindValue(2, $idUsuario);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>
