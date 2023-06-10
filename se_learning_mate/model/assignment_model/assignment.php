<?php

    class Assignment{
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

            $file_category = 0;
        }

        public function createAssignment($mentor_id, $title, $body, $perfect_score, $due_date, $file_id){
            $currentDate = date('Y-m-d H:i:s');
            $sql = ("INSERT INTO se_assignment(uploader
                , assign_date
                , assignment_title
                , assignment_body
                , perfect_score
                , file_id
                , submit_id
                , due_date) VALUES('$mentor_id'
                        , '$currentDate'
                        , '$title'
                        , '$body'
                        , $perfect_score
                        , '$file_id'
                        , DEFAULT(submit_id)
                        , '$due_date')");
            
            $result = mysqli_query($this->connect, $sql);
            echo mysqli_error($this->connect);

            if($result == 1){
                return 'Created Assignment';
            }
            else{
                return 'Failure';
            }
        }

        public function getAssignmentListByMentor($mentor_id){
            $sql = ("SELECT * FROM se_assignment WHERE uploader = '$mentor_id' ORDER BY assign_date DESC");
            $result = mysqli_query($this->connect, $sql);
            echo mysqli_error($this->connect);
            $rowNums = mysqli_num_rows($result);

            if($rowNums == 0){
                return 'No Assignment';
            }
            else{
                $assignmentList = array();

                while($row = mysqli_fetch_row($result)){
                    array_push($assignmentList, json_encode(array(
                        'assign_id' => $row[0],
                        'uploader' => $row[1],
                        'assign_date' => $row[2],
                        'assignment_title' => $row[3],
                        'assignment_body' => $row[4],
                        'graded_score' => $row[5],
                        'perfect_score' => $row[6],
                        'file_id' => $row[7],
                        'submit_id' => $row[8],
                        'due_date' => $row[9]
                    )));
                }

                return json_encode($assignmentList);
            }
        }

        public function updateAssignmentScore($assign_id, $score_to_update){
            $sql = ("UPDATE se_assignment SET graded_score = $score_to_update WHERE assign_id = $assign_id");
            $result = mysqli_query($this->connect, $sql);
            echo mysqli_error($this->connect);
            return $result;
        }

        public function submitAssignment($mentee, $assign_id, $file_id){
            $date = date('Y-m-d H:i:s');
            $sql = ("INSERT INTO se_assign_submission(assign_id, submit_uid, submit_date, submit_file_id) VALUE($assign_id, '$mentee', '$date', $file_id)");
            $insertResult = mysqli_query($this->connect, $sql);
            echo mysqli_error($this->connect);
            if($insertResult == 1){
                return 'submitted';
            }
            else{
                return 'submission failure';
            }
        }

        public function getSubmitId(){
            $sql = ("SELECT submit_id FROM se_assign_submission ORDER BY submit_id DESC LIMIT 1");
            $result = mysqli_query($this->connect, $sql);
            echo mysqli_error($this->connect);
            $row = mysqli_fetch_row($result);
            return $row[0];
        }

        public function updateSubmissionForAssignment($assign_id, $submit_id){
            $sql = ("UPDATE se_assignment SET submit_id = $submit_id WHERE assign_id = $assign_id");
            $result = mysqli_query($this->connect, $sql);
            echo mysqli_error($this->connect);
            return $result;
        }

        public function getSubmissionInfo($submit_id){
            $sql = ("SELECT submit_id, assign_id, submit_uid, submit_date, submit_file_id, file_name, file_hash_name, file_url FROM se_assign_submission JOIN se_file ON se_assign_submission.submit_file_id = se_file.file_id WHERE submit_id = $submit_id");
            $result = mysqli_query($this->connect, $sql);
            $rowNum = mysqli_num_rows($result);
            if($rowNum == 1){
                $row = mysqli_fetch_row($result);
                return json_encode(array(
                    'submit_id' => $row[0],
                    'assign_id' => $row[1],
                    'submit_uid' => $row[2],
                    'submit_date' => $row[3],
                    'submit_file_id' => $row[4],
                    'file_name' => $row[5],
                    'file_hash_name' => $row[6],
                    'file_url' => $row[7] 
                ));
            }
            else{
                return 'Not Found';
            }
        }

        public function getMenteeSubmissionList($mentor){
            $sql = ("SELECT assignment_title, submit_date FROM se_assignment JOIN se_assign_submission ON se_assignment.assign_id = se_assign_submission.assign_id WHERE uploader = '$mentor' AND se_assignment.submit_id IS NOT NULL");
            $result = mysqli_query($this->connect, $sql);
            echo mysqli_error($this->connect);
            $rowNums = mysqli_num_rows($result);
            if($rowNums > 0){
                $list = array();
                while($row = mysqli_fetch_row($result)){
                    array_push($list, json_encode(array(
                        'title' => $row[0],
                        'date' => $row[1]
                    )));
                }
                return json_encode($list);
            }
            else{
                return 'None';
            }
        }

        public function getNewTask($mentor, $state){
            if($state == 0){// 과제
                $sql = ("SELECT assign_date, assignment_title ,submit_id, due_date FROM se_assignment WHERE uploader = '$mentor'");
                $result = mysqli_query($this->connect, $sql);
                echo mysqli_error($this->connect);
                $rowNums = mysqli_num_rows($result);
                if($rowNums > 0){
                    $list = array();
                    while($row = mysqli_fetch_row($result)){
                        array_push($list, json_encode(array(
                            'date' => $row[0],
                            'title' => $row[1],
                            'submit' => $row[2],
                            'due' => $row[3]
                        )));
                    }
                    return json_encode($list);
                }   
                else{
                    return 'None';
                }
            }
            else{ // 자료
                $sql = ("SELECT upload_date, title FROM se_material WHERE uploader = '$mentor'");
                $result = mysqli_query($this->connect, $sql);
                echo mysqli_error($this->connect);
                $rowNums = mysqli_num_rows($result);
                if($rowNums > 0){
                    $list = array();
                    while($row = mysqli_fetch_row($result)){
                        array_push($list, json_encode(array(
                            'date' => $row[0],
                            'title' => $row[1],
                        )));
                    }
                    return json_encode($list);
                }   
                else{
                    return 'None';
                }            
            }
        }
    }




?>