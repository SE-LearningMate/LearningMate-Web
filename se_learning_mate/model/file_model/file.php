<?php

    class HandleFile{
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

        public function uploadFile($currentUser, $fileHandler, $file_category){

            $target_dir = '/host/home3/windry/html/se_learning_mate/files/';
            $file_basename = basename($fileHandler['name']);
            $file_ext = substr(strrchr($file_basename, '.'), 1);
            $fileNameWithoutExt = substr($file_basename, 0, strrpos($file_basename, '.'));
            
            // echo $file_ext;
            // echo $fileNameWithoutExt;
            
            $hash_filename = md5(uniqid(rand(), true));
            $hash_filename_with_ext = $hash_filename.'.'.$file_ext;
            
            $target_file = $target_dir.$hash_filename_with_ext;
            // $finalUser = "";
            // echo $currentUser;
            // if($platform == 1){
                // $finalUser = $currentUser;
            // }
            // else{
                // $finalUser = $currentUser['uid'];
            // }
            $tmp_name = $fileHandler['tmp_name'];
            $upload_result = move_uploaded_file($tmp_name, $target_file);
            // echo $finalUser;
            $targetUri = 'http://windry.dothome.co.kr/se_learning_mate/files/';
            $storedUrl  = $targetUri.$hash_filename_with_ext;
            // $origin = '".$currentUser['uid']."';
            if($upload_result){
                $currentTime = date('Y-m-d H:i:s');
                $sql = ("INSERT INTO se_file(file_uploader, file_category, upload_date, file_name, file_hash_name, file_url, file_size) VALUES('$currentUser', $file_category,'$currentTime', '$file_basename', '$hash_filename_with_ext', '$storedUrl', '".$fileHandler['size']."') ");
                $result = mysqli_query($this->connect, $sql);
                echo mysqli_error($this->connect);
                if($result == 1){
                    return '파일 업로드 성공';
                }
                else{
                    return '파일 저장 성공 그러나 trace 실패';
                }
            }
            else{
                return '파일 업로드 실패';
            }
        }

        public function getFilesByMentor($mentor_uid, $file_category){
            $sql = ("SELECT * FROM se_file WHERE file_category = $file_category AND file_uploader = '$mentor_uid'");
            $result = mysqli_query($this->connect, $sql);
            echo mysqli_error($this->connect);
            $list = array();
            while($row = mysqli_fetch_row($result)){
                array_push($list, json_encode(array(
                    "file_id" => $row[0],
                    "file_uploader" => $row[1],
                    "file_category" => $row[2],
                    "upload_date" => $row[3],
                    "file_name" => $row[4],
                    "file_hash_name" => $row[5],
                    "file_url" => $row[6],
                    "file_size" => $row[7]
                )));
            }
            echo json_encode($list);
        }

        public function getOneFileByMentor($mentor_uid, $file_id, $file_category){
            $sql = ("SELECT * FROM se_file WHERE file_id = $file_id AND file_uploader = '$mentor_uid' AND file_category = $file_category");
            $result = mysqli_query($this->connect, $sql);
            echo mysqli_error($this->connect);
            $rowNum = mysqli_num_rows($result);

            if($rowNum == 1){
                $row = mysqli_fetch_row($result);
                $fileData = json_encode(array(
                    'file_id' => $row[0],
                    'file_uploader' => $row[1],
                    'file_category' => $row[2],
                    'upload_date' => $row[3],
                    'file_name' => $row[4],
                    'file_hash_name' => $row[5],
                    'file_url' => $row[6],
                    'file_size' => $row[7]
                ));
                return $fileData;
            }
            else{
                return 'Not Found File Data';
            }
        }

        public function getFileId(){
            $sql = ("SELECT file_id FROM se_file ORDER BY file_id DESC LIMIT 1");
            $result = mysqli_query($this->connect, $sql);
            echo mysqli_error($this->connect);
            $row = mysqli_fetch_row($result);
            return $row[0];
        }
    }

?>