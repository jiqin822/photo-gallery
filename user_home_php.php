<?

require_once 'connect.php';
session_start();
$loggedIn = isset($_SESSION['UserName']);
//check if user is logged in
if (!$loggedIn) {
    echo $_SESSION['UserName'];
    echo "<ul id=\"MenuBar1\" class=\"MenuBarHorizontal\">
            <li>
                <div id=\"greeting\">
                    Guest view
                </div>
            </li>
            <li>
                    <a  href=\"login.php\">Login to upload images</a>
            </li>
          </ul>";
}
$userName = $_SESSION['UserName'];
$nickName = getNickName($userName);
$userID = getUserID($userName);
$_SESSION['NickName'] = $nickName;
$_SESSION['UserID'] = $userID;

/**
  //else {
  //    // get his/her info if is
  //    $userName = $_SESSION['UserName'];
  //    $nickName = getNickName($userName);
  //    $_SESSION['NickName'] = $nickName;
  //    $_SESSION['UserID'] = getUserID($userName);
  //    echo "<ul id=\"MenuBar1\" class=\"MenuBarHorizontal\">
  //            <li>
  //                <div id=\"greeting\">";
  //    echo $nickName . '\'s';
  //    echo "</div>
  //            </li>
  //            <li><a  href=\"upload_image.php\">Upload Images</a>
  //            </li>
  //            <li><a href=\"create_album.php\">Create new Album</a></li>
  //            <li><a class=\"MenuBarItemSubmenu\" href=\"#\">Edit</a>
  //                <ul>
  //                    <li><a class=\"MenuBarItemSubmenu\" href=\"#\">
  //                    <p><input type=\"image\" src=\"http://advanced.aviary.com/images/feather/edit-photo.png\"
  //                              value = \"Edit photo\"
  //                              onclick = \"return launchEditor('mainImage', 'http://images.aviary.com/imagesv5/feather_default.jpg');\" />
  //                    </p>
  //    </a>
  //    </li>
  //    </ul>
  //    </li>
  //    <li><a href = \"log_out.php\">Logout</a></li>
  //        </ul>";
  //}
 * */
function getNickName($username) {
    $connection = connectToDB();
    $insertSql = "SELECT NickName FROM UserData WHERE UserName = '$username'";
    $feedback = mysql_query($insertSql, $connection);
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
