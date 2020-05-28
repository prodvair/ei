<?php

/* @var $this yii\web\View */
/* @var $model common\models\db\Lot */

use yii\widgets\ActiveForm;

$this->title = Yii::t('app', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lots'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->shortTitle, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin(); ?>

<div class='row'>
    <div class='lot-common col-lg-8'>
        <div class='box box-primary'>
            <div class='box-header'>
                <h3 class='box-title'><?= Yii::t('app', 'Common') ?></h3>
            </div>
            <div class='box-body'>

                <?= $this->render('_form_common', [
                    'form'  => $form,
                    'model' => $model,
                ]) ?>
            
            </div>
        </div>
        <div class='box box-primary'>
            <div class='box-header'>
                <h3 class='box-title'><?= Yii::t('app', 'Address') ?></h3>
            </div>
            <div class='box-body'>

                <?= $this->render('/place/_form', [
                    'form'  => $form,
                    'model' => $place,
                ]) ?>
            
            </div>
        </div>
    </div>
    <div class='lot-status col-lg-4'>
        <div class='box box-primary'>
            <div class='box-header'>
                <h3 class='box-title'><?= Yii::t('app', 'State') ?></h3>
            </div>
            <div class='box-body'>

                <?= $this->render('_form_state', [
                    'form'  => $form,
                    'model' => $model,
                ]) ?>
            
            </div>
        </div>
        <div class='box box-primary'>
            <div class='box-header'>
                <h3 class='box-title'><?= Yii::t('app', 'Image') ?></h3>
            </div>
            <div class='box-body'>

                <?= $this->render('_image', [
                    'model' => $model,
                ]) ?>
            
            </div>
        </div>
        <div class='box box-primary'>
            <div class='box-header'>
                <h3 class='box-title'><?= Yii::t('app', 'Document') ?></h3>
            </div>
            <div class='box-body'>

                <?= $this->render('_document', [
                    'model' => $model,
                ]) ?>
            
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
