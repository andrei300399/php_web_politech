
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
        <h2>Код заказа <?=$products[0]["code"]; ?>. Список товаров.</h2>
       
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
                                <div class="table-cell">
                                Стоимость товара
                                </div>
        </div>
        <?php foreach ($products as $key => $product): ?>
                            <div class="table-row">
                                <div class="table-cell">
                                <?=$key+1; ?>
                                </div>
                                <div class="table-cell">
                                <?=$product['productName'] ;?>
                                </div>
                                <div class="table-cell">
                                <?=$product['amountProduct']; ?>
                                </div>
                                <div class="table-cell">
                                <?=$product['price']; ?>
                                </div>
                                <div class="table-cell">
                                <?=$product['categoryName']; ?>
                                </div>
                                <div class="table-cell">
                                <?=$product['sumProduct']; ?>
                                </div>
        </div>
        <?php endforeach; ?>
    </div>
    </div>


    <?php include(SITE_ROOT."/include/footer.php"); ?>
    </body>



</html>
