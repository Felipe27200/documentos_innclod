<?php
namespace config;

use PDO;
use PDOException;

class Connection
{
    private $host;
    private $user;
    private $password;

    public function __construct($host = "localhost", $user = "root", $password = "")
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
    }

    public function obtenerConexion()
    {
        $conexion = NULL;

        try
        {
            $conexion = new PDO("mysql:host=".$this->host.";dbname=registro_docs;charset=utf8", $this->user, $this->password);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e)
        {
            return $e->getMessage();
        }

        return $conexion;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }
}

?>