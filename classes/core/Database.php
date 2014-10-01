<?php
class Database {

    private $dbConnection;

    public function __construct(){
        $this->initializeDB();
    }

    public function initializeDB() {
        $dbConnection = mysql_connect("localhost","redacted_user","redacted_pass");
        if (!dbConnection) {
            echo "Database connection failure, error - " . mysql_error();exit;
        }
        mysql_select_db("simpleapi_db");


        // Set connection to the database
        $this->setDBconnection($dbConnection);
    }

    public function getDBConnection() {
        return $this->dbConnection;
    }

    public function setDBConnection($dbConnection) {
        $this->dbConnection = $dbConnection;
    }

    public function query($queryString) {
        return mysql_query($queryString,$this->dbConnection);
    }

    public function close() {
        mysql_close($this->dbConnection);
    }
}

?>