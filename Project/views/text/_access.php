<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div>
    <p> <b>Заголовок:</b> <?= $model['title']?></p>
    <p> <b>Отправитель:</b> <?= $model['name']?></p>
    <p> <b>Ссылка:</b> <?= Html::a((string)($model['link']), ['validate-password', 'id' => $model['id_content']]) ?></p>

    <p> <?= Html::a('Удалить сообщение', ['deletecontent'],[
        'class' => 'btn btn-danger',
        'name'=> 'Delete_button',
        'id' => 'del-message',
        'data-id' => $model['id_content']
    ]) ?>
    </p>
    </p>
</div>