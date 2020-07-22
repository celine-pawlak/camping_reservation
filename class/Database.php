<?php

class Database{
    private $db_host;
    private $db_login;
    private $db_password;
    private $db_name;
    public $PDO;

    public function __construct()
    {
        $this->db_host = "localhost";
        $this->db_login = "root";
        $this->db_password = "root";
        $this->db_name = "camping";

    }

    public function connectDb(){
        try {
            $this->PDO = new PDO("mysql:dbname=$this->db_name;host=$this->db_host;charset=utf8;", $this->db_login, $this->db_password);
            return $this->PDO;
        } catch (PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage();
        }
    }
}