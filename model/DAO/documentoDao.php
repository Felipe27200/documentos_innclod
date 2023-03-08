<?php
namespace model\DAO;

use config\Connection as Conexion;
use model\DTO\Documento as Documento;

use Exception;

require_once "../config/connection.php";

require_once "../model/DTO/documento.php";
require_once "../model/DTO/proceso.php";
require_once "../model/DTO/tipo.php";

require_once "../model/DAO/procesoDao.php";
require_once "../model/DAO/tipoDao.php";

class DocumentoDao
{
    public function __construct() { }

    public function registrarDocumento(Documento $documento)
    {
        $conexion = $this->obtenerConexion();
        $response = ["response" => "unsuccessful"];

        try 
        {
            $id_proceso = $documento->getDoc_id_proceso();
            $id_tipo = $documento->getDoc_id_tipo();

            $codigo = $this->generarCodigoNumeracion($documento);

            $query = $conexion->prepare("INSERT INTO doc_documento (doc_nombre, doc_codigo, doc_contenido, doc_id_tipo, doc_id_proceso) "
                ."VALUES (?, ?, ?, ?, ?)");

            $nombre = $documento->getDoc_nombre();
            $contenido = $documento->getDoc_contenido();

            $query->bindParam(1, $nombre);
            $query->bindParam(2, $codigo);
            $query->bindParam(3, $contenido);
            $query->bindParam(4, $id_tipo);
            $query->bindParam(5, $id_proceso);

            $query->execute();

            $response['response'] = "successful";
            $response['mensaje'] = "Registro Exitoso";
        } 
        catch (Exception $e) 
        {
            // $response['mensaje'] = "Rectifique que el nombre del documento\n no esté registrado aún";
            $response['mensaje'] = $e->getMessage();
        }

        return $response;
    }

    public function editarDocumento(Documento $documento)
    {
        $response = ["response" => "unsuccessful"];
        $codigoIgual = true;

        try
        {
            $documentoOriginalDTO = new Documento($documento->getDoc_id());
            $documentoOriginal = $this->obtenerDocumento($documentoOriginalDTO);

            if ($documentoOriginal["response"] != "successful")
                throw new Exception("No hay registro de este documento");
            else
                $documentoOriginal = $documentoOriginal["documentos"];

            $documento->setDoc_codigo($documentoOriginal['doc_codigo']);

            if (($documentoOriginal["doc_id_tipo"] != $documento->getDoc_id_tipo()) || 
                ($documentoOriginal["doc_id_proceso"] != $documento->getDoc_id_proceso()))
            {
                $codigoIgual = false;

                $codigo = $this->generarCodigoNumeracion($documento);
                $documento->setDoc_codigo($codigo);
            }

            $this->updateDocumento($documento);

            if (!$codigoIgual)
            {
                $this->actualizarNumeracion($documentoOriginal["doc_id_tipo"], 
                    $documentoOriginal["doc_id_proceso"], $documentoOriginal["doc_codigo"]);
            }

            $response['response'] = "successful";
            $response['mensaje'] = "Edición completada";
        } 
        catch (Exception $e) 
        {
            $response['mensaje'] = "Rectifique que el nombre del documento\n no esté registrado aún";
        }

        return $response;
    }

    public function actualizarNumeracion($tip_id, $pro_id, $codigo)
    {
        $conexion = $this->obtenerConexion();
        $documentos = $this->obtenerDocumentosNumeracion($tip_id, $pro_id, $codigo);

        if ($documentos['response'] != "successful")
            throw new Exception("No se logro encontrar registros del código");
        
        $documentos = $documentos["codigos"];

        for ($numeracion = $codigo, $indice = 0; $indice < count($documentos); $numeracion++, $indice++)
        {
            $query = $conexion->prepare("UPDATE doc_documento SET doc_codigo = ? WHERE doc_id = ?");

            $query->bindParam(1, $numeracion);
            $query->bindParam(2, $documentos[$indice]["id"]);

            $query->execute();
        }
    }

    public function updateDocumento(Documento $documento)
    {
        $conexion = $this->obtenerConexion();

        $query = $conexion->prepare("UPDATE doc_documento SET doc_nombre = ?, doc_codigo = ?," 
        ."doc_contenido = ?, doc_id_tipo = ?, doc_id_proceso = ?" 
        ."WHERE doc_id = ?");

        $nombre = $documento->getDoc_nombre();
        $codigo = $documento->getDoc_codigo();
        $contenido = $documento->getDoc_contenido();
        $id_tipo = $documento->getDoc_id_tipo();
        $id_proceso = $documento->getDoc_id_proceso();
        $id = $documento->getDoc_id();

        $query->bindParam(1, $nombre);
        $query->bindParam(2, $codigo);
        $query->bindParam(3, $contenido);
        $query->bindParam(4, $id_tipo);
        $query->bindParam(5, $id_proceso);
        $query->bindParam(6, $id);

        $query->execute();
    }

