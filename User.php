<?php
    require_once("DBConn.php");
    class User{
        //Fields
        public $id = 0;
        public $username = "";
        public $password = "";
        public $createdate = 0; 
        public $isadmin = 0; 

        function populate($userId){
            $dbconn = new DBConn();
            $dbconn->open();        
            $sql = "SELECT * FROM `jogablogwen-code-recovery`.users where id=".$userId;
            $result = $dbconn->conn->query($sql);
            if(mysqli_num_rows($result) != 0){
                $row = mysqli_fetch_assoc($result);
                $this->id = $userId; 
                $this->username = $row['username'];
                $this->password = $row['password'];
                $this->createdate = $row['createdate'];
            }
            $result->free_result();
            $dbconn->close();
        }
        public static function validate_user($uName, $pWord){
            $userId = 0; 
            $sql = "SELECT * FROM `jogablogwen-code-recovery`.users where username='".$uName."' and password='".$pWord."';";
            $dbconn = new DBConn();
            $dbconn->open();   
            $result = $dbconn->conn->query($sql);
            $num_rows = mysqli_num_rows($result);
            if($num_rows > 0){
                $row = mysqli_fetch_assoc($result);
                $userId = $row['id'];
            }
            $result->free_result();
            $dbconn->close();
            return $userId; 
        }


        public static function delete($pId){
            $userId = 0; 
            $sql = "DELETE FROM `jogablogwen-code-recovery`.users where id=".$pId;
            $dbconn = new DBConn();
            $dbconn->open();   
            $dbconn->conn->query($sql);
            $dbconn->close();
        }

        public function insert(){
            $affected_rows = 0; 
            $dbconn = new DBConn();
            $dbconn->open(); 
            if(!$dbconn->conn->connect_errno){
                $sql = "INSERT INTO `jogablogwen-code-recovery`.users (username, password,  createdate,) values('{$this->username}','{$this->password}',NOW());";
                if ($dbconn->conn->query($sql)) {
                    //Get ID of new record
                    $this->id = $dbconn->conn->insert_id;
                    $affected_rows = $dbconn->conn->affected_rows;
                } 
            }
            $dbconn->close();
            return $affected_rows;
        }
   
        public function update(){
            $affected_rows = 0; 
            $dbconn = new DBConn();
            $dbconn->open(); 
            if(!$dbconn->conn->connect_errno){
                $sql = "UPDATE `jogablogwen-code-recovery`.users SET username='{$this->username}',WHERE id ='{$this->id}';";
                if ($dbconn->conn->query($sql)) {
                    $affected_rows = $dbconn->conn->affected_rows; 
                } 
            }
            $dbconn->close();
            return $affected_rows;
        }
    }

?>