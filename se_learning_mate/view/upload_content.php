<?php
//    $userData = $_POST['user'];
//    $userData = json_decode($userData, true);
session_cache_limiter('private_no_expire'); // works
   
session_start();
   $userData = $_SESSION['user'];
   $userData = json_decode($userData);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title="LearningMate">
        <link rel="stylesheet" href="css/mainform.css" type="text/css">
        <style>
            .page-title {
                margin-bottom: 10px;
                font-size: 25px;
                font-weight: bold;
            }

            table {
                margin: auto;
            }

            th, td {
                font-size: 20px;
                padding-right: 10px;
                padding-left: 10px;
                border-top: 1px solid;
            }
            
            .button {
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                width: 40%;
                height: 40px;
                font-size: 15px;
                border-radius: 15px;
                margin: 10px;
                border: 5px solid #a9a9a9;
                background-color: #ace0f6;
                font-weight: bold;
            }

            .button:hover {
                background-color: #6fd2fd;
            }
            
            .button:active {
                background-color: #35c2ff;
            }

            .file {
                font-size: 17px;
            }

            .name{
                -ms-user-select: none;
                -moz-user-select: -moz-none;
                -khtml-user-select: none;
                -webkit-user-select: none;
                user-select: none;
                border-top: none;
                border-left: none;
                border-right: none;
                width: 100%;
                overflow: visible;
                font-size: 20px;
            }

            .name:focus{
                outline: none;
            }
        </style>
    </head>
    <script>
        function back(){
            history.back();
        }
    </script>
    <body>
        <div class="title">
            <img src="img/learningmate_logo.png" alt="LearningMate logo" onclick="location.href='login_index.php'">
        </div>
        <div class="left-side-bar" style="margin-top: 9px;">
            <div id="wrapper">
                <div id="line-wrapper">
                    <div id="line-top" class="line init top-reverse"></div>
                    <div id="line-mid" class="line init mid-reverse"></div>
                    <div id="line-bot" class="line init bot-reverse"></div>
                </div>
            </div>
            <ul>
                <li style="height: 40px; padding-top: 12px;">Menu</li>
                <li><a href="homework.php">Homework</a></li>
                <li><a href="contents.php">Contents</a></li>
            </ul>
        </div>
        <hr>
        <div class="page">
            <div class="page-title" style="text-align: center;">
                Upload Contents
            </div>
            <div class="create-form">
                <table>
                    <form action="../controller/material_controller.php" method="post" enctype="multipart/form-data">
                        <tr>
                            <th height="50px">Content Name</th>
                            <td height="50px">
                                <div class="contents-name">
                                    <input class="name" type="text" name="w_title" placeholder="content name" maxlength="100" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th height="50px">File</th>
                            <td height="50px">
                                <input type="hidden" id="create" name="create" value="create">
                                <input type="hidden" id='user' name='w_user' value="<?=htmlspecialchars(json_encode($userData), ENT_QUOTES)?>">
                                <div class="file">
                                    <input class="file" type="file" name="fileToUpload">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" height="50px">
                                <div class="finish">
                                    <input class="button" type="submit" value="save">
                                    <input class="button" type="reset" value="cancel" onclick=back()>
                                </div>
                            </td>
                        </tr>
                    </form>
                </table>
            </div>
        </div>
    </body>
</html>
