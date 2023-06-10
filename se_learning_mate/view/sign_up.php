<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title="LearningMate">
        <link rel="stylesheet" href="css/mainform.css" type="text/css">
        <style>
            table {
                margin: auto;
            }

            th, td {
                font-size: 20px;
                padding-right: 10px;
                padding-left: 10px;
            }

            .main-body {
                width: 80%;
                margin: auto;
            }

            .sign-up-button {
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

            .sign-up-button:hover {
                background-color: #6fd2fd;
            }
            
            .sign-up-button:active {
                background-color: #35c2ff;
            }

            .name, .id, .password {
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
            }

            .name:focus, .id:focus, .password:focus {
                outline: none;
            }
        </style>
    </head>
    <body>
        <div class="title">
            <img src="img/learningmate_logo.png" alt="LearningMate logo" onclick="location.href='index.php'">
        </div>
        <hr>
        <div class="sign-up-form" style="text-align: center;">
            <h2>회원가입</h2>
            <table>
                <form method="post" action="../controller/account_controller.php">
                    <tr>
                        <th height="50px">Name</th>
                        <td height="50px">
                            <div class="name">
                                <input class="name" name="signup_userName" type="text" placeholder="Enter name" style="width: 100%; height: 45px; font-size: 18px;">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th height="50px">ID</th>
                        <td height="50px">
                            <div class="id">
                                <input class="id" name="signup_uid" type="text" placeholder="Enter Id" style="width: 100%; height: 45px; font-size: 18px;">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th height="50px">Password</th>
                        <td height="50px">
                            <div class="password">
                                <input class="password" name="signup_password" type="password" placeholder="Enter password" style="width: 100%; height: 45px; font-size: 18px;">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th height="50px">Confirm Password</th>
                        <td height="50px">
                            <div class="password">
                                <input class="password" type="password" placeholder="Enter password again" style="width: 100%; height: 45px; font-size: 18px;">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th height="50px">Role</th>
                        <td height="50px">
                            <div class="radio">
                                <input type="radio" name="signup_identity" value="Mentor" required>Mentor
                                <input type="radio" name="signup_identity" value="Mentee" required>Mentee
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" height="50px">
                            <input class="sign-up-button" type="submit" value="Sign Up">
                        </td>
                    </tr>
                </form>
            </table>
        </div>
    </body>
</html>
