<?php

//connects to db local returns the connection
function connectToDB() {
    $connection = mysql_connect("localhost", "root", "");
    if (!$connection) {
        die('Could not connect: ' . mysql_error());
        session_destroy();
    }

    $database = mysql_select_db("wang248_final", $connection);
    if (!$database) {
        die('Could not connect to database: in submit sign in' . mysql_error());
        session_destroy();
    }
    return $connection;
}

?>
