<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $message yii\swiftmailer\Message */
/* @var $user common\models\User */
/* @var $models common\models\Query\Lot\Lots */
/* @var $lots array [lot_id => ['new-picture', 'price-reduction']] */

$link = Yii::$app->params['frontLink'] . '/wishlist/unsubscribe?token=' . $user->password_reset_token;
?>
<div class='notification'>
    <p>Добрый день, <?= Html::encode($user->getFullName()) ?>,</p>

    <?php foreach ($models as $model): ?>
        <h3>Лот<br><small><?= $model->title ?></small></h3>
        <?php foreach ($lots[$model->id] as $event): ?>
            <?= $this->render("notification/$event-html", ['model' => $model, 'message' => $message]) ?>
        <?php endforeach; ?>
        <p>Для просмотра лота перейдите по <?= Html::a('ссылке', 
            Yii::$app->params['frontLink'] .'/lot/view/' . $model->id) ?>.</p>
        <hr>
        <p><small>
            <?= Html::a('Отписаться', $link . '&lot_id=' . $model->id) ?> от уведомлений по данному лоту.
        </small></p>
    <?php endforeach; ?>
    <p><small>
        Вы также можете полностью <?= Html::a('очистить', $link) ?> список избранных лотов.
    </small></p>
</div>
