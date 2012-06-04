<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Sign in</title>
        <link href="css/demo_rules.css" rel="stylesheet" type="text/css" />

    </head>
    <body>



        <form id="form1" name="form1" method="post" action="submit_sign_in_form.php" onSubmit="return InputCheck(this)">
            <!-- <form id="form1" name="form1" method="post" action="user_home.php" onSubmit="return InputCheck(this)">-->

            <h1>&nbsp;Sign In</h1>
            <p>
                <label for="title">&nbsp;&nbsp;&nbsp;&nbsp;Email Address:</label>
                <input id="UserName" name="UserName" type="text" /><span>(Not Exceeding 15 characters)</span>
            </p>

            <p>
                <label for="title">&nbsp;&nbsp;&nbsp;&nbsp;Password:</label>
                <input id="Password" name="Password" type="password" /><span>(Not Exceeding 15 characters)</span>
            </p>
            <input type="submit" name="submit" value="  Sign In   " />
            <a name="sign_up" href="sign_up.php">Don't have an account?</a>
        </form>

        <?php
        //
        require_once 'connect.php';

        $connection = connectToDB();
        ?>
    </body>
</html>
