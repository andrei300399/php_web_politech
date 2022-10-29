<?php

include SITE_ROOT . "/database/db.php";
if (!$_SESSION){
    header('location: ' . BASE_URL);
}

$errMsg = [];


$categorys = selectAll('category');

$carMarks = selectAll('mark');

$shortsuminfo = selectAll('shortsuminfo', ["idUser" => $_SESSION['id']]);

$orders30 = callProcedure('last30order', [$_SESSION['id']]);

$orders30dates =[];
$orders30cnt =[];
foreach ($orders30 as $order) {
    array_push($orders30cnt, $order["sumorder"]);
    array_push($orders30dates, str_replace('-','',$order["orderDate"]));
}

function searchProduct($arr, $product){
    for($i=0;$i<=count($arr);$i++){
        if ($arr[$i]["product"]==$product) {
            return true;
        }
    }
    return false;
}


// Код для формы добавления продукта
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buttonAddProduct'])){

    $allEmpty = true;
    if ($_POST["category"] == "Категория нерудного материала:" || $_POST["product"] == "Продукт выбранной категории:") {
        array_push($errMsg, "Вы не выбрали категорию или подкатегорию!");
    } else if($_POST["amountProduct"] <= 0) {
        array_push($errMsg, "Количество товара должно быть больше 0!");
    }
    
    else {

    $oneProduct = [
        "category"=>$_POST["category"], 
        "product"=>$_POST["product"],
        "amountProduct"=>intval($_POST["amountProduct"]),
    ];

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

    
    if($_SESSION["order"][$_POST["product"]]["amountProduct"]  > selectOne('product', ['id' => $oneProduct["product"]])["amountStorage"] ) {
        $_SESSION["order"][$_POST["product"]]["amountProduct"] -= $oneProduct["amountProduct"];
        array_push($errMsg, "На складе осталось только ".(selectOne('product', ['id' => $oneProduct["product"]])["amountStorage"] - $_SESSION["order"][$_POST["product"]]["amountProduct"])." товара!");
        
    } 
    
    //проверить что в заказе есть продуктв с количеством больше 0
    foreach ($_SESSION["order"] as $product) {
        if ($product["amountProduct"] != 0) {
            $allEmpty = false;
        }
    }
    if ($allEmpty) {
        unset($_SESSION["order"]);
    }
}
}


// Код для оформления заказа
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buttonFinishOrder'])){



    $userId = $_SESSION["id"];
    $orderDate = date('Y-m-d');
    $orderCode = $userId."u".time();
    $deliviryDate = $_POST['deliviryDate'];
    $markCar = $_POST['carUser'];
    $isEmail = $_POST['mailCheck'];
    $emailUser = $_POST['emailUser'];
    $amountProduct = 0;

    foreach ($_SESSION["order"] as $product) {
        $amountProduct+= $product["amountProduct"];
    }

    $carOrder = callProcedure('test_pr', [$deliviryDate, $markCar, $amountProduct]);
    $marks="";

    if ($deliviryDate < $orderDate) {
        array_push($errMsg, "Дата доставки меньше текущей!");
    } else if (count($carOrder) == 0){
        array_push($errMsg, "На дату нет свободных машин!");

    } else if (count($carOrder) > 0 && !array_key_exists("id_car", $carOrder[0])) {
        foreach ($carOrder as $mark) {
            $marks = $marks.$mark["mark"]." ";
        }
        array_push($errMsg, "На дату свободны только марки машин: $marks!");

    }
    
    else {
        print_r($carOrder);
        $inserted = insert('order', ['idUser' => $userId ,'orderDate' => $orderDate,'code' => $orderCode, 'deliviryDate' => $deliviryDate, "idCar"=> $carOrder[0]["id_car"]]);  
        foreach ($_SESSION["order"] as $product) {
           
            callProcedure('update_product_info', [$inserted ,$product['product'],$product['amountProduct']]);

        }
        $deliviryCar = selectOne('car', ['id' => $carOrder[0]["id_car"]]);
        $volumeCar = $deliviryCar["volume"];
        $timesCar = ceil($amountProduct/ $volumeCar);



//отправка на почту
$shortsuminfo2 = selectAll('shortsuminfo');
$currentOrder;
foreach ($shortsuminfo2 as $key => $item){
    if ($item['code']==$orderCode) {
        $currentOrder = $item;
    } 
}
$user = selectOne('user', ['id' => $userId]);
$fd = fopen(__DIR__."\\..\\basket.txt", 'w') or die("не удалось создать файл");
$str = "Дата заказа: ".$orderDate."
Имя: ".$user["firstName"]." Фамилия: ".$user["lastName"]."
Дата доставки: ".$deliviryDate."
Сумма заказа (руб): ".$currentOrder["sumorder"]."
Количество заездов: ". $timesCar."
Марка машины: ". $markCar."
Количество товара (т): ". $amountProduct;
fwrite($fd, $str);
fclose($fd);

$to      = $emailUser;
$subject = 'Заказ на карьере';
$message = $str;
$headers = 'From: andrei060656@yandex.ru' . "\r\n" .
    'Reply-To: andrei060656@yandex.ru' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

    $success = mail($to, $subject, $message, $headers);



        header('refresh:0;url='. BASE_URL);
        echo '<script>
      alert("Марка машины: '.$markCar.'.\nКоличество заездов: '. $timesCar.'.\nДата доставки: '.$deliviryDate.'.\nСтоимость: '.$currentOrder["sumorder"].' руб.");
        </script>';
       
    }

}

// просмотр выбранного заказа
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['order_id'])){
    $products = selectAll('allinfo', ['idOrder' => $_GET['order_id']]);
    $selectedOrder = selectOne('shortsuminfo', ['idOrder' => $_GET['order_id']]);
    
}

//код отмены заказа

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buttonCancel'])){
    $products = selectAll('allinfo', ['idOrder' => $_POST['hiddenIdOrder']]);
    $selectedOrder = selectOne('shortsuminfo', ['idOrder' => $_POST['hiddenIdOrder']]);
    if (date('Y-m-d') > $selectedOrder["deliviryDate"]) {
        array_push($errMsg, "Заказ доставлен! Отмена не возможна!");
        
    } else {
        $deleted = deleteOne('order', ['id' => $_POST['hiddenIdOrder']]);
        header("Location: ". BASE_URL);
    }
   
}

