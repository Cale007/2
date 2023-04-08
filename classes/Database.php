 <?php
class Database {

// Připojená instance PDO

private static PDO $connection;

// Nastavení PDO

private static array $settings = Array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
    PDO::ATTR_EMULATE_PREPARES => false,
);

//Připojí se k databázi a spojení uloží do proměnné

public static function connect(string $host, string $user, string $password, string $database) : PDO
{
    if (!isset(self::$connection)) {
        self::$connection = @new PDO(
            "mysql:host=$host;dbname=$database",
            $user,
            $password,
            self::$settings
        );
    }
    return self::$connection;
}

//Spustí na databázi SQL dotaz s danými parametry a vrátí ho pro pozdější získání výsledků

public static function ask(string $sql, array $parametrs = array()) : PDOStatement
{
    $ask = self::$connection->prepare($sql);
    $ask->execute($parametrs);
    return $ask;
}

}