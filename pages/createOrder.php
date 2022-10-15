
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
        <? print_r($_SESSION["order"])?>
    <p class="error-message"><?php echo $errMsg[0]?></p>
        <form action="createOrder.php" method="post">

<label for="CATEGORY-DROPDOWN">Категория нерудного материала: </label>
<select name="category" id="category-dropdown">
                        <option selected>Категория нерудного материала:</option>
                        <?php foreach ($categorys as $key => $category): ?>
                            <option value="<?=$category['id']; ?>"><?=$category['name'];?></option>
                        <?php endforeach; ?>
</select>


<label for="SUBCATEGORY">Продукт выбранной категории: </label>
<select id="sub-category-dropdown" name="product">
<option selected>Продукт выбранной категории:</option>
</select>

       <label for="amountProduct">Колисество товара в тоннах: </label>
<input type="number" id="amountProduct" name="amountProduct"
       value="0"  min="0" max="1000"
>
<input type="submit" name="buttonAddProduct" value="Добавить товар в заказ">
<?php if (isset($_SESSION['order'])): ?>
<input type="button" onclick="location.href='http://projectkukhtoa/pages/finishOrder.php';" value="Закончить оформление заказа" />
<?php endif; ?>
       
        </form>
        
    </div>

    <?php include(SITE_ROOT."/include/footer.php"); ?>
    <script>
$(document).ready(function() {
$('#category-dropdown').on('change', function() {
var category_id = this.value;
$.ajax({
url: "../controllers/categorys.php",
type: "POST",
data: {
category_id: category_id
},
cache: false,
success: function(result){
   alert(result);
$("#sub-category-dropdown").html(result);

}
});
});
});
</script>
    </body>



</html>
