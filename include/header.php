
<header>
    <nav>
        <ul>
            <?php if (isset($_SESSION['id'])): ?>
            <li><a href="#">Оформить заказ</a></li>
            <li><a href="#">Список заказов</a></li>
            <li><a href="http://projectkukhtoa/logout.php">Выход</a></li>
            <?php else: ?>
            <p>Вы не авторизованы</p>
            <?php endif; ?>
        </ul>
    </nav>
</header>