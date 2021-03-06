<?php

use yii\widgets\Breadcrumbs;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

use common\models\Query\Zalog\OwnerProperty;
use common\models\Query\Zalog\LotsZalog;

use frontend\components\LotBlockZalog;
use frontend\components\ProfileMenu;
use frontend\components\SearchForm;

$name = Yii::$app->user->identity->getFullName();

$this->title = "Мои лоты – $name";
$this->params['breadcrumbs'][] = [
  'label' => 'Профиль',
  'template' => '<li class="breadcrumb-item active" aria-current="page">{link}</li>',
  'url' => ['user/index']
];
$this->params['breadcrumbs'][] = [
  'label' => 'Мои лоты',
  'template' => '<li class="breadcrumb-item active" aria-current="page">{link}</li>',
  'url' => ['user/lots']
];
// $this->registerJsVar( 'lotType', 'zalog', $position = yii\web\View::POS_HEAD );
$this->registerJsVar( 'lotType', 'zalog', $position = yii\web\View::POS_HEAD );

$owner = OwnerProperty::findOne(Yii::$app->user->identity->ownerId);
?>

<section class="page-wrapper page-detail">

  <div class="page-title border-bottom pt-25 mb-0 border-bottom-0">

    <div class="container">

      <div class="row gap-15 align-items-center">

        <div class="col-12 col-md-7">

          <nav aria-label="breadcrumb">
            <?= Breadcrumbs::widget([
              'itemTemplate' => '<li class="breadcrumb-item">{link}</li>',
              'encodeLabels' => false,
              'tag' => 'ol',
              'activeItemTemplate' => '<li class="breadcrumb-item active" aria-current="page">{link}</li>',
              'homeLink' => ['label' => '<i class="fas fa-home"></i>', 'url' => '/'],
              'links' => $this->params['breadcrumbs'],
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

            <div class="box-heading">
              <h3 class="h6 text-white text-uppercase">Профиль</h3>
            </div>
            <div class="box-content">

              <div class="dashboard-avatar mb-10">

                <div class="image">
                  <img class="setting-image-tag" src="<?= (Yii::$app->user->identity->avatar) ? Yii::$app->user->identity->avatar : 'img/image-man/01.jpg' ?>" alt="Image" />
                </div>

                <div class="content">
                  <h6><?= $name ?></h6>
                  <p class="mb-15"><?= Yii::$app->user->identity->getFullName() ?></p>
                </div>

              </div>

              <?= ProfileMenu::widget(['page' => 'lots']) ?>

              <!-- <p class="font-sm mt-20">Your last logged-in: <span class="text-primary font700">4 hours ago</span></p> -->

            </div>

          </div>

        </aside>

      </div>

      <div class="col-12 col-lg-9">

        <div class="content-wrapper">

          <div class="form-draft-payment">

            <div class="">
              <!-- <a class="btn btn-primary" href="<?= Url::to(['user/add-lot']) ?>"><i class="fa fa-plus"></i> Добавить лот</a> -->
              <a class="btn btn-primary" href="<?= Url::to(['user/import-lots']) ?>"><i class="fa fa-list"></i> Импортировать лоты из XML/xls/xlsx</a>
            </div>

            <hr>

            <div>
              <div class="hero-banner hero-banner-01 overlay-light opacity-2 overlay-relative overlay-gradient gradient-white alt-option-03 search-form-static">
                <?= SearchForm::widget(['lotType' => 'zalog']) ?>
              </div>
            </div>

            <hr>

            <div class="row  equal-height cols-1 cols-sm-2 cols-lg-3 gap-20 mb-30 wish-lot-list">
              <? if ($lots) {
                foreach ($lots as $lot) {
                  echo LotBlockZalog::widget(['lot' => $lot, 'type' => 'long']);
                }
              } else {
                echo "<div class='p-15 font-bold'>Пока что у вас нету лотов</div>";
              } ?>

            <div class="pager-innner">
              <div class="row align-items-center text-center text-lg-left">

                <div class="col-12 col-lg-5">
                </div>

                <div class="col-12 col-lg-7">

                  <nav class="float-lg-right mt-10 mt-lg-0">
                    <?= LinkPager::widget([
                      'pagination' => $pages,
                      'nextPageLabel' => "<span aria-hidden=\"true\">&raquo;</span></i>",
                      'prevPageLabel' => "<span aria-hidden=\"true\">&laquo;</span>",
                      'maxButtonCount' => 6,
                      'options' => ['class' => 'pagination justify-content-center justify-content-lg-left'],
                      'disabledPageCssClass' => false
                    ]); ?>
                  </nav>
                </div>

              </div>
            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

</section>

<script>
  function uploadLotImage(lotId) {
    var formData = new FormData(document.getElementById('lot-' + lotId + '-zalog-upload-images'));

    // var ins = document.getElementById('images-'+lotId+'-upload').files.length;
    // for (var x = 0; x < ins; x++) {
    //     formData.append('images', document.getElementById('images-'+lotId+'-upload').files[x]);
    // }

    $.ajax({
      type: 'POST',
      contentType: false,
      processData: false,
      url: $('#lot-' + lotId + '-zalog-upload-images').attr('action'),
      data: formData
    }).done(function(data) {
      if (data.status) {
        var imagesTag = '';

        data.src.map(function(src) {
          imagesTag = imagesTag + `<img class="profile-pic d-block" src="` + src.min + `" alt="" />`;
        });

        $('.lot-' + lotId + '-upload-image-tag').html(imagesTag);
        $('.lot-' + lotId + '-zalog-image-info').html('Успешно загружено');

        toastr.success("Фотографии успешно загружены");
      } else {
        $('.lot-' + lotId + '-zalog-image-info').html('Ошибка загрузки');

        toastr.warning("Не удалось загрузить фотографии");
      }
    }).fail(function() {
      toastr.error("Ошибка при загрузки фотографии");
    })
  }
</script>
