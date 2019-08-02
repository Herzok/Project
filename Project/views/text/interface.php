<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use app\models\Users;
use yii\widgets\Pjax;
?>
<p><b>Новая секретная информация</b></p>

<?php $form = ActiveForm::begin(['id' => 'add-text-form', 'action'=>'add-text']); ?>

<?= $form->field($model, 'title')->textInput() ?>

<?= $form->field($model, 'text')->textarea() ?>

<?= $form->field($model, 'password')->passwordInput() ?>

<?= $form->field($model_access,'receiver_id')->radioList(ArrayHelper::map(Users::find()->all(), 'id_user', 'name')); ?>

<div class="form-group">
    <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary','id' => 'add-text-btn']) ?>
</div>
<?php ActiveForm::end(); ?>

<div>
    <?= GridView::widget([
        'id' => 'pjax-message-list',
        'dataProvider' => $dataProviderContent,
        'filterModel' => $model_content,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id_content',
            'title',
            'text',
            'link',
            [
                'class' => 'yii\grid\ActionColumn',
                'options'=>['class'=>'action-column'],
                'template'=>'{delete}',
                'buttons' => [
                    'delete' => function ($url,$model,$key) {
                        return Html::a('',
                            ['deletecontent','id' => $model['id_content']],
                            ['class' => 'glyphicon glyphicon-trash',
                                'id'=>'gridviewtrash',
                                'title'=>'Удалить сообщение']);
                    }]
            ],
        ]
    ]);?>
</div>
<?php Pjax::begin(['id' => 'pjax-receive-message-list']); ?>
    <?= \yii\widgets\ListView::widget([
        'dataProvider' => $dataProviderAccess,
        'itemView' => '_access',
        'separator' => "<hr/>",
        'itemOptions' =>['class' => 'well']
    ]); ?>
<?php Pjax::end(); ?>
