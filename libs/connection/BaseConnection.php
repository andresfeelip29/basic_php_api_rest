<?php

include "conexion.php";

class BaseConnection
{
    function __construct()
    {
        $this->db = Connection::getConnection();
    }

    function query($query)
    {
        return $this->db->Connect()->query($query);
    }

    function prepare($query)
    {
        return $this->db->Connect()->prepare($query);
    }

    function close()
    {
        return $this->db->Close();
    }
}
