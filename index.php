<?php

include("path.php");
include("controllers/users.php");

if ($_SESSION["id"]) {
    header("Location:".BASE_URL."pages/order.php");
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
    <div class="content">
                    <p class="error-message"><?php echo $errMsg[0]?></p>
                   
                                                    
                                                <form action="index.php" method="POST">

            
                                                <p>Логин: <input type="text" name="login" /></p>
                                                <p>Пароль: <input type="text" name="password" /></p>
                                                <input type="submit" name="buttonLogin" value="Войти">
                                                        </form>


                                                </div> 
                                                <?php include("include/footer.php"); ?>
                                            
    </body>
</html>
