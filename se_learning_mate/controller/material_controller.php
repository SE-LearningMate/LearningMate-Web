<?php
    require '/host/home3/windry/html/se_learning_mate/model/assignment_model/material.php';
    require '/host/home3/windry/html/se_learning_mate/model/file_model/file.php';
    $matObj = new Material();
    $fileObj = new HandleFile();
    session_start();
    $user = $_SESSION['user'];

    $chkMobile = 0;
    $value = $_SERVER['HTTP_USER_AGENT'];
    if(strpos($value, 'okhttp') !== false){
		$chkMobile = 1;
	} else { 
		$chkMobile = 0;
	}

    if($chkMobile == 1){
        // 모바일 요청 시
        $create_uid = $_POST['create_uid'];
        $title = $_POST['title'];
        if($create_uid != null && $title != null){
            $file_result = $fileObj->uploadFile($create_uid, $_FILES['fileToUpload'], 1);
            if($file_result == '파일 업로드 성공'){
                $file_id = $fileObj->getFileId();
                $result = $matObj->createMaterial($create_uid, $file_id, $title);
                echo $result;
            }
            else{
                echo 'File failure';
            }
            return;
        }

        $get_uid = $_POST['get_uid'];
        if($get_uid != null){
            echo $matObj->getMaterialList($get_uid);
            return;
        }
    }
    else{
        // 웹 요청 시
        $w_title = $_POST['w_title'];
        if($w_title != null){
            $user = json_decode($user, true);
            $file_r = $fileObj->uploadFile($user['uid'], $_FILES['fileToUpload'], 1);
            if($file_r == '파일 업로드 성공'){
                $file_id = $fileObj->getFileId();
                $result = $matObj->createMaterial($user['uid'], $file_id, $w_title);
                echo "<script>location.href='../view/contents.php';</script>";
            }
        }
        
    }

?>