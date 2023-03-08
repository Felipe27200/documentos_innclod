<?php
namespace controller;

session_start();

$sesionController = new SesionController($_POST ?? $_GET);

class SesionController
{
    private $documentoDao;
    
    public function __construct($request)
    {
        if (!isset($request['metodo']))
            $request = $_GET;

        if (isset($request['metodo']))
            $this->{$request["metodo"]}($request);
        else
        {
            header("Location:../views/sesion.php");
            die();    
        }
    }

    public function login($request)
    {
        if ($request['usuario'] == "usuario1" && $request['password'] == "usuario123")
        {
            $_SESSION['login'] = true;

            header("Location: ../views/documento/documento-view.php");
        } 
        else
        {
            header("Location: ../views/sesion.php");
            die();
        }
    }

    public function logout()
    {
        $_SESSION['login'] = false;
        session_destroy();
        header('Location: ../views/sesion.php');
        die();
    }
}

?>