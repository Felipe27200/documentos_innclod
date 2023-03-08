<?php 
namespace model\DTO;

class Tipo
{
    private $tip_id;
    private $tip_nombre;
    private $tip_prefijo;

    public function __construct($tip_id = "", $tip_nombre = "", $tip_prefijo = "")
    {
        $this->tip_id = $tip_id;
        $this->tip_nombre = $tip_nombre;
        $this->tip_prefijo = $tip_prefijo;
    }

    public function getTip_id()
    {
        return $this->tip_id;
    }

    public function setTip_id($tip_id)
    {
        $this->tip_id = $tip_id;

        return $this;
    }

    public function getTip_nombre()
    {
        return $this->tip_nombre;
    }

    public function setTip_nombre($tip_nombre)
    {
        $this->tip_nombre = $tip_nombre;

        return $this;
    }

    public function getTip_prefijo()
    {
        return $this->tip_prefijo;
    }

    public function setTip_prefijo($tip_prefijo)
    {
        $this->tip_prefijo = $tip_prefijo;

        return $this;
    }
}

?>