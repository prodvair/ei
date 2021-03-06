<?

use yii\widgets\Breadcrumbs;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

use common\models\Query\Zalog\OwnerProperty;

use frontend\components\LotBlockZalog;
use frontend\components\ProfileMenu;
use frontend\components\SearchForm;

$name = (\Yii::$app->user->identity->info['firstname'] || \Yii::$app->user->identity->info['lastname']) ? \Yii::$app->user->identity->info['firstname'] . ' ' . \Yii::$app->user->identity->info['lastname'] : \Yii::$app->user->identity->info['contacts']['emails'][0];
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
$this->registerJsVar('lotType', 'zalog', $position = yii\web\View::POS_HEAD);

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
              'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
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
                  <p class="mb-15"><?= (\Yii::$app->user->identity->info['firstname'] || \Yii::$app->user->identity->info['lastname']) ? \Yii::$app->user->identity->info['contacts']['emails'][0] : '' ?></p>
                </div>

              </div>

              <?= ProfileMenu::widget(['page' => 'importlots']) ?>

              <!-- <p class="font-sm mt-20">Your last logged-in: <span class="text-primary font700">4 hours ago</span></p> -->

            </div>

          </div>

        </aside>

      </div>

      <div class="col-12 col-lg-9">

        <div class="content-wrapper">

          <div class="form-draft-payment">

            <!-- <h3 class="heading-title">Публикация лотов</h3>

            <div class="clear"></div> -->

            <!-- <p>
              Вам открыта возможность размещать лоты
              <br>Ваша организация: <strong>"<?= $owner->name ?>"</strong>
              <br>Количество опубликованных лотов: <strong></strong>
            </p> -->

            <!-- <hr> -->

            <h4>Как загрузить лоты:</h4>
            <ul class="list-icon-absolute what-included-list mb-30">
              <li>
                <span class="icon-font"><i class="elegent-icon-check_alt2 text-primary"></i> </span>
                Скачайте <a href="<?= Url::to('files/Формат_добавления_лотов_в_залоговое_иммущество_ei.ru.xlsx') ?>" target="_blank" download>шаблон excel</a> файла;
              </li>
              <li>
                <span class="icon-font"><i class="elegent-icon-check_alt2 text-primary"></i> </span>
                Заполните файл в соответствии с <a href="<?= Url::to('files/Формат_добавления_лотов_в_залоговое_иммущество_ei.ru.xlsx') ?>" target="_blank" download>требованиями</a>;
              </li>
              <li>
                <span class="icon-font"><i class="elegent-icon-check_alt2 text-primary"></i> </span>
                Загрузите заполненный вашими данными файл в соответствующую форму;
              </li>
              <li>
                <span class="icon-font"><i class="elegent-icon-check_alt2 text-primary"></i> </span>
                Лоты из файла появятся в профиле со статусом “Не опубликовано”;
              </li>
              <li>
                <span class="icon-font"><i class="elegent-icon-check_alt2 text-primary"></i> </span>
                Добавьте каждому лоту вручную фотографии (возможно выбрать несколько), добавьте <br>категорию и подкатегорию (возможно выбрать несколько);
              </li>
              <li>
                <span class="icon-font"><i class="elegent-icon-check_alt2 text-primary"></i> </span>
                Нажмите кнопку “Опубликовать”.
              </li>
            </ul>

            <hr>

            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

            <div class="custom-file">
                <?= $form->field($modelImport, 'fileImport',['template' => '<div class="custom-file">{label}{hint}{input}{error}</div>'])->fileInput(['class' => 'custom-file-input'])->label('Загрузить файл',['class'=>'custom-file-label']) ?>
                
              <?= Html::submitButton('Импортировать лоты', ['class' => 'btn btn-primary']); ?>
            </div>


            <?php ActiveForm::end(); ?>

            <? if (Yii::$app->params['exelParseResult']) { ?>
              <ul>
                <?
                  foreach (Yii::$app->params['exelParseResult'] as $key => $value) {
                    if (!$value['status']) {
                      if (is_array($value['info'])) {
                      foreach ($value['info'] as $field => $err) {
                      ?>
                        <?= '<li> Поле: ' . $field . ' (' . $err[0] . ')</li>' ?>
                  
                      <?} 
                      } else { 
                        echo '<li> Лот уже добавлен</li>';

                      }
                    } else { ?>
                      Добавлено: <?=$value['count']?> лотов
                <?  }
                  } ?>

              </ul>
            <? } ?>

            <div class="row  equal-height cols-1 cols-sm-2 cols-lg-3 gap-20 mb-30 wish-lot-list">
              <? if ($lots) {
                foreach ($lots as $lot) {
                  echo LotBlockZalog::widget(['lot' => $lot, 'type' => 'long']);
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

              <? } ?>

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

</section>