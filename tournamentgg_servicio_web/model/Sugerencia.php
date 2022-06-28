<?php

    class Sugerencia extends Conexion{
                
        public function obtenerListaSugerencias(){
            $conexion = parent::conectarBD();
            $sql = "SELECT * FROM sugerencia";
            $sql = $conexion->prepare($sql);
            $sql->execute();
            $resultado = $sql->fetchAll(PDO::FETCH_ASSOC); //Usamos assoc para quitar campos numericos
            return $resultado; //Devolvemos array con todos los resutados
        }
        
        public function obtenerSugerenciaPorID($idSugerencia){
            $conexion = parent::conectarBD();
            $sql = "SELECT * FROM sugerencia WHERE id = ?";
            $sql = $conexion->prepare($sql);
            $sql->bindValue(1,$idSugerencia);
            $sql->execute();
            $resultado = $sql->fetchAll(PDO::FETCH_ASSOC); 
            return $resultado; 
        }
        
        public function insertarSugerencia($idUsuario, $asunto, $descripcion){
            $conexion = parent::conectarBD();
            $sql = "INSERT INTO sugerencia( "
                    . "usuario, "
                    . "asunto, "
                    . "descripcion) "
                    . "VALUES (?,?,?)";
            $sql = $conexion->prepare($sql);
            $sql->bindValue(1,$idUsuario);
            $sql->bindValue(2,$asunto);
            $sql->bindValue(3,$descripcion);
            $sql->execute();
        }
        
        public function borrarSugerencia($idSugerencia){
            $conexion = parent::conectarBD();
            $sql = "DELETE FROM sugerencia WHERE id = ?";
            $sql = $conexion->prepare($sql);
            $sql->bindValue(1,$idSugerencia);
            $sql->execute();
            $resultado = $sql->fetchAll(PDO::FETCH_ASSOC); 
            return $resultado; 
        }
    }

?>