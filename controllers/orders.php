<?php

include SITE_ROOT . "/database/db.php";
if (!$_SESSION){
    header('location: ' . BASE_URL);
}

$errMsg = [];


$categorys = selectAll('category');

function searchProduct($arr, $product){
    for($i=0;$i<=count($arr);$i++){
        if ($arr[$i]["product"]==$product) {
            return true;
        }
    }
    return false;
}


// Код для формы создания заказа
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buttonAddProduct'])){
    if ($_POST["category"] == "Категория нерудного материала:" || $_POST["product"] == "Продукт выбранной категории:") {
        array_push($errMsg, "Вы не выбрали категорию или подкатегорию!");
    } else {

    print_r($_POST);
    $oneProduct = [
        "category"=>$_POST["category"], 
        "product"=>$_POST["product"],
        "amountProduct"=>intval($_POST["amountProduct"]),
    ];

    print_r(gettype($oneProduct["category"]));
    print_r(gettype($oneProduct["product"]));
    print_r(gettype($oneProduct["amountProduct"]));

    if (!isset($_SESSION["order"])) {
        $_SESSION["order"] = [
            $_POST["product"] => $oneProduct
        ];
    } else {
        if (array_key_exists($oneProduct["product"], $_SESSION["order"])) {
            $_SESSION["order"][$_POST["product"]]["amountProduct"] += $oneProduct["amountProduct"];
        } else {
            $_SESSION["order"] = [
                $_POST["product"] => $oneProduct
            ];
        }
    }

    print_r(selectOne('product', ['id' => $oneProduct["product"]])["amountStorage"]);
    if($_SESSION["order"][$_POST["product"]]["amountProduct"]  > selectOne('product', ['id' => $oneProduct["product"]])["amountStorage"] ) {
        $_SESSION["order"][$_POST["product"]]["amountProduct"] -= $oneProduct["amountProduct"];
        array_push($errMsg, "На складе осталось только ".(selectOne('product', ['id' => $oneProduct["product"]])["amountStorage"] - $_SESSION["order"][$_POST["product"]]["amountProduct"])." товара!");
        
    }    
}
}


// Код для оформления заказа
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buttonFinishOrder'])){
    
}
