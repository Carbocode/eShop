<?php


class DatabaseService
{
    private $db_host;
    private $db_name;
    private $db_user;
    private $db_password;
    private $connection;

    public function getConnection()
    {
        $this->connection = null;
        
        $this->db_host = getenv('DB_HOST') ?: "localhost";
        $this->db_name = getenv('DB_NAME') ?: "DefaultCube";
        $this->db_user = getenv('DB_USER') ?: "root";
        // Check for DB_PASS env var, if not set, use "" (default XAMPP)
        // If set but empty string, it's also ""
        $this->db_password = getenv('DB_PASS');
        if ($this->db_password === false) {
             $this->db_password = ""; 
        }

        try {
            $this->connection = new PDO("mysql:host=" . $this->db_host . ";dbname=" . $this->db_name, $this->db_user, $this->db_password);
        } catch (PDOException $exception) {
            // Echoing here breaks the API JSON response. Logging to stderr instead.
            error_log("Connection failed: " . $exception->getMessage());
        }

        return $this->connection;
    }
}