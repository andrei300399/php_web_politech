<?php

include("path.php");
include("controllers/users.php");

session_start();
if ($_SESSION["id"]) {
    header("Location: ./pages/order.php");
}

?>
<html>
    <head>
        <title>Карьер</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <link href="assets/css/style.css" rel="stylesheet" type="text/css">
    </head>

    <body>
    <?php include("include/header.php"); ?>

                    <?php
                    require_once './pages/authBtn.php';

                    ?>
                    <p><?php echo $errMsg[0]?></p>
                   
                                                    
                                                <form action="index.php" method="POST">

            
                                                <p>Логин: <input type="text" name="login" /></p>
                                                <p>Пароль: <input type="text" name="password" /></p>
                                                <input type="submit" name="buttonLogin" value="Войти">
                                                        </form>


                                                </div> 
                                                <?php include("include/footer.php"); ?>
                                            
    </body>
</html>
