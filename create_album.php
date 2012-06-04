<?php
require_once 'connect.php';

session_start();
if (isset($_SESSION['UserName']))
    echo "Creating a New Album for " . $_SESSION['NickName'];
else
    echo "<script language='javascript'><!--
location.replace('login.php')
//-->
</script>";
?>

<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Creating Album</title>
        <link href="css/demo_rules.css" rel="stylesheet" type="text/css" />

    </head>
    <body>



        <form id="form1" name="form1" method="get" action="create_album.php" onSubmit="return InputCheck(this)">

            <h3></h3>

            <p>
                <label for="title">&nbsp;&nbsp;&nbsp;&nbsp;Album Name:</label>
                <input id="AlbumName" name="AlbumName" type="text" /><span>(Not Exceeding 15 characters)</span>
            </p>


            <input type="submit" name="submit" value="  Create   " />
        </form>

        <a href="user_home.php">Home Page</br></a>



        <?php
        if (isset($_GET['AlbumName'])) {

            $connection = connectToDB();
            if (!album_exist($_GET['AlbumName'], $connection)) {

                $album_name = $_GET['AlbumName'];
                $user_id = $_SESSION['UserID'];

                $sql = "INSERT INTO UserAlbum (AlbumName, OwnerUserID , Privacy)
		VALUES
		('$album_name','$user_id',0)";

                mysql_query($sql, $connection);
                echo "Creating Album Successful";

                $sql = "SELECT AlbumID FROM UserAlbum WHERE AlbumName='$album_name'";

                $ret = mysql_query($sql, $connection);

                $ret_v = mysql_fetch_array($ret);

                mkdir(getcwd() . "/galleries/" . $ret_v['AlbumID']);
                mkdir(getcwd() . "/galleries/" . $ret_v['AlbumID'] . "/thumbnail");
                mkdir(getcwd() . "/galleries/" . $ret_v['AlbumID'] . "/images");


                generateOutXML($user_id);
                generateInXML($ret_v['AlbumID']);


                unset($_GET['AlbumName']);
            } else {
                echo "Album Name Exists, Please change a name~";
            }
        }

        function album_exist($albumName, $connect) {
            $query = "SELECT AlbumID FROM UserAlbum WHERE AlbumName ='$albumName'";
            $q_r = mysql_query($query, $connect);
            if (mysql_num_rows($q_r) > 0)
                return true;
            else
                return false;
        }

        function getAllPhotos($album_id) {
            $connection = connectToDB();
            $insert__sql = "SELECT PhotoName FROM UserPhoto WHERE AlbumID=$album_id";
            $feedack = mysql_query($insert__sql, $connection);
            return $feedack;
        }

        function generateInXML($album_id) {
            $xml_file_path = getcwd() . "/galleries/" . $album_id . "/" . $album_id . ".xml";
            if (is_file($xml_file_path))
                unlink($xml_file_path);

            $xmlDoc = new DOMDocument();
            $xmlDoc->formatOutput = true;
            $gallery = $xmlDoc->createElement("gallery");
            $t1 = "base = '' background = '#FFFFFF' banner = '#F0F0F0' text = '#000000' link = '#0000FF' alink = '#FF0000' vlink = '#800080' date = '4/18/2006'>";
            $gallery->appendChild($xmlDoc->createTextNode($t1));

            $node_sitename = $xmlDoc->createElement("sitename");
            $node_sitename->appendChild($xmlDoc->createTextNode(getNameByID($album_id)));
            $node_photographer = $xmlDoc->createElement("photographer");
            $node_photographer->appendChild($xmlDoc->createTextNode("me"));
            $node_security = $xmlDoc->createElement("security");
            $node_security->appendChild($xmlDoc->createTextNode("<![CDATA[ ]]>"));
            $node_banner = $xmlDoc->createElement("banner");
            $node_banner->setAttribute("font", "Arial");
            $node_banner->setAttribute("fontsize", "3");
            $node_banner->setAttribute("color", "#F0F0F0");
            $node_thumbnail = $xmlDoc->createElement("thumbnail");
            $node_thumbnail->setAttribute("base", "thumbnail/");
            $node_thumbnail->setAttribute("font", "Arial");
            $node_thumbnail->setAttribute("fontsize", "4");
            $node_thumbnail->setAttribute("color", "#F0F0F0");
            $node_thumbnail->setAttribute("border", "0");
            $node_thumbnail->setAttribute("rows", "3");
            $node_thumbnail->setAttribute("col", "5");
            $node_large = $xmlDoc->createElement("large");
            $node_large->setAttribute("base", "images/");
            $node_large->setAttribute("font", "Arial");
            $node_large->setAttribute("fontsize", "4");
            $node_large->setAttribute("color", "#F0F0F0");
            $node_large->setAttribute("border", "0");

            $node_photos = $xmlDoc->createElement("images");
            $node_photos->setAttribute("id", "images");

            $gallery->appendChild($node_sitename);
            $gallery->appendChild($node_photographer);
            $gallery->appendChild($node_security);
            $gallery->appendChild($node_banner);
            $gallery->appendChild($node_thumbnail);
            $gallery->appendChild($node_large);
            $gallery->appendChild($node_photos);


            $ret = getAllPhotos($album_id);

            while ($photo_array = mysql_fetch_array($ret)) {
                $ori_path = $photo_array['PhotoName'];
                $pos = strrpos($ori_path, ".");
                $ext = strtolower(trim(substr($ori_path, $pos)));

                $new_path = basename($ori_path);
                $new_thumb_path = "thumbnail_" . $new_path;

                $node_photo = $xmlDoc->createElement("photo");
                $node_photo->setAttribute("path", $new_path);
                $node_photo->setAttribute("width", imagesx(createImage($ori_path)));
                $node_photo->setAttribute("height", imagesy(createImage($ori_path)));

                $node_photo->setAttribute("thumbpath", $new_thumb_path);
                $node_photo->setAttribute("thumbwidth", 75);
                $node_photo->setAttribute("thumbheight", 75);

                $node_photo->setAttribute("rating", "");
                $node_photo->setAttribute("categories", "");
                $node_photo->setAttribute("rating", "");

                $node_photos->appendChild($node_photo);
            }

            $xmlDoc->appendChild($gallery);
            $xmlDoc->save($xml_file_path);
        }

        function generateOutXML() {
            $xml_file_path = getcwd() . "/galleries/" . $_SESSION['UserID'] . ".xml";
            if (is_file($xml_file_path))
                unlink($xml_file_path);

            $xmlDoc = new DOMDocument();
            $xmlDoc->formatOutput = true;
            $galleries = $xmlDoc->createElement("galleries");

            $myAlbums = getAlbums($_SESSION['UserID']);

            while ($thisAlbum = mysql_fetch_array($myAlbums)) {
                $node_album = $xmlDoc->createElement("gallery");
                $node_sitename = $xmlDoc->createElement("sitename");
                $node_sitename->appendChild($xmlDoc->createTextNode($thisAlbum['AlbumName']));
                $node_photographer = $xmlDoc->createElement("photographer");
                $node_photographer->appendChild($xmlDoc->createTextNode("me"));
                $node_security = $xmlDoc->createElement("security");
                $node_security->appendChild($xmlDoc->createTextNode("<![CDATA[ ]]>"));
                $node_album->appendChild($node_sitename);
                $node_album->appendChild($node_photographer);
                $node_album->appendChild($node_security);
                $node_album->setAttribute("base", $thisAlbum['AlbumID'] . "/");
                $node_album->setAttribute("file", $thisAlbum['AlbumID'] . ".xml");

                $galleries->appendChild($node_album);
            }

            $xmlDoc->appendChild($galleries);
            $xmlDoc->save($xml_file_path);
            return $xmlDoc;
        }

        function getAlbums($user_id) {
            $connection = connectToDB();
            $insert__sql = "SELECT AlbumID,AlbumName FROM UserAlbum WHERE OwnerUserID=$user_id";
            $feedack = mysql_query($insert__sql, $connection);
            return $feedack;
        }

        function getNameByID($a_id) {
            $connection = connectToDB();
            $insert__sql = "SELECT AlbumName FROM UserAlbum WHERE AlbumID=$a_id";
            $feedack = mysql_query($insert__sql, $connection);
            $ret = mysql_fetch_array($feedack);
            return $ret['AlbumName'];
        }
        ?>
    </body>
</html>