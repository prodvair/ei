<?php

use common\models\db\Profile;
use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use frontend\modules\profile\components\ProfileMenu;


$name = Yii::$app->user->identity->getFullName();
$this->registerJsVar('lotType', false, $position = yii\web\View::POS_HEAD);

$this->title = "Настройка профиля – $name";
$this->params[ 'breadcrumbs' ][] = [
    'label'    => 'Профиль',
    'template' => '<li class="breadcrumb-item active" aria-current="page">{link}</li>',
    'url'      => ['user/index']
];
$this->params[ 'breadcrumbs' ][] = [
    'label'    => 'Настройки',
    'template' => '<li class="breadcrumb-item" aria-current="page">{link}</li>',
    'url'      => ['user/setting']
];
?>

<section class="page-wrapper page-detail">

    <div class="page-title border-bottom pt-25 mb-0 border-bottom-0">

        <div class="container">

            <div class="row gap-15 align-items-center">

                <div class="col-12 col-md-7">

                    <nav aria-label="breadcrumb">
                        <?= Breadcrumbs::widget([
                            'itemTemplate'       => '<li class="breadcrumb-item">{link}</li>',
                            'encodeLabels'       => false,
                            'tag'                => 'ol',
                            'activeItemTemplate' => '<li class="breadcrumb-item active" aria-current="page">{link}</li>',
                            'homeLink'           => ['label' => '<i class="fas fa-home"></i>', 'url' => '/'],
                            'links'              => $this->params[ 'breadcrumbs' ],
                        ]) ?>
                    </nav>

                </div>

            </div>

        </div>

    </div>

    <div class="container pt-30">

        <div class="row gap-20 gap-lg-40">

            <div class="col-12 col-lg-3">

                <aside class="-kit sidebar-wrapper">

                    <div class="bashboard-nav-box">

                        <?= ProfileMenu::widget(['page' => 'setting']) ?>

                    </div>

                </aside>

            </div>

            <div class="col-12 col-lg-9">

                <div class="content-wrapper">

                    <div class="form-draft-payment">

                        <h3 class="heading-title"><span>Настройка <span class="font200"> профиля</span></span></h3>

                        <div class="clear"></div>

                        <div class="row gap-30">

                            <div class="col-6 col-sm-5 col-md-4 col-lg-4 order-lg-last">

                                <?php $form = ActiveForm::begin(['action' => '/profile/setting_image', 'options' => ['enctype' => 'multipart/form-data', 'id' => 'setting-image']]) ?>

                                <div class="avatar-upload">
                                    <img class="profile-pic d-block setting-image-tag"
                                         src="<?= (Yii::$app->user->identity->getAvatarImage()) ? Yii::$app->user->identity->getAvatarImage() : 'img/image-man/01.jpg' ?>"
                                         alt="avatar"/>
                                    <label for="avatar-upload">
                                        <div class="upload-button text-secondary line-1">
                                            <div>
                                                <i class="fas fa-upload text-primary"></i>
                                                <span class="d-block font12 text-uppercase font700 mt-10 text-primary">Максимальный размер:<br/>250 Мб</span>
                                            </div>
                                        </div>
                                    </label>
                                    <?= $form->field($model_image, 'photo')->fileInput(['class'=>'file-upload', 'id'=>'avatar-upload', 'accept' => 'image/*'])->label(false) ?>
                                    <div class="labeling">
                                        <i class="fas fa-upload"></i> <span
                                                class="setting-image-info">Изменить аватарку</span>
                                    </div>
                                </div>

                                <?php ActiveForm::end() ?>

                            </div>

                            <div class="col-12 col-md-12 col-lg-8">

                                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
                                <div class="col-inner">

                                    <div class="row gap-20">

                                        <?php if ($success) : ?>
                                            <div class="col-md-12 alert alert-success">
                                                <p><?= $success ?></p>
                                            </div>
                                        <?php elseif ($error) : ?>
                                            <div class="col-md-12 alert alert-danger">
                                                <p><?= $error ?></p>
                                            </div>
                                        <?php endif; ?>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group mb-0">
                                                <?= $form->field($model, 'first_name')->textInput(['class' => 'form-control'])->label('Имя') ?>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-4">
                                            <div class="form-group mb-0">
                                                <?= $form->field($model, 'last_name')->textInput(['class' => 'form-control'])->label('Фамилия') ?>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-4">
                                            <div class="form-group mb-0">
                                                <?= $form->field($model, 'middle_name')->textInput(['class' => 'form-control'])->label('Отчество') ?>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6">
                                            <div class="form-group mb-0">
                                                <?= $form->field($model, 'phone')->textInput(['class' => 'form-control phone-ready', 'readonly' => true])->label('Номер телефона') ?>
                                                <a href="#phoneEditModel-phone" id="edit_phone"
                                                   class="tab-external-link block mt-25" data-toggle="modal"
                                                   data-target="#phoneEditModel" data-backdrop="static"
                                                   data-keyboard="false">Изменить</a>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6">
                                            <div class="form-group mb-0">
                                                <?= $form->field($model, 'email')->textInput(['class' => 'form-control'])->label('E-mail') ?>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6">
                                            <div class="form-group mb-0 chosen-bg-light">
                                                <?= $form->field($model, 'birthday')->textInput([
                                                    'class'   => 'form-control',
                                                    'value'   => ($model->birthday) ? Yii::$app->formatter->asDate($model->birthday) : '',
                                                    'onClick' => 'xCal(this, {lang: \'ru\'})'
                                                ])->label('Дата рождения') ?>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6">
                                            <div class="form-group mb-0">
                                                <?= $form->field($model, 'gender')->dropDownList([
                                                    Profile::GENDER_MALE   => 'Мужской',
                                                    Profile::GENDER_FEMALE => 'Женский'
                                                ],
                                                    [
                                                        'class'            => 'chosen-the-basic form-control form-control-sm',
                                                        'data-placeholder' => 'Все категории',
                                                        'tabindex'         => '2',
                                                        //'options' => [
                                                        //Yii::$app->user->identity->info['sex'] => ['Selected' => true]
                                                        //]
                                                    ])
                                                    ->label('Пол'); ?>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12">
                                            <div class="form-group mb-0">
                                                <?= $form->field($model, 'city')->textInput(['class' => 'form-control'])->label('Город') ?>
                                                <?= $form->field($model, 'address')->textInput(['class' => 'form-control'])->label('Адрес') ?>
                                            </div>
                                        </div>

                                    </div>

                                    <hr class="mt-40 mb-40" />

                                    <h5 class="text-uppercase">Сменить пароль</h5>

                                    <div class="row gap-20">
                                        <div class="col-12 col-sm-12">
                                            <div class="form-group mb-0">
                                                <?= $form->field($model, 'old_password')->passwordInput(['class' => 'form-control'])->label('Старый пароль') ?>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group mb-0">
                                                <?= $form->field($model, 'new_password')->passwordInput(['class' => 'form-control'])->label('Новый пароль') ?>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group mb-0">
                                                <?= $form->field($model, 'repeat_password')->passwordInput(['class' => 'form-control'])->label('Подтвердите пароль') ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-30"></div>

                                    <div class="row gap-10 mt-15 justify-content-center justify-content-md-start">
                                        <div class="col-auto">
                                            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                                        </div>
