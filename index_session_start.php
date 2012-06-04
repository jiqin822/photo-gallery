<?php
require_once 'connect.php';

        session_start();
?>
<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Submitting Request</title>
        <link href="css/demo_rules.css" rel="stylesheet" type="text/css" />

    </head>
    <body>

        <?php
        if (!isset($_SESSION['UserName']))
            echo "        <script language='javascript'><!--
	location.replace('login.php')
	//-->
	</script>";


        $userName = $_SESSION['UserName'];

        $nickName = getNickName($userName);

        $_SESSION['NickName'] = $nickName;

        $_SESSION['UserID'] = getUserID($userName);

        echo "Welcome " . $nickName;

        function getNickName($username) {
            $connection = connectToDB();
            $insert_sql = "SELECT NickName FROM UserData WHERE UserName = '$username'";
            $feedback = mysql_query($insert_sql, $connection);
            $resultArray = mysql_fetch_array($feedback);
            return $resultArray['NickName'];
        }

        function getUserID($username) {
            $connection = connectToDB();
            $insert_sql = "SELECT UserID FROM UserData WHERE UserName = '$username'";
            $feedback = mysql_query($insert_sql, $connection);
            $resultArray = mysql_fetch_array($feedback);
            return $resultArray['UserID'];
        }
        ?>

        <br></br>
        <a href="user_home.php">My Albums</br></a>
        <a href="log_out.php">LOGOUT</a> 


    </body>
</html>