<?php

    class DBConn{

        public $conn;

        public function open() {
            $this->conn = new mysqli("localhost", "root", "password", "jogablogwen-code-recovery"); 
        }
    
        public function close(){
            $this->conn -> close();
        }

    }

?>