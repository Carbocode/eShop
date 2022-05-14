<?php

class Pages
{
    private $pdo;

    private $db_table = 'pages';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read()
    {
        $query = "SELECT * FROM $this->db_table";
        $stmt = $this->pdo->query($query);
    }
}