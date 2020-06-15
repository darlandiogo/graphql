<?php

class Connection {

    protected $dsn =  '';
    protected $user = '';  
    protected $password = ''; 
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