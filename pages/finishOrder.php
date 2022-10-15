
<?php

include("../path.php");
include("../controllers/orders.php");


if (!$_SESSION["id"]) {
    header("Location: ". BASE_URL);
}

?>
<html>
    <head>
        <title>Карьер</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <link href="../assets/css/style.css" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>
    <body>
    <?php include(SITE_ROOT."/include/header.php"); ?>

    <div class="content">
        <form action="finishOrder.php" method="post">

<label for="deliviryDate">Дата доставки: </label>
<input type="date" id="deliviryDate" name="trip-start"
       value="2018-07-22"
       min="2018-01-01" max="2222-12-31">
<label for="emailUser">Почта для чека: </label>
<input type="email" id="emailUser" name="emailUser">
<label for="carUser">Машина: </label>
<input type="text" id="carUser" name="carUser">
<input type="submit" name="buttonAddProduct" value="Оформить заказ">

       
        </form>
        
    </div>

    <?php include(SITE_ROOT."/include/footer.php"); ?>

    </body>



</html>