    public function eliminarDocumento(Documento $documento)
    {
        $conexion = $this->obtenerConexion();
        $response['response'] = "unsuccessful";
        
        try 
        {
            $documentoOriginal = $this->obtenerDocumento($documento);
            $id = $documento->getDoc_id();

            if ($documentoOriginal['response'] != "successful")
                throw new Exception("No se pudo eliminar el documento");
            else
                $documentoOriginal = $documentoOriginal["documentos"];

            $query = $conexion->prepare("DELETE FROM doc_documento WHERE doc_id = ?");
            $query->bindParam(1, $id);
            $query->execute();

            $this->actualizarNumeracion($documentoOriginal["doc_id_tipo"], 
                $documentoOriginal["doc_id_proceso"], $documentoOriginal["doc_codigo"]);
            
            $response['response'] = "successful";
            $response['mensaje'] = "Registro eliminado";
        } 
        catch (Exception $e) 
        {
            $response['mensaje'] = $e->getMessage();
        }

        return $response;
    }

    public function obtenerDocumentos()
    {
        $conexion = $this->obtenerConexion();
        $response["response"] = "unsuccessful";
        
        try
        {
            $query = $conexion->prepare("SELECT doc.*, tip.tip_prefijo, pro.pro_prefijo\n"
                ."FROM `doc_documento` AS doc\n"
                ."INNER JOIN pro_proceso AS pro ON pro.pro_id = doc.doc_id_proceso\n"
                ."INNER JOIN tip_tipo_doc AS tip ON tip.tip_id = doc_id_tipo;");
            $query->execute();

            $response["response"] = "successful";
            $response["documentos"] = $this->convertirAJson($query->fetchAll());
        }
        catch (Exception $ex) 
        {
            $response["mensaje"] = $ex->getMessage();
        }

        return $response;
    }

    public function obtenerDocumento(Documento $documento)
    {
        $conexion = $this->obtenerConexion();
        $response["response"] = "unsuccessful";
        
        try
        {
            $id = $documento->getDoc_id();

            $query = $conexion->prepare("SELECT * FROM doc_documento WHERE doc_id = ?");

            $query->bindParam(1, $id);
            $query->execute();

            $response["response"] = "successful";
            $response["documentos"] = $query->fetch();
        } 
        catch (Exception $ex) 
        {
            $response["mensaje"] = $ex->getMessage();
        }

        return $response;
    }

    public function obtenerDocumentosNumeracion($tip_id, $pro_id, $codigo)
    {
        $conexion = $this->obtenerConexion();
        $response["response"] = "unsuccessful";

        try 
        {
            $query = $conexion->prepare("SELECT * FROM doc_documento\n"
                ."WHERE (doc_id_tipo = ? AND doc_id_proceso = ?) AND doc_codigo > ?");
            $query->bindParam(1, $tip_id);
            $query->bindParam(2, $pro_id);
            $query->bindParam(3, $codigo);
            $query->execute();

            $codigos = $this->convertirAJson($query->fetchAll());

            $response['codigos'] = $codigos;
            $response["response"] = "successful";
        } 
        catch (Exception $ex) 
        {
            $response["mensaje"] = $ex->getMessage(); 
        }

        return $response;
    }

    public function generarCodigoNumeracion(Documento $documento)
    {
        $id_proceso = $documento->getDoc_id_proceso();
        $id_tipo = $documento->getDoc_id_tipo();

        $codigo = $this->obtenerCodigoNumeracion($id_proceso, $id_tipo);

        if ($codigo["response"] != "successful")
            throw new Exception("No se pudo generar el código");

        return $codigo = $codigo['doc_codigo'];    
    }

    public function obtenerCodigoNumeracion($pro_id, $tip_id)
    {
        $conexion = $this->obtenerConexion();
        $response["response"] = "unsuccessful";

        try 
        {
            $query = $conexion->prepare("SELECT MAX(doc_codigo) as doc_codigo FROM doc_documento\n"
                ."WHERE doc_id_proceso = ? AND doc_id_tipo = ?");
            $query->bindParam(1, $pro_id);
            $query->bindParam(2, $tip_id);
            $query->execute();

            $codigoEncontrado = $query->fetch();

            if (isset($codigoEncontrado["doc_codigo"]))
                $response["doc_codigo"] = ++$codigoEncontrado["doc_codigo"];
            else
                $response["doc_codigo"] = "1";

            $response["response"] = "successful";
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
                    "id" => $fila['doc_id'],
                    "nombre" => $fila["doc_nombre"],
                    "codigo" => $fila["doc_codigo"],
                    "contenido" => $fila["doc_contenido"],
                    "id_tipo" => $fila["doc_id_tipo"],
                    "id_proceso" => $fila["doc_id_proceso"],
                    "pro_prefijo" => $fila["pro_prefijo"] ?? '',
                    "tip_prefijo" => $fila["tip_prefijo"] ?? '',
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