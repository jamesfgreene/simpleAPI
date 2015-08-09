<?php
namespace simpleAPI\core;

class Database {

    private $dbConnection;

    public function __construct(){
        $this->initializeDB();
    }

    public function initializeDB() {
        //$dbConnection = mysql_connect("localhost","redacted_user","redacted_pass");
		$dbConnection = mysql_connect("localhost","jamesfgr_dbuser","j@m3sfgr33n3");
        if (!dbConnection) {
            echo "Database connection failure, error - " . mysql_error();exit;
        }
        mysql_select_db("jamesfgr_db");


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