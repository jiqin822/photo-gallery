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
        <script type="text/javascript" src="include/gallery.js"></script>
        <title>Submitting Request</title>
    </head>
    <body>

        <?php
        if (!$_POST['UserName']) {
            echo "<script language='javascript'><!--
		location.replace('login.php')
		//-->
		</script>";
            session_destroy();
        } else {

            $connection = connectToDB();
            //  if (!$database) {
            //     die('Could not connect to database: in submit sign in' . mysql_error());
            //    session_destroy();
            // }
            date_default_timezone_set('UTC');


            $userName = htmlspecialchars(trim($_POST['UserName']));
            $Password = htmlspecialchars(trim($_POST['Password']));

            $pre_query = "SELECT UserID
			FROM UserData
			WHERE UserName = '$userName' AND Password='$Password'
			";
            $result = mysql_query($pre_query, $connection);

            if (!mysql_num_rows($result)) {
                echo "UserName or Password Error For User:  ";
                echo $_POST['UserName'];
                session_destroy();
            } else {
                $Time = date("c");

                $insert_sql = "UPDATE UserData SET LastLogTime='$Time' WHERE UserName = '$userName' AND Password = '$Password'";

                mysql_query($insert_sql, $connection);
                echo "Successfully signed in, Please Wait";
                $_SESSION['UserName'] = $userName;
                echo $_SESSION['UserName'];
                echo "<script language='javascript'>DisplayComments();</script>";
            }
        }
        ?>



    </body>
</html>