<?php
use frontend\components\NumberWords;
?>
<aside class=" sidebar-wrapper no-border mt-20 mt-lg-0">

    <div class="booking-box">
    
        <div class="box-heading"><h3 class="h6 text-white text-uppercase">Информация о лоте</h3></div>
        
        <div class="box-content">
            
            <span class="font600 text-muted line-125">Начальная цена</span>
            <h4 class="line-125"> <?= Yii::$app->formatter->asCurrency($lot->startPrice)?> </h4>
            
            <ul class="border-top mt-20 pt-15">
                <li class="clearfix">Статус<span class="float-right"><?=$lot->status?></span></li>
                <?= ($lot->info['singlePrice'])? '<li class="clearfix">Единая цена<span class="float-right">'.$lot->info['singlePrice'].'</span></li>' : ''?>
                <?= ($lot->info['contractPayment'])? '<li class="clearfix">Цена договора<span class="float-right">'.$lot->info['contractPayment'].'</span></li>' : ''?>
                <li class="clearfix">Шаг<span class="float-right"><?=($lot->stepTypeId == 1)? $lot->step.'% ('.Yii::$app->formatter->asCurrency((($lot->price / 100) * $lot->step)).')' : Yii::$app->formatter->asCurrency($lot->step) ?></span></li>
                <?= ($lot->info['stepNegative'])? '<li class="clearfix">Шаг понижения<span class="float-right">'.$lot->info['stepNegative'].'</span></li>' : ''?>
                <li class="clearfix">Задаток<span class="float-right"><?=($lot->depositTypeId == 1)? $lot->deposit.'% ('.Yii::$app->formatter->asCurrency((($lot->price / 100) * $lot->deposit)).')' : Yii::$app->formatter->asCurrency($lot->deposit) ?></span></li>
                <li class="clearfix">Минимальная цена<span class="float-right"><?=Yii::$app->formatter->asCurrency($lot->info['minPrice']) ?></span></li>
                <?= ($lot->info['area'] > 0)? '<li class="clearfix">Площадь<span class="float-right">'.$lot->info['area'].'</span></li>' : ''?>
                <?= ($lot->info['areaMeters'] > 0)? '<li class="clearfix">Площадь в кв.м<span class="float-right">'.$lot->info['areaMeters'].'</span></li>' : ''?>
                <?= ($lot->info['fundSize'])? '<li class="clearfix">Размер уставного капитала<span class="float-right">'.$lot->info['fundSize'].'</span></li>' : ''?>
                <?= ($lot->info['acsPart'])? '<li class="clearfix">Процент продаваемых акций<span class="float-right">'.$lot->info['acsPart'].'</span></li>' : ''?>
                <?= ($lot->info['stockNum'])? '<li class="clearfix">Акции на продажу<span class="float-right">'.$lot->info['stockNum'].'</span></li>' : ''?>
                <?= ($lot->info['stockPercentSale'])? '<li class="clearfix">Процент УК акций на продажу<span class="float-right">'.$lot->info['stockPercentSale'].'</span></li>' : ''?>
                <?= ($lot->info['sellType'] != null)? '<li class="clearfix">Основания реализации<span class="float-right">'.$lot->info['sellType'].'</span></li>' : ''?>
                <?= ($lot->torg->info['auctionType'] != null)? '<li class="clearfix">Тип торгов<span class="float-right">'.$lot->torg->info['auctionType'].'</span></li>' : ''?>
                <li class="clearfix border-top"><?= ($lot->torg->info['url'] != null)? '<a href="'.$lot->torg->info['url'].'" target="_blank" rel="nofollow">Сайт организатора торгов</a>' : null ?></li>
                <li class="clearfix"><?= ($lot->torg->info['notificationUrl'] != null)? '<a href="'.$lot->torg->info['notificationUrl'].'" target="_blank" rel="nofollow">Ссылка на извещения</a></li>' : null ?>
                <li class="clearfix border-top font700">
                    <div class="border-top mt-1">
                    <span>Цена</span><span class="float-right text-dark"><?=Yii::$app->formatter->asCurrency($lot->price)?></span>
                    </div>
                </li>
            </ul>
            
            <p class="text-right font-sm"></p>

            <? if(empty($lot->archive)): ?>
                <? if (!$lot->archive): ?>
                    <a <?=(Yii::$app->user->isGuest)? 'href="#loginFormTabInModal-login" data-toggle="modal" data-target="#loginFormTabInModal" data-backdrop="static" data-keyboard="false"' : 'href="#lotFormTabInModal-service" data-toggle="modal" data-target="#lotFormTabInModal" data-backdrop="static" data-keyboard="false"'?> class="btn btn-primary btn-block">Подать заявку</a>
                <? endif ?>
            <? endif ?>
            <!-- <p class="line-115 mt-20">By clicking the above button you agree to our <a href="#">Terms of Service</a> and have read and understood our <a href="#">Privacy Policy</a></p> -->
            
        </div>
        
        <div class="box-bottom bg-light">
            
            <h6 class="font-sm">Техническая поддержка пользователей</h6>
            <p class="font-sm">Мы ответим на все вопросы по данному лоту: <br><a href="tel:8(800)600-33-05" class="text-primary">8-800-600-33-05</a>.</p>
            <p><a href="#buyLotModal" class="font-sm" data-toggle="modal" data-target="#buyLotModal" data-backdrop="static" data-keyboard="false">Как самостоятельно приобрести этот лот</a></p>
        </div>
        
    </div>

</aside>