
<?
require '../database/db.php';
?>
<? if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['category_id'])):?>
<?    $products = selectAll('product',  ['idCategory' => $_POST['category_id']]);?>
<option selected>Продукт выбранной категории:</option>
<?php foreach ($products as $key => $product): ?>
<option value="<?=$product['id']; ?>"><?=$product['name'];?></option>
<?php endforeach; ?>

<?php endif; ?>