
<?php

include(__DIR__ ."/../path.php");?>
<header>
    <nav>
        <h1>Добро пожаловать в приложение Карьер</h1>
        <hr>
        <ul>
            <?php if (isset($_SESSION['id'])): ?>
            <li><a href="<?php echo BASE_URL . "pages/createOrder.php";?>">Оформить заказ</a></li>
            <li><a href="<?php echo BASE_URL . "pages/orders.php";?>">Список заказов</a></li>
            <li><a href="<?php echo BASE_URL . "logout.php";?>">Выход</a></li>
            <?php else: ?>
            <p>Вы не авторизованы</p>
            <?php endif; ?>
        </ul>
    </nav>
</header>