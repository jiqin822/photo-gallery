<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>hello</title>
    </head>
    <body>


        <?php
        require_once 'connect.php';

        if (!$_POST['UserName'])
            echo "<script language='javascript'><!--
		location.replace('login.php')
		//-->
		</script>";

        else {
            $connection = connectToDB();

            date_default_timezone_set('UTC');


            $userName = htmlspecialchars(trim($_POST['UserName']));
            $Password1 = htmlspecialchars(trim($_POST['Password1']));
            $Password2 = htmlspecialchars(trim($_POST['Password2']));
            $nickName = htmlspecialchars(trim($_POST['NickName']));
            $SecurityAnswer = htmlspecialchars(trim($_POST['SecurityAnswer']));

            /* if($Password1!=$Password2)
              {
              echo   " <script   language= 'Javascript '>
              alert( 'Password Not the same both time ');
              history.back();
              </script> ";

              }
              if(strlen($Password1)<=6)
              {
              echo   " <script   language=\ 'Javascript\ '> ";
              echo   "alert( 'Password too short '); ";
              echo   "history.back();   ";
              echo   " </script> ";
              }
              if($NickName=="")
              {
              echo   " <script   language=\ 'Javascript\ '> ";
              echo   "alert( 'NICK NAME NEEDED!!! '); ";
              echo   "history.back();   ";
              echo   " </script> ";
              }
              if(strlen($UserName)<=4)
              {
              echo   " <script   language=\ 'Javascript\ '> ";
              echo   "alert( 'NOT LIKELY TO BE A EMAIL ADDRESS '); ";
              echo   "history.back();   ";
              echo   " </script> ";
              } */

            $Time = date("c");


            $insert_sql = "INSERT INTO UserData(UserName,Password,NickName,SecurityAnswer,LastLogTime)VALUES";
            $insert_sql .= "('$userName','$Password1','$nickName','$SecurityAnswer','$Time')";

            $ret = mysql_query($insert_sql, $connection);
            echo "Successfully signed up, Please Wait";
            session_start();
            $_SESSION['UserName'] = $userName;
            echo $_SESSION['UserName'];

            echo "<script language='javascript'><!--
location.replace('index_session_start.php')
//-->
</script>";
        }
        ?>
    </body>
</html>
