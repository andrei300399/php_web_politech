
<?php

include("../path.php");
include("../controllers/orders.php");
unset($_SESSION["order"]);
if (!$_SESSION["id"]) {
    header("Location: ". BASE_URL);
}

?>
<html>
    <head>
        <title>Карьер</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <link href="../assets/css/style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
    <?php include(SITE_ROOT."/include/header.php"); ?>

    <div class="content">
        <h2>Код заказа <?=$codeOrder; ?>. Список товаров.</h2>
       
        <div class="table">
        <div class="table-row">
                                <div class="table-cell">
                                №
                                </div>
                                <div class="table-cell">
                                Наименование
                                </div>
                                <div class="table-cell">
                                Количество товара 
                                </div>
                                <div class="table-cell">
                                Цена товара
                                </div>
                                <div class="table-cell">
                                Категория товара
                                </div>
        </div>
        <?php foreach ($shortsuminfo as $key => $item): ?>
                            <div class="table-row">
                                <div class="table-cell">
                                <?=$key+1; ?>
                                </div>
                                <div class="table-cell">
                                <a href="showOrder.php?order_id=<?=$item['idOrder'];?>">
                                <?=$item['code'] ;?>
                                </a>
                                </div>
                                <div class="table-cell">
                                <?=$item['sumorder']; ?>
                                </div>
                                <div class="table-cell">
                                <?=$item['orderDate']; ?>
                                </div>
                                <div class="table-cell">
                                <?=$item['deliviryDate']; ?>
                                </div>
        </div>
        <?php endforeach; ?>
    </div>
    </div>


    <?php include(SITE_ROOT."/include/footer.php"); ?>
    </body>



</html>
