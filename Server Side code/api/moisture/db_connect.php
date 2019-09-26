<?php

class DB_CONNECT {
 
    private $con;
    // Constructor
    function __construct() {
        // Trying to connect to the database
        $this->connect();
    }
 
    // Destructor
    function __destruct() {
        // Closing the connection to database
        $this->close();
    }
 
   // Function to connect to the database
    private function connect() {
        $con = null;

        try {
            //importing dbconfig.php file which contains database credentials 
            $filepath = realpath (dirname(__FILE__));
     
            require_once($filepath."/dbconfig.php");
            
            // Connecting to mysql (phpmyadmin) database
            $con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD);

            if (!$con) {
                echo "Error: Unable to connect to MySQL." . PHP_EOL;
                echo "MySQL Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                echo "MySQL Debugging error: " . mysqli_connect_error() . PHP_EOL;
                exit;
            }

            // Selecing database
            $db = mysqli_select_db($con, DB_DATABASE) or die(mysqli_error($con));
            
            // Save/Update connection
            $this->con = $con;
        } catch (Exception $e) {
            echo 'Exception in MySQL connect. ',  $e->getMessage(), "\n";
        } finally {
            // echo "Successfully connected to MySQL database.\n";
        }

        // returing connection cursor
        return $con;
    }

    // Function to get MySQL connection. 
    public function getConnection() {
        if ($this->con) {
            return $this->con;
        } else {
            return $this->connect();
        }
    }
 
    // Function to close the database
    public function close() {
        // Closing data base connection
        $con = $this->connect();
        mysqli_close($con);
    }
 
}
 
?>