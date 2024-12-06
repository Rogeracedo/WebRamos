<?php
class Conexion
{
    private $user;
    private $password;
    private $host;
    private $port;
    private $dbname;

    function __construct()
    {
        $this->user = "root";
        $this->password = "";
        $this->host = "localhost";
        $this->port = 3306;
        $this->dbname = "webramos";
    }

    function getConnection()
    {
        try {
            $conn = mysqli_connect($this->host, $this->user, $this->password, $this->dbname, $this->port);
            return $conn;
        } catch (Exception $e) {
            echo "Error: " . $e;
        }
    }

    // function __construct()
    // {
    //     $this->user = getenv('DB_USER');  // Usuario de la base de datos
    //     $this->password = getenv('DB_PASSWORD');  // Contraseña de la base de datos
    //     $this->dbname = getenv('DB_NAME');  // Nombre de la base de datos
    //     $this->host = getenv('DB_HOST');  // Ruta de Cloud SQL
    // }

    // function getConnection()
    // {
    //     try {
    //         $conn = mysqli_connect($this->host, $this->user, $this->password, $this->dbname);
    //         if (!$conn) {
    //             throw new Exception('Conexión fallida: ' . mysqli_connect_error());
    //         }
    //         return $conn;
    //     } catch (Exception $e) {
    //         echo "Error: " . $e->getMessage();
    //     }
    // }
}
