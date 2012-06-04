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
        <title>Uploading Images</title>
        <link href="css/demo_rules.css" rel="stylesheet" type="text/css" />
    </head>
    <body>

        <?php
        if (!isset($_SESSION['UserName'])) {

            echo "<script language='javascript'><!--
location.replace('login.php')
//-->
</script>";
        } else {

            $userName = $_SESSION['UserName'];

            $nickName = getNickName($userName);

            echo "Welcome " . $nickName . "</br>";
            ;
        }

        function getNickName($username) {
            $connection = connectToDB();
            $insert_sql = "SELECT NickName FROM UserData WHERE UserName = '$username'";
            $feedback = mysql_query($insert_sql, $connection);
            $resultArray = mysql_fetch_array($feedback);
            return $resultArray['NickName'];
        }
        ?>

        <form enctype='multipart/form-data' action='uploader.php' method='POST'>

        <?php
        echo "Choose from a valid album：<select name='album'> ";
        $ret = queryAlbumName($_SESSION['UserID']);

        while ($resultArray = mysql_fetch_array($ret)) {
            $uid = $resultArray['AlbumID'];
            $aname = $resultArray['AlbumName'];
            echo "<option value=$uid>$aname</option>";
        }

        echo"</select></br>";

        function queryAlbumName($user_id) {
            $connection = connectToDB();
            $insert_sql = "SELECT AlbumID, AlbumName FROM UserAlbum WHERE OwnerUserID = '$user_id'";
            $feedback = mysql_query($insert_sql, $connection);
            return $feedback;
        }
        ?>

            <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
            Choose a file to upload: <input name="uploadedfile1" type="file" /><br />

            <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
            Choose a file to upload: <input name="uploadedfile2" type="file" /><br />

            <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
            Choose a file to upload: <input name="uploadedfile3" type="file" /><br />

            <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
            Choose a file to upload: <input name="uploadedfile4" type="file" /><br />

            <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
            Choose a file to upload: <input name="uploadedfile5" type="file" /><br />

            <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
            Choose a file to upload: <input name="uploadedfile6" type="file" /><br />

            <input type="submit" value="Upload File" />
        </form>


        <a href="user_home.php">Back to Index</br></a> 
        <a href="log_out.php">LOGOUT</a> 

    </body>
</html>


