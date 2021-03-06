<?php
use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

use common\models\Query\Lot\Lots;

use frontend\components\LotBlock;
use frontend\components\ProfileMenu;

$name = Yii::$app->user->identity->getFullName();

$this->title = "Избранные – $name";
$this->params['breadcrumbs'][] = [
    'label' => 'Профиль',
    'template' => '<li class="breadcrumb-item active" aria-current="page">{link}</li>',
    'url' => ['user/index']
];
$this->params['breadcrumbs'][] = [
    'label' => 'Избранные',
    'template' => '<li class="breadcrumb-item active" aria-current="page">{link}</li>',
    'url' => ['user/wish_list']
];
$this->registerJsVar( 'lotType', '', $position = yii\web\View::POS_HEAD );
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
                
                <aside class="-kit sidebar-wrapper profile-sidebar">

                    <div class="bashboard-nav-box">
                    
                        <div class="box-heading"><h3 class="h6 text-white text-uppercase">Профиль:</h3></div>
                        <div class="box-content">
                        
                            <div class="dashboard-avatar mb-10">
                        
                                <div class="image">
                                <img class="setting-image-tag" src="<?=(Yii::$app->user->identity->avatar)? Yii::$app->user->identity->avatar: 'img/image-man/01.jpg'?>" alt="Image" />
                                </div>
                                
                                <div class="content">
                                    <h6><?=$name?></h6>
                                    <p class="mb-15"><?= Yii::$app->user->identity->getFullName() ?></p>
                                </div>
                                
                            </div>
                            
                            <?=ProfileMenu::widget(['page'=>'wishlist'])?>
                            
                            <!-- <p class="font-sm mt-20">Your last logged-in: <span class="text-primary font700">4 hours ago</span></p> -->

                        </div>
                        
                    </div>
                
                </aside>
                
            </div>
            
            <div class="col-12 col-lg-9">
                
                <div class="content-wrapper">
                    
                    <div class="form-draft-payment">
                    
                        <h3 class="heading-title"><span>Мои <span class="font200"> Избранные</span></span></h3>
                        
                        <div class="clear"></div>

                        <div class="mb-50"></div>


                        <div data-count="<?= $wishCount?>" class="row equal-height cols-1 cols-sm-2 cols-lg-3 gap-20 mb-30 wish-lot-list" id="">
                            <?php if ($wishList[0]->lots) {
                                foreach ($wishList as $wish) { echo LotBlock::widget(['lot' => $wish->lots]); } 
                            } else {
                                echo "<div class='p-15 font-bold'>Пока нет избранных лотов по арестованному имуществу</div>";
                            } ?>

                            <div class="pager-innner">
                        
                                <div class="row align-items-center text-center text-lg-left">
                                
                                    <div class="col-12 col-lg-5">
                                    </div>
                                    
                                    <div class="col-12 col-lg-7">
                                        
                                        <nav class="float-lg-right mt-10 mt-lg-0">
                                            <?= LinkPager::widget([
                                                'pagination' => $pages,
                                                'nextPageLabel' => "<span aria-hidden=\"true\">Далее</span></i>",
                                                'prevPageLabel' => "<span aria-hidden=\"true\">Назад</span>",
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
        
    </div>

</section>
