<?php
    require '/host/home3/windry/html/se_learning_mate/model/user_model/user.php';
    $userObj = new User();

    $check_id = $_POST['check_id'];
    $myIdt = $_POST['senderIdt'];
    $myUidForMatching = $_POST['myUid'];
    $targetUidForMatching = $_POST['targetUid'];

    $chkMobile = 0;
    $value = $_SERVER['HTTP_USER_AGENT'];
    if(strpos($value, 'okhttp') !== false){
		$chkMobile = 1;
	} else { 
		$chkMobile = 0;
	}

    if($myUidForMatching != null && $targetUidForMatching != null){
        $result = $userObj->updatePairUser($myUidForMatching, $targetUidForMatching);
        if($chkMobile == 1){
            echo $result;
        }
        return;
    }

    if($myIdt != null){
        $result = $userObj->getAllUserByIdentity($myIdt);
        echo $result;
        return;
    }

    if($check_id != null){
        $result = $userObj->checkDuplicateUid($check_id);
        echo $result;
        return;
    }
    $signin_uid = $_POST['signin_uid'];
    $signin_pw = $_POST['signin_password'];

    
    $signup_uid = $_POST['signup_uid'];
    $signup_pw = $_POST['signup_password'];
    $userName = $_POST['signup_userName'];
    $identity = $_POST['signup_identity'];
    if($identity == 'Mentor'){
        $identity = 1;
    }
    if($identity == 'Mentee'){
        $identity = 0;
    }
    if($signin_uid == null && $signin_pw == null && $signup_uid == null && $signup_pw == null && $userName == null && $identity == null){
        $code = '404';
        @include($_SERVER["DOCUMENT_ROOT"]."/".$code.".php");
        die();
    }
    if($signin_uid == null && $signin_pw == null){
        $chkResult = $userObj->checkDuplicateUid($signup_uid);
        if($chkResult == 1){
            if($chkMobile == 1){
                echo $chkResult;
            }
            else{
                echo "<script> alert('이미 존재하는 계정입니다!'); </script>";
                echo "<script> history.back(); </script>";
            }
        }
        else{
            $result = $userObj->requestSignUp($signup_uid, $signup_pw, $userName, $identity);
            if($chkMobile == 1){
                echo $result;
            }
            else{
                if($result == 1){
                    echo "<script> alert('회원가입에 성공하였습니다.'); </script>";
                    header("Location: ../view/sign_in.php");
                }
                else{
                    echo "<script> alert('회원가입에 실패하였습니다!'); </script>";
                    echo "<script> history.back(); </script>";
                }
            }
        
        }   
    }
    else{
        $result = $userObj->requestSignIn($signin_uid, $signin_pw);
        if($result == 'Wrong Password!'){
            if($chkMobile == 1){
                echo $result;
            }
            else{
                echo "<script> alert('비밀번호가 옳지 않습니다!'); </script>";
                echo "<script> history.back(); </script>";
            }
        }
        else if($result == 'Invalid User!'){
            if($chkMobile == 1){
                echo $result;
            }
            else{
                echo "<script> alert('존재하는 계정이 없습니다!'); </script>";
                echo "<script> history.back(); </script>";
            }
        }
        else{
            if($chkMobile == 1){
                echo $result;
                return;
            }
            if($chkMobile == 0){
                // header("Location: ../view/login_index.php");
                echo '.';
                echo "<script> alert('로그인 성공'); </script>";
                echo "<script> 
                var f = document.createElement('form');
                f.setAttribute('method', 'post');
                f.setAttribute('action', '../view/login_index.php');
                document.body.appendChild(f);
                
                var i = document.createElement('input');
                i.setAttribute('type', 'hidden');
                i.setAttribute('name', 'user');
                i.setAttribute('value', '$result');
                f.appendChild(i);
                f.submit();
                 </script>";
            }
        }
    }

?>