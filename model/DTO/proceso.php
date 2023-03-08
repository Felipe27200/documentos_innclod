<?php 
namespace model\DTO;

class Proceso
{
    private $pro_id;
    private $pro_prefijo;
    private $pro_nombre;

    function __construct($pro_id = "", $pro_prefijo = "", $pro_nombre = "")
    {
        $this->pro_id = $pro_id;
        $this->pro_prefijo = $pro_prefijo;
        $this->pro_nombre = $pro_nombre;
    }

    public function getPro_id()
    {
        return $this->pro_id;
    }

    public function setPro_id($pro_id)
    {
        $this->pro_id = $pro_id;

        return $this;
    }

    public function getPro_prefijo()
    {
        return $this->pro_prefijo;
    }

    public function setPro_prefijo($pro_prefijo)
    {
        $this->pro_prefijo = $pro_prefijo;

        return $this;
    }

    public function getPro_nombre()
    {
        return $this->pro_nombre;
    }

    public function setPro_nombre($pro_nombre)
    {
        $this->pro_nombre = $pro_nombre;

        return $this;
    }
}

?>