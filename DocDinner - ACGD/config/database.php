<?php
$host = "localhost";
$dbname = "control_gastos";
$username = "root"; // Cambia si usas otro usuario
$password = ""; // Cambia si tienes contraseña
    

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}
?>

<?php
// Archivo de conexión a la base de datos

class Database {
    private static $host = 'localhost';
    private static $db_name = 'control_gastos';
    private static $username = 'root';
    private static $password = '';
    private static $conn;

    public static function conectar() {
        if (!self::$conn) {
            try {
                self::$conn = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$db_name, self::$username, self::$password);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Error de conexión: " . $e->getMessage());
            }
        }
        return self::$conn;
    }
}

