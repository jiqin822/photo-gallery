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



        <form id="form1" name="form1" method="post" action="submit_sign_up_form.php" onSubmit="return InputCheck(this)">
            <h3>Sign up</h3>
            <p>
                <label for="title">&nbsp;&nbsp;&nbsp;&nbsp;Email Address:</label>
                <input id="UserName" name="UserName" type="text" /><span>(Not Exceeding 15 characters)</span>
            </p>

            <p>
                <label for="title">&nbsp;&nbsp;&nbsp;&nbsp;Password:</label>
                <input id="Password1" name="Password1" type="password" /><span>(Not Exceeding 15 characters)</span>
            </p>

            <p>
                <label for="title">&nbsp;&nbsp;&nbsp;&nbsp;Password Confirmation:</label>
                <input id="Password2" name="Password2" type="password" /><span>(Not Exceeding 15 characters)</span>
            </p>

            <p>
                <label for="title">&nbsp;&nbsp;&nbsp;&nbsp;Your Nick Name to display to your friends:</label>
                <input id="NickName" name="NickName" type="text" /><span>(Not Exceeding 15 characters)</span>
            </p>


            <p>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;Security Question: What is your Moms name</p>
            <label for="title">&nbsp;&nbsp;&nbsp;&nbsp;Answer:</label>
            <input id="SecurityAnswer" name="SecurityAnswer" type="text" /><span>(Not Exceeding 15 characters)</span>
        </p>

        <input type="submit" name="submit" value="  Sign Up   " />
    </form>



    <?php
    require_once 'connect.php';

            $connection = connectToDB();
    mysql_query($sql, $connection);
    ?>
</body>
</html>