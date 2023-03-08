<?php 
namespace model\DAO;

use config\Connection as Conexion;
use model\DTO\Tipo as Tipo;
use Exception;

require_once "../config/connection.php";
require_once "../model/DTO/tipo.php";

class TipoDao
{
    public function __construct() { }

    public function registrarTipo(Tipo $tipo)
    {
        $conexion = $this->obtenerConexion();
        $response = ["response" => "unsuccessful"];

        try 
        {
            $query = $conexion->prepare("INSERT INTO tip_tipo_doc (tip_prefijo, tip_nombre) VALUES (?, ?)");

            $prefijo = $tipo->getTip_prefijo();
            $nombre = $tipo->getTip_nombre();

            $query->bindParam(1, $prefijo);
            $query->bindParam(2, $nombre);

            $query->execute();

            $response['response'] = "successful";
            $response['mensaje'] = "Registro Exitoso";
        } 
        catch (Exception $e) 
        {
            $response['mensaje'] = "Rectifique que el nombre del tipo\n no esté registrado aún";
        }

        return $response;
    }

    public function editarTipo(Tipo $tipo)
    {
        $conexion = $this->obtenerConexion();
        $response = ["response" => "unsuccessful"];

        try 
        {
            $query = $conexion->prepare("UPDATE tip_tipo_doc SET tip_nombre = ?, tip_prefijo = ? WHERE tip_id = ?");

            $id = $tipo->getTip_id();
            $prefijo = $tipo->getTip_prefijo();
            $nombre = $tipo->getTip_nombre();

            $query->bindParam(1, $nombre);
            $query->bindParam(2, $prefijo);
            $query->bindParam(3, $id);

            $query->execute();

            $response['response'] = "successful";
            $response['mensaje'] = "Edición completada";
        } 
        catch (Exception $e) 
        {
            $response['mensaje'] = "Rectifique que el nombre del tipo\n no esté registrado aún";
        }

        return $response;
    }

    public function eliminarTipo(Tipo $tipo)
    {
        $conexion = $this->obtenerConexion();
        $response['response'] = "unsuccessful";

        try 
        {
            $query = $conexion->prepare("DELETE FROM tip_tipo_doc WHERE tip_id = ?");
            
            $id = $tipo->getTip_id();
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

    public function obtenerTipos()
    {
        $conexion = $this->obtenerConexion();
        $response["response"] = "unsuccessful";
        
        try
        {
            $query = $conexion->prepare("SELECT * FROM tip_tipo_doc ORDER BY tip_nombre");
            $query->execute();

            $response["response"] = "successful";
            $response["tipos"] = $this->convertirAJson($query->fetchAll());
        } 
        catch (Exception $ex) 
        {
            $response["mensaje"] = $ex->getMessage();
        }

        return $response;
    }

    public function obtenerTipo(Tipo $tipo)
    {
        $conexion = $this->obtenerConexion();
        $response["response"] = "unsuccessful";
        
        try
        {
            $id = $tipo->getTip_id();

            $query = $conexion->prepare("SELECT * FROM tip_tipo_doc WHERE tip_id = ?");

            $query->bindParam(1, $id);
            $query->execute();

            $response["response"] = "successful";
            $response["tipos"] = $query->fetch();
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
                    "id" => $fila['tip_id'],
                    "nombre" => $fila["tip_nombre"],
                    "prefijo" => $fila["tip_prefijo"],
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