<!--                                        <div class="col-auto offset-md-2">-->
<!--                                            <a href="--><?//= Url::to('/lot/profile/change-password') ?><!--"><h5-->
<!--                                                        class="text-uppercase btn btn-secondary">Сменить пароль</h5></a>-->
<!--                                        </div>-->
                                    </div>


                                </div>
                                <?php ActiveForm::end() ?>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- start phone form modal -->
<div class="modal fade modal-with-tabs form-login-modal" id="phoneEditModel" aria-labelledby="modalWIthTabsLabel"
     tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content shadow-lg">
            <div class="pt-4 pr-4 ml-auto">
                <button type="button" class="close" data-dismiss="modal" aria-labelledby="Close">
                    <span aria-hidden="true"><i class="far fa-times-circle"></i></span>
                </button>
            </div>

            <nav class="d-none">
                <ul class="nav external-link-navs clearfix">
                    <li><a class="active" data-toggle="tab" href="#phoneEditModel-phone">Телефон</a></li>
                    <li><a data-toggle="tab" href="#phoneEditModel-code">Код </a></li>
                    <li><a data-toggle="tab" href="#phoneEditModel-ready">Готово </a></li>
                </ul>
            </nav>


            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="phoneEditModel-phone">

                    <div class="form-login">

                        <div class="form-header">
                            <h4>Изменить номер телефона</h4>
                        </div>

                        <div class="form-body">
                            <?php $form = ActiveForm::begin(['action' => Url::to(['/profile/get-code']), 'id' => 'phone-edit-form']); ?>

                            <span class="phone-form-error tab-external-link block mt-25 text-danger"></span>

                            <div class="flex-md-grow-1 bg-primary-light">
                                <?= $form->field($model_phone, 'phone')->textInput(['class' => 'form-control phone_mask', 'placeholder' => 'Новый номер телефона', 'required' => true])->label(false);?>
                                <div class="d-flex">
                                    <?= Html::submitButton('Изменить', ['class' => 'btn btn-primary btn-wide']) ?>
                                    <div class="loader">
                                        <div class='sk-wave'>
                                            <div class='sk-rect sk-rect-1'></div>
                                            <div class='sk-rect sk-rect-2'></div>
                                            <div class='sk-rect sk-rect-3'></div>
                                            <div class='sk-rect sk-rect-4'></div>
                                            <div class='sk-rect sk-rect-5'></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php ActiveForm::end(); ?>

                        </div>
                    </div>

                </div>

                <div role="tabpanel" class="tab-pane fade in" id="phoneEditModel-code">

                    <div class="form-login">
                        <?php $form = ActiveForm::begin(['action' => Url::to(['/profile/get-code']), 'id' => 'code-check-form']); ?>

                        <div class="form-header">
                            <h4>Подтвердите номер</h4>
                            <p>На ваш телефон придёт SMS с кодом подтверждения: <span class="phone-time">00</span>
                                секунд.
                                <a href="#" class="resend-code d-none">Повторить</a>
                                <?= $form->field($model_phone, 'phone')->textInput(['class' => 'form-control phone_visible', 'readonly' => true])->label(false);?>
                            </p>
                            <a class="back-to-tab" href="#phoneEditModel-phone">Изменить номер</a>
                        </div>

                        <div class="form-body">

                            <span class="code-form-error block mt-25 text-danger"></span>

                            <div class="flex-md-grow-1 bg-primary-light">
                                <?= $form->field($model_phone, 'code')->textInput(['class' => 'form-control code_mask', 'placeholder' => '_ _ _ _'])->label(false);?>
                                <div class="d-flex">
                                    <?= Html::submitButton('Подтвердить', ['class' => 'btn btn-primary btn-wide']) ?>
                                    <div class="loader">
                                        <div class='sk-wave'>
                                            <div class='sk-rect sk-rect-1'></div>
                                            <div class='sk-rect sk-rect-2'></div>
                                            <div class='sk-rect sk-rect-3'></div>
                                            <div class='sk-rect sk-rect-4'></div>
                                            <div class='sk-rect sk-rect-5'></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>

                </div>

                <div role="tabpanel" class="tab-pane fade in" id="phoneEditModel-ready">
                    <div class="form-body">
                        <div class="success-icon-text">
                            <span class="icon-font  text-success"><i class="elegent-icon-check_alt2"></i></span>
                            <h4 class="text-uppercase letter-spacing-1">Успешно изменено!</h4>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- end phone form modal -->

