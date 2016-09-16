<?php

class Db {
    // The database connection
    protected static $connection;

    public function connect() {

        // Try and connect to the database, if a connection has not been established yet
        if(!isset(self::$connection)) {
            self::$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        }

        // If connection was not successful, handle the error
        if(self::$connection === false) {
            /*$die = sprintf(
                    "There doesn't seem to be a connection to %s database. I need this before we can get started.",
                    DB_NAME
                ) . '</p>';
            echo $die;
            die();*/
            return mysqli_connect_error();
        }
        return self::$connection;
    }

    public function query($query) {
        // Connect to the database
        $connection = $this->connect();
        if($connection == mysqli_connect_error()) {
            return db_error();
        }
        // Query the database
        $result = $connection->query($query);

        return $result;
    }

    function select($query) {
        $rows = array();
        $result = $this->query($query);
        // If query failed, return `false`
        if($result === false) {
            return false;
        }

        // If query was successful, retrieve all the rows into an array
        while($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    function db_quote($value) {
        $connection = $this->connect();
        return "'" . $connection->real_escape_string($value) . "'";
    }

    function db_error() {
        $connection = $this->connect();
        return $connection->error;
    }
}

?>