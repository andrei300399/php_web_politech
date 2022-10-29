
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
        <h2>Список заказов</h2>
       
        
        <div class="chartBTN">
          <button class="btnAdd" onclick="hideChart()">Показать/скрыть график</button>
          <div id="chart">
          <canvas id="myChart" width=600 height=300></canvas>
          </div>
 
</div>
     
        <table >
        <tr>
                                <td >
                                №
                                </td>
                                <td >
                                Код заказа
                                </td>
                                <td >
                                Сумма 
                                </td>
                                <td >
                                Дата создания заказа
                                </td>
                                <td >
                                Дата доставки заказа
                                </td>
                                <td >
                                Номер машины
                                </td>
                                <td >
                                Марка машины
                                </td>

        </tr>
        <?php foreach ($shortsuminfo as $key => $item): ?>
                            <tr >
                                <td >
                                <?=$key+1; ?>
                                </td>
                                <td >
                                <a href="showOrder.php?order_id=<?=$item['idOrder'];?>">
                                <?=$item['code'] ;?>
                                </a>
                                </td>
                                <td >
                                <?=$item['sumorder']; ?>
                                </td>
                                <td >
                                <?=$item['orderDate']; ?>
                                </td>
                                <td >
                                <?=$item['deliviryDate']; ?>
                                </td>
                                <td >
                                <?=$item['codeCar']; ?>
                                </td>
                                <td >
                                <?=$item['mark']; ?>
                                </td>
        </tr>
        <?php endforeach; ?>
    </table>
    </div>

    <?php include(SITE_ROOT."/include/footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
  const labels = [
    <?=implode(',',array_reverse($orders30dates));?>
  ];

  const data = {
    labels: labels,
    datasets: [{
      label: 'Суммы последних 10 заказов',
      backgroundColor: 'rgb(255, 99, 132)',
      borderColor: 'rgb(255, 99, 132)',
      data: [<?=implode(',',array_reverse($orders30cnt));?>],
    }]
  };

  const config = {
    type: 'line',
    data: data,
    options: {
                responsive: false,
                scales: {
            x: {
                ticks: {
                    autoSkip: false,
                    maxRotation: 90,
                    minRotation: 90
                }
            }
        }
            }
  };
</script>
<script>
  const myChart = new Chart(
    document.getElementById('myChart'),
    config
  );
</script>
<script src="../assets/script.js"></script>
    </body>



</html>
