<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\filters\RequestsLandingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Log Requests';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="requests-landing-index">

        <h1><?= Html::encode($this->title) ?></h1>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'label' => 'URL',
                    'format' => 'raw',
                    'attribute' => 'url',
                    'value' => function($model){ return Html::a($model->url, $model->url); }
                ],
                [
                    'label' => 'Количество визитов',
                    'attribute' => 'cnt',
                ],
                [
                    'label' => 'Последние посещение',
                    'attribute' => 'dateRequest',
                    'value' => function($model){ return Yii::$app->formatter->asDate($model->dateRequest); }
                ],
            ],
        ]);
        ?>
    </div>
<?php