<?php
$js = <<<JS
$('.loader').hide();
$('#phone-edit-form').on('beforeSubmit', function(){
    var data = $(this).serialize();
    $('.loader').show();
    $.ajax({
        url: '/profile/get-code',
        type: 'POST',
        data: data,
        success: function(res){
            $('.loader').hide();
            if (res.result) {
                toastr.success('Код отправлен');
                phone = $('.phone_mask').val()
                phone = phone.substring(0, phone.length - 5) + "**-**";
                $('.phone_visible').val(phone);
                $('#phoneEditModel-phone').removeClass('active');
                $('#phoneEditModel-code').addClass('active show');
                timer(60)
            } else {
                toastr.warning(res.mess);
            }
        },
        error: function(res){
            toastr.error('Серверная ошибка');
        }
    });
    return false;
});
$('.back-to-tab').on('click', function (e) {
    e.preventDefault();
    $('.tab-pane').removeClass('active');
    $('.tab-pane').removeClass('show');
    $(".resend-code").addClass("d-none");
    $($(this).attr('href')).addClass('active show');
});
$('#code-check-form').on('beforeSubmit', function(){
    var data = $(this).serialize();
    $('.loader').show();
    $.ajax({
        url: '/profile/edit-phone',
        type: 'POST',
        data: data,
        success: function(res){
            $('.loader').hide();
            if (res.result) {
                toastr.success(res.error);
                $('#phoneEditModel-code').removeClass('active');
                $('#phoneEditModel-code').removeClass('show');
                $('#phoneEditModel-ready').addClass('active show');
                $('.phone-ready').val($('.phone_mask').val());
            } else {
                toastr.warning(res.error);
            }
        },
        error: function(res){
            $('.loader').hide();
            toastr.error('Серверная ошибка');
        }
    });
    return false;
});
JS;

$this->registerJs($js);
$this->registerJsFile('/js/cssworld.ru-xcal.js', $options = ['position' => yii\web\View::POS_HEAD], $key = 'date_picker');
$this->registerCssFile('/css/cssworld.ru-xcal.css');
?>
