<?php

namespace controller;

use model\DAO\ProcesoDao as ProcesoDao;
use model\DTO\Proceso as Proceso;

require_once "../model/DAO/procesoDao.php";
require_once "../model/DTO/proceso.php";

$procesoController = new ProcesoController($_POST ?? $_GET);

class ProcesoController
{
    private $procesoDao;
    public function __construct($request)
    {
        $this->procesoDao = new ProcesoDao();

        if (!isset($request['metodo']))
            $request = $_GET;

        if (isset($request['metodo']))
            $this->{$request["metodo"]}($request);
    }

    public function registrarProceso($request)
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

        $proceso = new Proceso();

        $proceso->setPro_nombre($request["pro_prefijo"]);
        $proceso->setPro_prefijo($request["pro_nombre"]);

        if (!empty($request['id']))
        {
            $proceso->setPro_id($request['id']);

            echo json_encode($this->procesoDao->editarProceso($proceso));
            return;
        }

        echo json_encode($this->procesoDao->registrarProceso($proceso));
    }

    public function eliminarProceso($request)
    {
        $proceso = new Proceso($request["id"]);

        echo json_encode($this->procesoDao->eliminarProceso($proceso));
    }

    public function obtenerProcesos($request)
    {
        echo json_encode($this->procesoDao->obtenerProcesos());
    }

    public function obtenerProceso($request)
    {
        $procesoDTO = new Proceso($request['id']);

        echo json_encode($this->procesoDao->obtenerProceso($procesoDTO));
    }
}

?>