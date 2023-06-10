<?php
    require '/host/home3/windry/html/se_learning_mate/model/assignment_model/assignment.php';
    $assignmentObj = new Assignment();
    require '/host/home3/windry/html/se_learning_mate/model/file_model/file.php';
    $fileObj = new HandleFile();

    session_start();
    $user = $_SESSION['user'];
    $user = json_decode($user, true);

    $chkMobile = 0;
    $value = $_SERVER['HTTP_USER_AGENT'];
    if(strpos($value, 'okhttp') !== false){
		$chkMobile = 1;
	} else { 
		$chkMobile = 0;
	}

    $mUser = $_POST['mUser'];

    $wUser = $_POST['wUser'];
    // if($wUser != null){
    // }
    $userIdentity = $_POST['identity'];
    $pair_uid = $_POST['pair'];
    $mentor = "";

    $alert_mentor_for_mentee = $_POST['alert_mentor_for_mentee'];
    $state = $_POST['state'];
    if($alert_mentor_for_mentee != null && $state != null){
        $result = $assignmentObj->getNewTask($alert_mentor_for_mentee, $state);
        echo $result;
    }

    $alert_mentor = $_POST['alert_mentor'];
    if($alert_mentor != null){
        $result = $assignmentObj->getMenteeSubmissionList($alert_mentor);
        echo $result;
        return;
    }

    $submitId = $_POST['submit_id'];
    if($submitId != null){
        $result = $assignmentObj->getSubmissionInfo($submitId);
        echo $result;
        return;
    }

    $submitter = $_POST['submitter'];
    $assign_id_submit = $_POST['assign_id_submit'];

    if($submitter != null && $assign_id_submit != null){
        if($_FILES['fileToUpload']['name'] != ''){
            $result = $fileObj->uploadFile($submitter, $_FILES['fileToUpload'], 0);
            if($result == '파일 업로드 성공'){
                // echo $result;
                $gotFileId = $fileObj->getFileId();
                $submitResult = $assignmentObj->submitAssignment($submitter, $assign_id_submit, $gotFileId);
                if($submitResult == 'submitted'){

                    $submitId = $assignmentObj->getSubmitId();
                    $updateResult = $assignmentObj->updateSubmissionForAssignment($assign_id_submit, $submitId);
                    echo $updateResult;
                }
                else{
                    echo $submitResult;
                }
            }
            else{
                $gotFileId = null;
            }
        }
        else{
            $gotFileId = null;
        }
        return;
    }

    $web_grade = $_POST['grade'];
    $web_update_score_id = $_POST['update_score_id'];
    if($web_grade != null && $web_update_score_id != null){
        $result = $assignmentObj->updateAssignmentScore($web_update_score_id, $web_grade);
        if($result == 1){
            echo "<script>location.href='../view/homework.php';</script>";
        }
        else{
            echo "<script> alert('점수 반영 실패');</script>";
        }
        return;
    }

    $web_submission = $_POST['web_submit_request'];
    $web_assign_id = $_POST['web_assign_id'];
    if($web_submission != null && $web_assign_id != null){
        if($_FILES['fileToUpload']['name'] != ''){
            $result = $fileObj->uploadFile($user['uid'], $_FILES['fileToUpload'], 0);
            if($result == '파일 업로드 성공'){
                $file_id = $fileObj->getFileId();
                $submitResult = $assignmentObj->submitAssignment($user['uid'], $web_assign_id, $file_id);
                if($submitResult == 'submitted'){
                    $submitId = $assignmentObj->getSubmitId();
                    $updateResult = $assignmentObj->updateSubmissionForAssignment($web_assign_id, $submitId);
                    if($updateResult == 1){
                        echo "<script>location.href='../view/homework.php';</script>";
                    }
                    else{
                        echo "<script> alert('실패'); </script>";
                    }
                }
            }
        }
    }

    $w_submitter = $_POST['w_submitter'];
    $w_assign_id = $_POST['w_assign_id'];
    if($w_submitter != null && $w_assign_id != null){
        if($_FILES['fileToUpload']['name'] != ''){
            $result = $fileObj->uploadFile($w_submitter, $_FILES['fileToUpload'], 0);
            if($result == '파일 업로드 성공'){
                // echo $result;
                $gotFileId = $fileObj->getFileId();
                $submitResult = $assignmentObj->submitAssignment($w_submitter, $w_assign_id, $gotFileId);
                if($submitResult == 'submitted'){

                    $submitId = $assignmentObj->getSubmitId();
                    $updateResult = $assignmentObj->updateSubmissionForAssignment($w_assign_id, $submitId);
                    echo $updateResult;
                }
                else{
                    echo $submitResult;
                }
            }
            else{
                $gotFileId = null;
            }
        }
        else{
            $gotFileId = null;
        }
        return;
    }

    $assign_id = $_POST['assign_id'];
    $score_to_update = $_POST['score'];

    if($assign_id != null && $score_to_update != null){
        $result = $assignmentObj->updateAssignmentScore($assign_id, $score_to_update);
        echo $result;
        return;
    }

    if($userIdentity != null && $mUser != null && $pair_uid != null){
        if($userIdentity == 0){
            $mentor = $pair_uid;   
        }
        else{
            $mentor = $mUser;
        }
        echo $assignmentObj->getAssignmentListByMentor($mentor);
        return;
    }

    if($chkMobile == 1){
        $title = $_POST['m_title'];
        $body = $_POST['m_content'];
        $perfect_score = $_POST['m_perfect_score'];
        $due_date = $_POST['m_due_date'];
        
        if($_FILES['fileToUpload']['name'] != ''){
            $result = $fileObj->uploadFile($mUser, $_FILES['fileToUpload'], 0);
            if($result == '파일 업로드 성공'){
                // echo $result;
                $gotFileId = $fileObj->getFileId();
                // echo $gotFileId;
                $resultMessage = $assignmentObj->createAssignment($mUser, $title, $body, $perfect_score, $due_date, $gotFileId);
                echo $resultMessage;
            }
            else{
                $gotFileId = null;
            }
        }
        else{
            $gotFileId = null;
        }

        
        return;
    }

    $createState = $_POST['create'];
    // echo $createState;
    
    if($createState != null && $chkMobile == 0){
        $wUser = json_decode($wUser, true);
        $title = $_POST['title'];
        $body = $_POST['content'];
        $perfect_score = $_POST['perfect_score'];
        $due_date = $_POST['due_date'];
        
        if($_FILES['fileToUpload']['name'] != ''){
            $result = $fileObj->uploadFile($wUser['uid'], $_FILES['fileToUpload'], 0);
            if($result == '파일 업로드 성공'){
                echo $result;
                $gotFileId = $fileObj->getFileId();
                echo $gotFileId;
            }
            else{
                $gotFileId = null;
            }
        }
        else{
            $gotFileId = null;
        }

        $resultMessage = $assignmentObj->createAssignment($wUser['uid'], $title, $body, $perfect_score, $due_date, $gotFileId);
        if($chkMobile == 0){
            echo "<script>location.href='../view/homework.php';</script>";
        }
    }
    
    


?>