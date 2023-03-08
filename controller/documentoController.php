<?php

namespace controller;

use model\DAO\DocumentoDao as DocumentoDao;
use model\DTO\Documento as Documento;

require_once "../model/DAO/documentoDao.php";
require_once "../model/DTO/documento.php";

$documentoController = new DocumentoController($_POST ?? $_GET);

class DocumentoController
{
    private $documentoDao;
    
    public function __construct($request)
    {
        $this->documentoDao = new DocumentoDao();

        if (!isset($request['metodo']))
            $request = $_GET;

        if (isset($request['metodo']))
            $this->{$request["metodo"]}($request);
    }

    public function registrarDocumento($request)
    {
        foreach ($request as $key => $value)
        {
            if ($key == "metodo" || $key == "id")
                continue;

            if (empty($value))
            {
                echo json_encode([
                    "response" => "unsuccessful",
                    "mensaje" => "Debe llenar todos los campos"
                ]);

                die();
            }
        }

        $documento = new Documento();

        $documento->setDoc_nombre($request["doc_nombre"]);
        $documento->setDoc_contenido($request["doc_contenido"]);
        $documento->setDoc_id_tipo($request["doc_id_tipo"]);
        $documento->setDoc_id_proceso($request["doc_id_proceso"]);

        if (!empty($request['id']))
        {
            $documento->setDoc_id($request['id']);

            echo json_encode($this->documentoDao->editarDocumento($documento));
            return;
        }

        echo json_encode($this->documentoDao->registrarDocumento($documento));
    }

    public function eliminarDocumento($request)
    {
        $documento = new Documento($request["id"]);

        echo json_encode($this->documentoDao->eliminarDocumento($documento));
    }

    public function obtenerDocumentos($request)
    {
        echo json_encode($this->documentoDao->obtenerDocumentos());
    }

    public function obtenerDocumento($request)
    {
        $documentoDTO = new Documento($request['id']);

        echo json_encode($this->documentoDao->obtenerDocumento($documentoDTO));
    }
}

?>