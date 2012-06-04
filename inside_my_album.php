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
        <title>Viewing Album</title>
    </head>
    <body>

        <?php
        if (!isset($_SESSION['UserName']))
            echo "        <script language='javascript'><!--
	location.replace('login.php')
	//-->
	</script>";

        else {
            $AlbumID = $_GET['id'];

            $AlbumName = getAlbumName($AlbumID);
            echo "<h4>$AlbumName</br></h4>";

            //showPictures($AlbumID);

            echo "<a href='upload_image.php?id=$AlbumID'>upload pictures</br></a>";
        }

        function getAlbumName($album_id) {
            $connection = connectToDB();
            $insert_sql = "SELECT AlbumName FROM UserAlbum WHERE AlbumID = '$album_id'";
            $feedback = mysql_query($insert_sql, $connection);
            $resultArray = mysql_fetch_array($feedback);
            return $resultArray['AlbumName'];
        }
        ?>


        <br></br>
        <a href="index_session_start">Back TO INDEX</br></a>
        <a href="log_out.php">LOGOUT</a> 


    </body>
</html>