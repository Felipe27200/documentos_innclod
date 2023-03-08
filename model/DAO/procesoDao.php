<?php
namespace model\DAO;

use config\Connection as Conexion;
use model\DTO\Proceso as Proceso;
use Exception;

require_once "../config/connection.php";
require_once "../model/DTO/proceso.php";

class ProcesoDao
{
    public function __construct() { }

    public function registrarProceso(Proceso $proceso)
    {
        $conexion = $this->obtenerConexion();
        $response = ["response" => "unsuccessful"];

        try 
        {
            $query = $conexion->prepare("INSERT INTO pro_proceso (pro_prefijo, pro_nombre) VALUES (?, ?)");

            $prefijo = $proceso->getPro_prefijo();
            $nombre = $proceso->getPro_nombre();

            $query->bindParam(1, $prefijo);
            $query->bindParam(2, $nombre);

            $query->execute();

            $response['response'] = "successful";
            $response['mensaje'] = "Registro Exitoso";
        } 
        catch (Exception $e) 
        {
            $response['mensaje'] = "Rectifique que el nombre del proceso\n no esté registrado aún";
        }

        return $response;
    }

    public function editarProceso(Proceso $proceso)
    {
        $conexion = $this->obtenerConexion();
        $response = ["response" => "unsuccessful"];

        try 
        {
            $query = $conexion->prepare("UPDATE pro_proceso SET pro_nombre = ?, pro_prefijo = ? WHERE pro_id = ?");

            $id = $proceso->getPro_id();
            $prefijo = $proceso->getPro_prefijo();
            $nombre = $proceso->getPro_nombre();

            $query->bindParam(1, $nombre);
            $query->bindParam(2, $prefijo);
            $query->bindParam(3, $id);

            $query->execute();

            $response['response'] = "successful";
            $response['mensaje'] = "Edición completada";
        } 
        catch (Exception $e) 
        {
            $response['mensaje'] = "Rectifique que el nombre del proceso\n no esté registrado aún";
        }

        return $response;
    }

    public function eliminarProceso(Proceso $proceso)
    {
        $conexion = $this->obtenerConexion();
        $response['response'] = "unsuccessful";

        try 
        {
            $query = $conexion->prepare("DELETE FROM pro_proceso WHERE pro_id = ?");
            
            $id = $proceso->getPro_id();
            $query->bindParam(1, $id);

            $query->execute();
            
            $response['response'] = "successful";
            $response['mensaje'] = "Registro eliminado";
        } 
        catch (Exception $e) 
        {
            $response['mensaje'] = $e->getMessage();
        }

        return $response;
    }

    public function obtenerProcesos()
    {
        $conexion = $this->obtenerConexion();
        $response["response"] = "unsuccessful";
        
        try
        {
            $query = $conexion->prepare("SELECT * FROM pro_proceso ORDER BY pro_nombre");
            $query->execute();

            $response["response"] = "successful";
            $response["procesos"] = $this->convertirAJson($query->fetchAll());
        } 
        catch (Exception $ex) 
        {
            $response["mensaje"] = $ex->getMessage();
        }

        return $response;
    }

    public function obtenerProceso(Proceso $proceso)
    {
        $conexion = $this->obtenerConexion();
        $response["response"] = "unsuccessful";
        
        try
        {
            $id = $proceso->getPro_id();

            $query = $conexion->prepare("SELECT * FROM pro_proceso WHERE pro_id = ?");

            $query->bindParam(1, $id);
            $query->execute();

            $response["response"] = "successful";
            $response["procesos"] = $query->fetch();
        } 
        catch (Exception $ex) 
        {
            $response["mensaje"] = $ex->getMessage();
        }

        return $response;
    }

    private function convertirAJson($resultado)
    {
        $json = array();

        foreach($resultado as $fila) 
        {
            array_push($json, 
                array(
                    "id" => $fila['pro_id'],
                    "nombre" => $fila["pro_nombre"],
                    "prefijo" => $fila["pro_prefijo"],
                ));
        }

        return $json;
    }

    private function obtenerConexion()
    {
        $conexion = new Conexion();

        return $conexion->obtenerConexion();
    }
}

?>