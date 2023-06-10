<?php
    require '/host/home3/windry/html/se_learning_mate/model/assignment_model/quiz.php';
    $quizObj = new Quiz();
    $chkMobile = 0;
    
    $value = $_SERVER['HTTP_USER_AGENT'];
    if(strpos($value, 'okhttp') !== false){
		$chkMobile = 1;
	} else { 
		$chkMobile = 0;
	}
    if($chkMobile == 1){
        // 모바일 요청 시

        $update_grade_quiz_id = $_POST['update_grade_quiz_id'];
        $update_grade_score = $_POST['update_grade_score'];
        if($update_grade_quiz_id != null && $update_grade_score != null){
            $result = $quizObj->updateQuizGrade($update_grade_quiz_id, $update_grade_score);
            echo $result;
            return;
        }

        $quiz_id_detail = $_POST['quiz_id_detail'];
        if($quiz_id_detail != null){
            $result = $quizObj->getQuizContent($quiz_id_detail);
            echo $result;
            return;
        }

        $quiz_uid = $_POST['get_quiz_uid'];
        if($quiz_uid != null){
            $result = $quizObj->getQuizList($quiz_uid);
            echo $result;
            return;
        }

        $create_uid = $_POST['create_uid'];
        $create_title = $_POST['create_title'];
        $time_limit = $_POST['time_limit'];
        $perfect_score = $_POST['perfect_score'];
        if($create_uid != null && $create_title != null && $time_limit != null && $perfect_score != null){
            $quiz_id = $quizObj->createOuterQuiz($create_uid, $create_title, $time_limit, $perfect_score);
            echo $quiz_id;
            return;
        }

        $quiz_id = $_POST['quiz_id'];
        $question = $_POST['question'];
        $point = $_POST['point'];
        $choice1 = $_POST['choice1'];
        $choice2 = $_POST['choice2'];
        $choice3 = $_POST['choice3'];
        $choice4 = $_POST['choice4'];
        $answer = $_POST['answer'];
        if($quiz_id != null && $question != null && $point != null && $choice1 != null && $choice2 != null && $choice3 != null && $choice4 != null && $answer != null){
            $result = $quizObj->createQuizContent($quiz_id, $question, $point, $choice1, $choice2, $choice3, $choice4, $answer);
            echo $result;
            return;
        }
    }
    else{
        // 웹 요청 시
    }

?>