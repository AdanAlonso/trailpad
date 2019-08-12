<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PlatformSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Stats');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="platform-stats">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
      <div class="col-sm-12">
        <canvas id="myChart"></canvas>
      </div>
    </div>
<script>
var ctx = document.getElementById('myChart').getContext('2d');
new Chart(document.getElementById("myChart"), {
    type: 'bar',
    data: {
      labels: ['consola 1', 'consola 2', 'consola 2', 'consola 2', 'consola 2', 'consola 2', 'consola 2', 'consola 2', 'consola 2', 'consola 2', 'consola 2', 'consola 2', 'consola 2', 'consola 2', 'consola 2', 'consola 2', 'consola 2', 'consola 2', 'consola 2', 'consola 2', 'consola 2'],
      datasets: [
        {
          label: 'estado a',
          backgroundColor: "#3e95cd",
          data: [60, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80]
        },
        {
          label: 'estado b',
          backgroundColor: "#c45850",
          data: [40, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20]
        }
      ]
    },
    options: {
      title: {
        display: true,
        text: 'Title'
      },
			tooltips: false,
      scales: {
        xAxes: [{
          stacked: true,
          display: false
        }],
        yAxes: [{
          stacked: true,
          
        }]
      },
    }
});
</script>

</div>
