
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
       
        <table >
        <tr >
                                <td >
                                №
                                </td>
                                <td >
                                Наименование
                                </td>
                                <td >
                                Количество товара 
                                </td>
                                <td >
                                Цена товара
                                </td>
                                <td >
                                Категория товара
                                </td>
                                <td >
                                Стоимость товара
                                </td>
        </tr>
        <?php foreach ($products as $key => $product): ?>
                            <tr >
                                <td >
                                <?=$key+1; ?>
                                </td>
                                <td >
                                <?=$product['productName'] ;?>
                                </td>
                                <td >
                                <?=$product['amountProduct']; ?>
                                </td>
                                <td >
                                <?=$product['price']; ?>
                                </td>
                                <td >
                                <?=$product['categoryName']; ?>
                                </td>
                                <td >
                                <?=$product['sumProduct']; ?>
                                </td>
        </tr>
        <?php endforeach; ?>
        <tr >
                                <td colspan=5>
                               Итого
                                </td>
                                <td >
                                <?=$selectedOrder['sumorder']; ?>
                                </td>
        </tr>
        </table>



    
    </div>


    <?php include(SITE_ROOT."/include/footer.php"); ?>
    </body>



</html>
