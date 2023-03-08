<?php 

namespace model\DAO;

use config\Connection as Conexion;
use model\DTO\Documento as Documento;
use Exception;

require_once('../../config/connection.php');
require_once('../model/DTO/documento.php');

class DocumentoDao
{
    public function __construct() { }

    public function registrarDocumento ()
    {

    }

    private function obtenerConexion()
    {
        $conexion = new Conexion();

        return $conexion->obtenerConexion();
    }
}

?>