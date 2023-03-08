<?php

namespace controller;

use model\DAO\TipoDao as TipoDao;
use model\DTO\Tipo as Tipo;

session_start();

require_once "../model/DAO/tipoDao.php";
require_once "../model/DTO/tipo.php";

$tipoController = new TipoController($_POST ?? $_GET);

class TipoController
{
    private $tipoDao;
    public function __construct($request)
    {
        if (!(isset($_SESSION["login"]) && $_SESSION['login'] == true))
        {
            header("Location:../views/sesion.php");
            die();    
        }
        
        $this->tipoDao = new TipoDao();

        if (!isset($request['metodo']))
            $request = $_GET;

        if (isset($request['metodo']))
            $this->{$request["metodo"]}($request);
    }

    public function registrarTipo($request)
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

        $tipo = new Tipo();

        $tipo->setTip_nombre($request["tip_prefijo"]);
        $tipo->setTip_prefijo($request["tip_nombre"]);

        if (!empty($request['id']))
        {
            $tipo->setTip_id($request['id']);

            echo json_encode($this->tipoDao->editarTipo($tipo));
            return;
        }

        echo json_encode($this->tipoDao->registrarTipo($tipo));
    }

    public function eliminarTipo($request)
    {
        $tipo = new Tipo($request["id"]);

        echo json_encode($this->tipoDao->eliminarTipo($tipo));
    }

    public function obtenerTipos($request)
    {
        echo json_encode($this->tipoDao->obtenerTipos());
    }

    public function obtenerTipo($request)
    {
        $tipoDTO = new Tipo($request['id']);

        echo json_encode($this->tipoDao->obtenerTipo($tipoDTO));
    }
}

?>