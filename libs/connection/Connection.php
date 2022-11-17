<?php

require_once('../../config/config.php');

class Connection
{
    private $server;
    private $user;
    private $password;
    private $dataBase;
    private Connection $connection;

    private function __construct()
    {
        $this->server   = constant('HOST');
        $this->user      = constant('USER');
        $this->password = constant('PASSWORD');
        $this->dataBase  = constant('DB');
    }

    public static function getConnection()
    {
        if (!isset(Connection::$connection)) {

            Connection::$connection = new Connection;
        }

        return Connection::$connection;
    }

    function Connect()
    {
        try {
            $this->connection = new PDO("mysql:host=$this->server;dbname=$this->dataBase", "$this->user", "$this->password");
            error_log('Conexión a BD exitosa');
        } catch (PDOException $e) {
            error_log('Error en conexion BD :: ' . $e->getMessage());
        }
    }

    function Close()
    {
        $this->connection->close();
    }
}
