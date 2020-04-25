<?php

/* @var $this yii\web\View */
/* @var $model core\forms\manage\Apple\AppleEditForm */
/* @var $apple core\entities\Apple\Apple */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Update Apple: ' . $apple->id;
$this->params['breadcrumbs'][] = ['label' => 'Apples', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $apple->id, 'url' => ['view', 'id' => $apple->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'status')->textInput(['maxLength' => true]) ?>
    <?= $form->field($model, 'color')->textInput(['maxLength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>