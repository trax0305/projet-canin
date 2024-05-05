<?php
class Connexion {
    private $pdo;

    public $host = "localhost";
    public $username = "root";
    public $password = "";
    public $database = "toilettage";
 
    function __construct() {
        // Créer une instance PDO à partir des paramètres de connexion
        $dsn = "mysql:host={$this->host};dbname={$this->database}";
        $this->pdo = new PDO($dsn, $this->username, $this->password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Méthode pour obtenir l'instance PDO
    public function getPDO() {
        return $this->pdo;
    }

    // Méthode pour exécuter les requêtes SQL
    public function query($sql) {
        return $this->pdo->query($sql);
    }
}
?>