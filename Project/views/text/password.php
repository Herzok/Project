<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<?php $form = ActiveForm::begin(['action'=>'view-text'])?>

<?= $form->field($model, 'password')->passwordInput() ?>

<div class="form-group">
    <?= Html::submitButton('Проверить пароль', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
