<?php

    class Quiz{
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

        public function createOuterQuiz($mentor_id, $title, $time_limit, $perfect_score){
            $sql = ("INSERT INTO se_quiz(quiz_owner, title, time_limit, quiz_grade, perfect_score) VALUES('$mentor_id', '$title', $time_limit, DEFAULT(quiz_grade), $perfect_score)");
            $result = mysqli_query($this->connect, $sql);
            echo mysqli_error($this->connect);
            if($result == 1){
                $id = $this->getLastestQuizId();
                return $id;
            }
            else{
                return 'Fail';
            }

        }

        public function createQuizContent($quiz_id, $question, $point, $c1, $c2, $c3, $c4, $answer){
            $sql = ("INSERT INTO se_quiz_contents(quiz_id, question, point, choice1, choice2, choice3, choice4, answer) VALUES($quiz_id, '$question', $point, '$c1', '$c2', '$c3', '$c4', '$answer')");
            $result= mysqli_query($this->connect, $sql);
            echo mysqli_error($this->connect);
            return $result;
        }

        public function getLastestQuizId(){
            $sql = ("SELECT quiz_id FROM se_quiz ORDER BY quiz_id DESC LIMIT 1");
            $result = mysqli_query($this->connect, $sql);
            echo mysqli_error($this->connect);
            $rowNum = mysqli_num_rows($result);
            if($rowNum == 0){
                return null;
            }
            else{
                $row = mysqli_fetch_row($result);
                return $row[0];
            }
        }

        public function getQuizList($mentor_uid){
            $sql = ("SELECT * FROM se_quiz WHERE quiz_owner = '$mentor_uid'");
            $result = mysqli_query($this->connect, $sql);
            echo mysqli_error($this->connect);
            $rowNums = mysqli_num_rows($result);
            if($rowNums > 0){
                $list = array();
                while($row = mysqli_fetch_row($result)){
                    array_push($list, json_encode(array(
                        'quiz_id' => $row[0],
                        'quiz_owner' => $row[1],
                        'title' => $row[2],
                        'time_limit' => $row[3],
                        'quiz_grade' => $row[4],
                        'perfect_score' => $row[5],
                    )));
                }
                return json_encode($list);
            }
            else{
                return 'None';
            }
        }

        public function getQuizContent($quiz_id){
            $sql = ("SELECT * FROM se_quiz_contents WHERE quiz_id = $quiz_id");
            $result = mysqli_query($this->connect, $sql);
            echo mysqli_error($this->connect);
            $rowNum = mysqli_num_rows($result);
            if($rowNum > 0){
                $list = array();
                while($row = mysqli_fetch_row($result)){
                    array_push($list, json_encode(array(
                        'qc_id' => $row[0],
                        'quiz_id' => $row[1],
                        'question' => $row[2],
                        'point' => $row[3],
                        'choice1' => $row[4],
                        'choice2' => $row[5],
                        'choice3' => $row[6],
                        'choice4' => $row[7],
                        'answer' => $row[8]
                    )));
                }
                return json_encode($list);
            }
            else{
                return 'None';
            }
        }

        public function updateQuizGrade($quiz_id, $score){
            $sql = ("UPDATE se_quiz SET quiz_grade = $score WHERE quiz_id = $quiz_id");
            $result = mysqli_query($this->connect, $sql);
            return $result;
        }
    }


?>