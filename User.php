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


        public static function delete($pId) {
            $dbconn = new DBConn();
            $dbconn->open();
            
            // Using prepared statement
            $stmt = $dbconn->conn->prepare("DELETE FROM `jogablogwen-code-recovery`.users WHERE id = ?");
            if (!$stmt) {
                $dbconn->close();
                return false; // failed to prepare
            }
        
            $stmt->bind_param("i", $pId);
            $success = $stmt->execute();  // returns true/false
            $stmt->close();
            $dbconn->close();
        
            return $success; // <<< Return true if delete successful, false otherwise
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
        public function update($userId, $newUsername) {
            $dbconn = new DBConn();
            $dbconn->open();
            $stmt = $dbconn->conn->prepare("UPDATE `jogablogwen-code-recovery`.users SET username = ? WHERE id = ?");
            $stmt->bind_param("si", $newUsername, $userId);
            $success = $stmt->execute();
            $stmt->close();
            $dbconn->close();
            return $success;
        }
        
    }

?>