<?php
class Connection {
    private $host = "localhost";
    private $dbname = "control_gastos"; 
    private $username = "root";
    private $password = "";
    public $conn;


    public function open() {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (PDOException $e) {
            echo "Error en la conexión: " . $e->getMessage();
        }
    }

    public function close() {
        $this->conn = null;
    }
}
?>

