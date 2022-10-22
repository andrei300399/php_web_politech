<?php

include(__DIR__ ."/../path.php");?>
<footer>
<?php if (isset($_SESSION['id'])): ?>
    <ul>
    <li><a href="<?php echo BASE_URL . "pages/createOrder.php";?>">Оформить заказ</a></li>
            <li><a href="<?php echo BASE_URL . "pages/orders.php";?>">Список заказов</a></li>
    </ul>
    <?php endif; ?>
    <div class="footer-bottom">
        &copy; myblog.com | Designed by Andrei Kukhto
    </div>
</footer>
