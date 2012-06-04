<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>hello</title>
                <link href="demo_rules.css" rel="stylesheet" type="text/css" />

    </head>
    <body>
        <?php
        require_once 'connect.php';

        
        session_start();
        if(isset($_SESSION['UserName']))
    		unset($_SESSION['UserName']); 
        if(isset($_SESSION['NickName']))
    		unset($_SESSION['NickName']); 
        if(isset($_SESSION['UserID']))
    		unset($_SESSION['UserID']); 

	session_destroy();
        
        ?>
        
        <script language='javascript'><!--
	location.replace('login.php')
	//-->
	</script>

    </body>
</html>