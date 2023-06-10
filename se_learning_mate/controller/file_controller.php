<?php
    require '/host/home3/windry/html/se_learning_mate/model/file_model/file.php';
    $fileObj = new HandleFile();
    $userData = $_POST['info'];
    // $userData = json_decode($userData, true);
    // json decode 하기
    // echo $userData['uid'];
    $test = $fileObj->uploadFile($userData, $_FILES['fileToUpload'], 0);
    // $test = $_FILES['fileToUpload']['name'];

    // echo $test;

    $mentor = $_POST['mentor_uid'];
    $file_id = $_POST['file_id'];
    $category = $_POST['category'];

    if($mentor != null && $file_id != null && $category != null){
        $result = $fileObj->getOneFileByMentor($mentor, $file_id, $category);
        echo $result;
        return;
    }

?>
