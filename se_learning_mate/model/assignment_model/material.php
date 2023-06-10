<?php

    class Material{
        private $host;
        private $user;
        private $pw;
        private $dbname;
        private $port;
        private $connect;

        private $file_category;

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

            $file_category = 1;
        }

        public function createMaterial($mentor, $file_id, $title){
            $date = date('Y-m-d H:i:s');
            $sql = ("INSERT INTO se_material(uploader, upload_date, file_id, title) VALUES('$mentor', '$date', $file_id, '$title')");
            $result = mysqli_query($this->connect, $sql);
            echo mysqli_error($this->connect);
            return $result;
        }

        public function getMaterialList($mentor){
            $sql = ("SELECT uploader, title, file_name, file_url FROM se_material JOIN se_file ON se_material.file_id = se_file.file_id WHERE uploader = '$mentor' AND file_category = 1");
            $result = mysqli_query($this->connect, $sql);
            echo mysqli_error($this->connect);
            $rowNums = mysqli_num_rows($result);
            if($rowNums > 0){
                $list = array();
                while($row = mysqli_fetch_row($result)){
                    array_push($list, json_encode(array(
                        'uploader' => $row[0],
                        'title' => $row[1],
                        'file_name' => $row[2],
                        'file_url' => $row[3]
                    )));
                }
                return json_encode($list);
            }
            else{
                return 'None';
            }
        }
    }



?>