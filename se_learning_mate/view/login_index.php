<?php
    session_cache_limiter('private_no_expire'); // works
    session_start();
    $userData = $_POST['user'];
    // echo $userData;
    // if($userData == null){
        // $userData = $_SESSION['user'];
    // }
    // else{
        $_SESSION['user'] = $userData;
    // }
    //  echo $userData;

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title="LearningMate">
        <link rel="stylesheet" href="css/mainform.css" type="text/css">
        <style>
            .main-body {
                width: 80%;
                margin: auto;
            }

            .button {
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                width: 30%;
                height: 200px;
                font-size: 30px;
                border-radius: 15px;
                margin: 10px;
                border: 5px solid #a9a9a9;
                background-color: #ace0f6;
                font-weight: bold;
            }

            .button:hover {
                background-color: #6fd2fd;
                width: 33%;
                height: 210px;
            }
            
            .button:active {
                background-color: #35c2ff;
            }
        </style>
    </head>
    <body>
        <div class="title">
            <img src="img/learningmate_logo.png" alt="LearningMate logo" onclick="location.href='login_index.php'">
            
        </div>
        <hr>
        <div class="main-body">
            <div class="information"
                style="margin: 40px 200px; border: 2px solid gray; padding: 20px; border-radius: 20px; font-size: 30px;">
                <b>Learning Mate</b> makes it easier to manage assignments & test
            </div>
            <div class="main-button-box">
                <!-- <form method='post' action='quiz.php'>
                    <input type="submit" value="Quiz">
                    <input type='hidden' name='quiz_user' value="<?=htmlspecialchars($userData, ENT_QUOTES)?>">
                </form> -->
                <form method='post' action='homework.php'>
                    <input class="button" type="submit" value="Homework">
                    <input type='hidden' name='homework_user' value="<?=htmlspecialchars($userData, ENT_QUOTES)?>">
                </form>
                <form method='post' action='contents.php'>
                    <input class="button" type="submit" value="Contents">
                    <input type='hidden' name='contents_user' value="">
                </form>
            </div>
        </div>
    </body>
</html>
