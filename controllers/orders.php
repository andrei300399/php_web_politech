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
            $_SESSION["order"][$_POST["product"]] = $oneProduct;

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


    // $productId = trim($_SESSION["order"]);
    $userId = $_SESSION["id"];
    $orderDate = date('Y-m-d');
    $orderCode = $userId."u".time();

    $inserted = insert('order', ['idUser' => $userId ,'orderDate' => $orderDate,'code' => $orderCode ]);
    echo $inserted;

    foreach ($_SESSION["order"] as $product) {
        insert('productorder', ['idOrder' => $inserted ,'idProduct' => $product['product'],'amountProduct' => $product['amountProduct'] ]);
    }

    //$orderDate = trim($_SESSION["order"]);
    // date_default_timezone_set('Europe/Moscow');
    //print_r();
    // $pass = trim($_POST['password']);
    // $login = trim($_POST['login']);
    // $pass = trim($_POST['password']);

    // if($login === '' || $pass === '') {
    //     array_push($errMsg, "Не все поля заполнены!");
    // }else{
    //     $existence = selectOne('user', ['login' => $login]);
    //     if($existence && $pass == $existence['password']){
    //         userAuth($existence);
    //     }else{
    //         array_push($errMsg, "Почта либо пароль введены неверно!");
    //     }
    // }
    
}
