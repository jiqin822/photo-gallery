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

        echo $nickName . "'s Album</br>";

        echo "<br>";

        printAlbumLinks($userName);

        function printAlbumLinks($username) {
            $connection = connectToDB();

            $my_query = "SELECT AlbumName,AlbumID FROM UserData INNER JOIN UserAlbum ON UserData.UserID=UserAlbum.OwnerUserID WHERE UserData.UserName = '$username'";
            $ret = mysql_query($my_query, $connection);
            while ($row = mysql_fetch_array($ret)) {
                $album_id = $row['AlbumID'];
                $href_link = "inside_my_album.php?id=$album_id";
                $album_name = $row['AlbumName'];
                echo "<a href='$href_link'>$album_name</br></a>";
            }
        }

        function getNickName($username) {
            $connection = connectToDB();
            $insert_sql = "SELECT NickName FROM UserData WHERE UserName = '$username'";
            $feedback = mysql_query($insert_sql, $connection);
            $resultArray = mysql_fetch_array($feedback);
            return $resultArray['NickName'];
        }
        ?>


        <br></br>
        <a href="create_album.php">CREATE NEW ALBUM</br></a> 
        <a href="log_out.php">LOGOUT</a> 


    </body>
</html>