<?php

class Database {

    private $servername;
    private $username;
    private $password;
    private $name;

    protected function connect() {

        $this->servername = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->name = "dbteh-kursa_darbs";

        $conn = new mysqli($this->servername, $this->username, $this->password, $this->name);

        return $conn;
    }
}