
<?php

include("../path.php");
include("../controllers/orders.php");

session_start();
if (!$_SESSION["id"]) {
    header("Location: ". BASE_URL);
}

?>
<html>
    <head>
        <title>Работа</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <link href="../assets/css/style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
    <?php include("../include/header.php"); ?>

    <div class="content">
        Список заказов
    </div>

    <?php include("../include/footer.php"); ?>
    </body>



</html>
