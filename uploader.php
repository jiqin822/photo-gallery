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
        if (!isset($_SESSION['UserName'])) {

            echo "<script language='javascript'><!--
location.replace('login.php')
//-->
</script>";
        } else {

            $AlbumID = $_POST['album'];

            $album_path = getcwd() . "/galleries/" . $AlbumID;
            $target_fixed_path = getcwd() . "/galleries/" . $AlbumID . "/images/";
            $target_thumbnail_path = getcwd() . "/galleries/" . $AlbumID . "/thumbnail/";

            for ($i = 1; $i <= 6; $i++) {

                $file_name = "uploadedfile" . $i;

                if ($_FILES[$file_name]['name'] == NULL)
                    continue;

                if (!isImage($_FILES[$file_name]['name'])) {
                    echo "Image type not supported;";
                    continue;
                }

                if (!is_dir($album_path))
                    mkdir($album_path);
                if (!is_dir($target_fixed_path))
                    mkdir($target_fixed_path);
                if (!is_dir($target_thumbnail_path))
                    mkdir($target_thumbnail_path);

                $photo_path = $target_fixed_path . basename($_FILES[$file_name]['name']);
                $thumbnail_path = $target_thumbnail_path . "thumbnail_" . basename($_FILES[$file_name]['name']);

                registerDB($photo_path, $AlbumID);
                uploadPhoto($photo_path, $thumbnail_path, $file_name);
            }
            generateOutXML();
            generateInXML($AlbumID);
        }

        function getNameByID($a_id) {
            $connection = connectToDB();
            $insert__sql = "SELECT AlbumName FROM UserAlbum WHERE AlbumID=$a_id";
            $feedack = mysql_query($insert__sql, $connection);
            $ret = mysql_fetch_array($feedack);
            return $ret['AlbumName'];
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
                $node_photo->setAttribute("share", 0);


                $node_photos->appendChild($node_photo);
            }

            $xmlDoc->appendChild($gallery);
            $xmlDoc->save($xml_file_path);
        }

        function getAllPhotos($album_id) {
            $connection = connectToDB();
            $insert__sql = "SELECT PhotoName FROM UserPhoto WHERE AlbumID=$album_id";
            $feedack = mysql_query($insert__sql, $connection);
            return $feedack;
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

        function registerDB($photo_path, $album_id) {
            $userID = $_SESSION['UserID'];
            $connection = connectToDB();
            $insert_sql = "INSERT INTO UserPhoto (PhotoName, AlbumID, OwnerUserID, Privacy)
				VALUES
				('$photo_path','$album_id','$userID',0)";
            return $feedback = mysql_query($insert_sql, $connection);
        }

        function isImage($name) {
            $pos = strrpos($name, ".");
            if ($pos === false)
                return false;
            $ext = strtolower(trim(substr($name, $pos)));
            $imgExts = array(".gif", ".jpeg", ".png", ".jpg");
            if (in_array($ext, $imgExts))
                return true;
            return false;
        }

        function createImage($p_path) {
            $pos = strrpos($p_path, ".");
            $ext = strtolower(trim(substr($p_path, $pos)));
            if (strcmp($ext, ".jpeg") === 0 || strcmp($ext, ".jpg") === 0)
                $source_image = imagecreatefromjpeg($p_path);
            if (strcmp($ext, ".png") === 0)
                $source_image = imagecreatefrompng($p_path);
            if (strcmp($ext, ".gif") === 0)
                $source_image = imagecreatefromgif($p_path);
            return $source_image;
        }

        function uploadT($p_path, $t_path) {
            /* read the source image */
            $pos = strrpos($p_path, ".");
            if ($pos === false)
                return false;
            $ext = strtolower(trim(substr($p_path, $pos)));
            if (strcmp($ext, ".jpeg") === 0 || strcmp($ext, ".jpg") === 0)
                $source_image = imagecreatefromjpeg($p_path);
            if (strcmp($ext, ".png") === 0)
                $source_image = imagecreatefrompng($p_path);
            if (strcmp($ext, ".gif") === 0)
                $source_image = imagecreatefromgif($p_path);

            $width = imagesx($source_image);
            $height = imagesy($source_image);

            $desired_width = 75;
            /* find the "desired height" of this thumbnail, relative to the desired width  */
            $desired_height = 75; //floor($height*($desired_width/$width));

            /* create a new, "virtual" image */
            $virtual_image = imagecreatetruecolor($desired_width, $desired_height);

            /* copy source image at a resized size */
            imagecopyresized($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

            /* create the physical thumbnail image to its destination */
            imagejpeg($virtual_image, $t_path);

            return true;
        }

        function uploadPhoto($p_path, $t_path, $filename) {
            $success1 = move_uploaded_file($_FILES[$filename]['tmp_name'], $p_path);
            $success2 = uploadT($p_path, $t_path);

            if ($success1 && $success2) {
                echo "The file " . basename($_FILES[$filename]['name']) .
                " has been uploaded <br /> ";
            } else {
                echo "There wa san error uploading the file, please try again!<br /> ";
            }
        }
        ?>

        <a href="user_home.php">Back</br></a> 
        <a href="log_out.php">LOGOUT</a> 

    </body>
</html>