<?php

//$env = parse_ini_file("./.env");

class Connection {

    protected $dsn =  '';  //'mysql:dbname=testdb;host=127.0.0.1';
    protected $user = '';  //'dbuser';
    protected $password = ''; //'dbpass';
    protected $conn = null;

    public function __construct($env)
    {
        $this->dsn = $env["DB_CONNECTION"].':dbname='.$env["DB_NAME"].';host='.$env["HOST"].';port='.$env["PORT"];
        $this->user = $env["USER"];
        $this->password = $env["PASSWORD"];
    }

    public function getConnection()
    {
        if($this->conn){
            return $this->conn;
        }
        return $this->createConnection();
    }

    public function createConnection()
    {
        try {
            $this->conn = new PDO($this->dsn, $this->user, $this->password);
            return $this->conn;
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    } 

}