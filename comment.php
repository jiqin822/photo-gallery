
<?php
require_once 'connect.php';
require_once 'user_home_php.php';

//save submited comment
$connection = connectToDB();
$comment = $_POST['comment'];
$submit = $_POST['submit'];
if ($submit) {
    if ($comment) {
        $imgName = $_COOKIE["activeImage"];
        $userName = $_SESSION['UserName'];
        $user = getUserID($userName);
        $insert = mysql_query("INSERT INTO comment (UserID,ImageName,Comment) VALUES ('$user','$imgName','$comment') ", $connection);
    } else {
        echo "please fill out comment fields";
    }
    echo $imgName . "<-image Path";
    echo "<script language='javascript'>
    document.getElementById('comment').innerHTML=
   \"<p>+<?echo ''.getComments();?>+</p>\";
</script>";
    //redirect to user home with javascript
    echo "<script language='javascript'>
location.replace('user_home.php')
</script>";
}

// retrieves and echos the comment section
function getComments() {
    $connection = connectToDB();
    $getquery = mysql_query("SELECT * FROM comment", $connection);
    $i = 0;

    echo '<table>';
    echo "Comments:<br/>";
    echo "<hr size='3'/>";
    while ($row = mysql_fetch_array($getquery)) {
        $i = 0;
        $userID = $row['UserID'];
        $insertSql = "SELECT NickName FROM UserData WHERE UserID = " . $userID;
        $feedback = mysql_query($insertSql, $connection);
        $resultArray = mysql_fetch_array($feedback);
        $nikeName = $resultArray['NickName'];
        echo "User " . $nikeName . " Says:<br/>";
        echo "<p>" . $row['Comment'] . "</p>";
        echo "<hr size='1'/>";
    }
    echo "</table>";
}
?>

</body>
</html>

