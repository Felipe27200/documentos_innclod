<?php
namespace model\DTO;

class Documento
{
    private $doc_id;
    private $doc_nombre;
    private $doc_codigo;
    private $doc_contenido;
    private $doc_id_tipo;
    private $doc_id_proceso;

    public function __construct($doc_id = "", $doc_nombre = "", $doc_codigo = "", 
        $doc_contenido = "", $doc_id_tipo = "", $doc_id_proceso = "")
    {
        $this->doc_id = $doc_id;
        $this->doc_nombre = $doc_nombre;
        $this->doc_codigo = $doc_codigo;
        $this->doc_contenido = $doc_contenido;
        $this->doc_id_tipo = $doc_id_tipo;
        $this->doc_id_proceso = $doc_id_proceso;
    }

    /**
     * Get the value of doc_id
     */ 
    public function getDoc_id()
    {
        return $this->doc_id;
    }

    /**
     * Set the value of doc_id
     *
     * @return  self
     */ 
    public function setDoc_id($doc_id)
    {
        $this->doc_id = $doc_id;
    }

    /**
     * Get the value of doc_nombre
     */ 
    public function getDoc_nombre()
    {
        return $this->doc_nombre;
    }

    /**
     * Set the value of doc_nombre
     *
     * @return  self
     */ 
    public function setDoc_nombre($doc_nombre)
    {
        $this->doc_nombre = $doc_nombre;
    }

    /**
     * Get the value of doc_codigo
     */ 
    public function getDoc_codigo()
    {
        return $this->doc_codigo;
    }

    public function setDoc_codigo($doc_codigo)
    {
        $this->doc_codigo = $doc_codigo;
    }

    /**
     * Set the value of doc_codigo
     *
     * @return  self
     */ 
    public function createDoc_codigo($tip_prefijo, $pro_fijo, $numeracion)
    {
        $this->doc_codigo = $tip_prefijo."-".$pro_fijo."-".$numeracion;
    }

    /**
     * Get the value of doc_contenido
     */ 
    public function getDoc_contenido()
    {
        return $this->doc_contenido;
    }

    /**
     * Set the value of doc_contenido
     *
     * @return  self
     */ 
    public function setDoc_contenido($doc_contenido)
    {
        $this->doc_contenido = $doc_contenido;
    }

    /**
     * Get the value of doc_id_tipo
     */ 
    public function getDoc_id_tipo()
    {
        return $this->doc_id_tipo;
    }

    /**
     * Set the value of doc_id_tipo
     *
     * @return  self
     */ 
    public function setDoc_id_tipo($doc_id_tipo)
    {
        $this->doc_id_tipo = $doc_id_tipo;
    }

    /**
     * Get the value of doc_id_proceso
     */ 
    public function getDoc_id_proceso()
    {
        return $this->doc_id_proceso;
    }

    /**
     * Set the value of doc_id_proceso
     *
     * @return  self
     */ 
    public function setDoc_id_proceso($doc_id_proceso)
    {
        $this->doc_id_proceso = $doc_id_proceso;
    }
}

?>