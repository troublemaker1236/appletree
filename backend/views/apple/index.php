<?php

use core\entities\Apple\Apple;


use core\helpers\AppleHelper;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\AppleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Apples';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Apple', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Generate Apple', ['generate'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Delete all Apple', ['deleteall'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [

                    [
                        'attribute' => 'id',
                        'value' => function (Apple $model) {
                            return Html::a(Html::encode($model->id), ['view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'status',
                        'filter' => AppleHelper::statusList(),
                        'value' => function (Apple $model) {
                            return AppleHelper::statusLabel($model->status);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'color',
                        'filter' => AppleHelper::colorList(),
                        'value' => function (Apple $model) {
                            return AppleHelper::colorLabel($model->color);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'class' => 'kartik\grid\EditableColumn',
                        'attribute' => 'size',
                        'refreshGrid' => true,
                        'editableOptions' => [
                            'header' => 'Введите проценты ХХ',
                            'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                            'formOptions' => ['action' => ['change-size']],
                            'resetDelay' => 0,
                            'options' => ['value' => '']
                        ],
                    ],
                    'created_at:datetime',
                    'drop_at:datetime',
                    [
                        'class' => 'yii\grid\ActionColumn',
                         'header' => 'Действие',
                        'template' => '{fall-to-ground}  {delete}',
                        'buttons' => [
                            'fall-to-ground' => function ($url, $model) {
                                if ($model->status == 0) {
                                    return \yii\helpers\Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', $url,
                                        ['title' => 'Упасть', 'data-pjax' => '0', 'class' => 'btn btn-default btn-sm']);
                                }
                            },
                            'delete' => function ($url, $model) {
                                if ($model->size==0) {
                                    return \yii\helpers\Html::a('<span class="glyphicon glyphicon-trash"></span>', $url,
                                        ['title' => 'Удалить', 'data-pjax' => '0', 'class' => 'btn btn-default btn-sm']);
                                }
                            }
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>