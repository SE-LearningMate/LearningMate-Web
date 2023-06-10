<?php
    
    class User{
        private $host;
        private $user;
        private $pw;
        private $dbname;
        private $port;
        private $connect;

        function __construct(){
            $this->host = 'localhost';
            $this->user = 'windry';
            $this->pw = 'zmalqp10!';
            $this->dbname = 'windry';
            $this->port = '3306';
            $this->connect = mysqli_connect($this->host
            , $this->user
            , $this->pw
            , $this->dbname
            , $this->port);
        }

        public function checkDuplicateUid($uid){
            $sql = ("SELECT uid FROM se_user WHERE uid = '$uid'");
            $result = mysqli_query($this->connect, $sql);
            echo mysqli_error($this->connect);
            $rowNum = mysqli_num_rows($result);
            return $rowNum;
        }

        public function requestSignIn($uid, $pw){
            $sql = ("SELECT * FROM se_user WHERE uid = '$uid'");

            $result = mysqli_query($this->connect, $sql);
            echo mysqli_error($this->connect);
            $rowNum = mysqli_num_rows($result);

            if($rowNum == 1){
                $row = mysqli_fetch_row($result);
                $hash = $row[1];

                if(password_verify($pw, $hash)){
                    $result_user = json_encode(array(
                        'uid' => $row[0],
                        'userName' => $row[2],
                        'identity' => $row[3],
                        'rDate' => $row[4],
                        'pair_uid' => $row[5]
                    ));

                    return $result_user;
                }
                else{
                    return 'Wrong Password!';
                }
            }
            else{
                return 'Invalid User!';
            }        
        }

        public function requestSignUp($uid, $password, $userName, $identity){
            $rDate = date('Y-m-d');
            $encrypted_pw = password_hash($password, PASSWORD_DEFAULT);
            if($identity == null){
                $identity = 0; 
            }
            $sql = ("INSERT INTO se_user(uid, password, userName, identity, regDate, pair_uid) VALUES ('$uid', '$encrypted_pw', '$userName', $identity, '$rDate', DEFAULT(pair_uid))");
            $result = mysqli_query($this->connect, $sql);
            echo mysqli_error($this->connect);

            return $result;
        }

        public function requestSignOut(){

        }
        
        public function requestWithdraw(){
            
        }

        public function getAllUserByIdentity($myIdentity){
            if($myIdentity == 0){
                $idt = 1;
            }
            else{
                $idt = 0;
            }
            $sql = ("SELECT * FROM se_user WHERE identity = $idt AND pair_uid IS NULL");
                $result = mysqli_query($this->connect, $sql);
                echo mysqli_error($this->connect);
                $list = array();
                while($row = mysqli_fetch_row($result)){
                    array_push($list, json_encode(array(
                        'uid' => $row[0],
                        'userName' => $row[2],
                        'identity' => $row[3],
                        'rDate' => $row[4],
                        'pair_uid' => $row[5]
                    )));
                }
                return json_encode($list);
        }

        public function updatePairUser($myUid, $targetUid){
            $sql = ("UPDATE se_user SET pair_uid = '$targetUid' WHERE uid = '$myUid'");
            $result = mysqli_query($this->connect, $sql);
            $sql2 = ("UPDATE se_user SET pair_uid = '$myUid' WHERE uid ='$targetUid'");
            $result2 = mysqli_query($this->connect, $sql2);
            echo mysqli_error($this->connect);
            return $result + $result2;
        }
    }

    class Mentore extends User{

    }

    class Mentee extends User{

    }


?>