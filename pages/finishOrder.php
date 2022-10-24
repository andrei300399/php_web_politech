
<?php

include("../path.php");
include("../controllers/orders.php");

if (!$_SESSION["id"] or !($_SESSION['order'])) {
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
    <p class="error-message"><?php echo $errMsg[0]?></p>
        <form action="finishOrder.php" method="post">
<p>
<label for="deliviryDate">Дата доставки: </label>
<input type="date" id="deliviryDate" name="deliviryDate"
       value="2022-11-01"
       min="<?=date('Y-m-d');?>" max="2222-12-31">
       </p>

<p>
<input type="checkbox" name="mailCheck" value="mailCheck" />Отправить на почту

<span class="email">
<label for="emailUser">Почта для чека: </label>
<input type="email" id="emailUser" name="emailUser">
</span>
</p>
<p>
<label for="carUser">Категория нерудного материала: </label>
<select name="carUser" id="carUser">
                        <option selected>Марка машины:</option>
                        <?php foreach ($carMarks as $mark): ?>
                            <option value="<?=$mark['name']; ?>"><?=$mark['name'];?></option>
                        <?php endforeach; ?>
</select>
</p>
<p>
<input type="submit" name="buttonFinishOrder" value="Оформить заказ">
</p>

       
        </form>
        
    </div>

    <?php include(SITE_ROOT."/include/footer.php"); ?>

    </body>



</html>
