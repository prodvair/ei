<?php
namespace console\models\torgs;

use Yii;
use yii\base\Module;

use console\models\GetInfoFor;
use console\models\managers\ManagerArrest;

use common\models\ErrorSend;

use common\models\Query\Lot\Torgs;
use common\models\Query\Lot\Managers;

use common\models\Query\Lot\Parser;

class TorgsMunicipal extends Module
{
    public function id($id)
    {
        $torg = \common\models\Query\Municipal\Torgs::findOne($id);
        $parser = new Parser();

        $parser->tableNameTo = 'eiLot.torgs';
        $parser->tableNameFrom = 'bailiff.torgs';
        $parser->tableIdFrom = $torg->trgId;

        $chekTorg = Torgs::find()->where(['oldId' => $torg->trgId, 'typeId' => 2])->all();
        if (!empty($chekTorg[0])) {

            $parser->message = 'Был добавлена';
            $parser->statusId = 1;

            $parser->save();

            echo "Данный Торга уже был добавлен ID ".$torg->trgId.". \n";

            return true;
        } else {
            if ($torg->trgPublished != null && $torg->trgBidFormId != null) {

                // Организатор торгов
                if (!$manager = Managers::find()->where(['oldId' => $torg->trgOrganizationId])->one()) {
                    echo "Организатор торгов для связи отцуствует! \nПробуем спарсить данный Организатора торгов. \n";

                    if (!ManagerArrest::torg($torg)){
                        
                        $parser->message = 'Организатор торгов для связи отсуствует!';
                        $parser->messageJson = [
                            'oldManagerId' => $torg->trgOrganizationId,
                        ];
                        $parser->statusId = 2;
            
                        $parser->save();

                        echo "Отсутствует Организатор торгов...\n";
                    } else {
                        $manager = Managers::find()->where(['oldId' => $torg->trgOrganizationId])->one();
                    }
                }

                $newTorg = new Torgs();
        
                if ($lot->trgBidKindName) {
                    $info['auctionType'] = $lot->trgBidKindName;
                }
                if ($lot->trgBidAuctionDate) {
                    $info['auctionDate'] = $lot->trgBidAuctionDate;
                }
                if ($lot->trgBidAuctionPlace) {
                    $info['auctionPlace'] = $lot->trgBidAuctionPlace;
                }
                if ($lot->trgSummationPlace) {
                    $info['SummationPlace'] = $lot->trgSummationPlace;
                }
                if ($lot->trgNotificationUrl) {
                    $info['notificationUrl'] = $lot->trgNotificationUrl;
                }
                if ($lot->trgBidUrl) {
                    $info['url'] = $lot->trgBidUrl;
                }
                if ($lot->trgFio) {
                    $info['contactFio'] = $lot->trgFio;
                }
                if ($lot->trgLotCount) {
                    $info['lotCount'] = $lot->trgLotCount;
                }
                if ($torg->trgLastChanged) {
                    $info['lastChanged'] = GetInfoFor::date_check($torg->trgLastChanged);
                }
                if ($torg->trgWithDrawType) {
                    $info['withDrawType'] = $torg->trgWithDrawType;
                }
                if ($torg->trgAppRequirement) {
                    $info['requirement'] = $torg->trgAppRequirement;
                }
                if ($torg->trgOpeningDate) {
                    $info['openingDate'] = $torg->trgOpeningDate;
                }
                if ($torg->trgPlaceRequest) {
                    $info['placeRequest'] = $torg->trgPlaceRequest;
                }
                if ($torg->trgTimeOut) {
                    $info['timeOut'] = $torg->trgTimeOut;
                }
                if ($torg->trgPlaceOffer) {
                    $info['placeOffer'] = $torg->trgPlaceOffer;
                }
                if ($torg->trgBulletinNumber) {
                    $info['bulletinNumber'] = $torg->trgBulletinNumber;
                }
                $info['isFas'] = (($torg->trgIsFas == 1)? 'Создан' : 'Не создан');

                if ($torg->trgBidFormId == 2) {
                    $newTorg->tradeTypeId = 2;
                } else if ($torg->trgBidFormId == 10) {
                    $newTorg->tradeTypeId = 1;
                } else {
                    $newTorg->tradeTypeId   = $torg->trgBidFormId;
                    $newTorg->tradeType     = $torg->trgBidFormName;
                }
        
                $newTorg->typeId        = 4;
                $newTorg->publisherId   = $manager->id;
                $newTorg->msgId         = $torg->trgBidNumber;
                $newTorg->description   = GetInfoFor::mb_ucfirst($torg->trgAppReceiptDetails);
                $newTorg->startDate     = GetInfoFor::date_check($torg->trgStartDateRequest);
                $newTorg->endDate       = GetInfoFor::date_check($torg->trgExpireDate);
                $newTorg->publishedDate = GetInfoFor::date_check($torg->trgPublished);
                $newTorg->info          = $info;
                $newTorg->oldId         = $torg->trgId;
        
                try {
                    $newTorg->save();
        
                    $parser->message = 'Успешно добавлена';
                    $parser->statusId = 1;
        
                    $parser->save();
        
                    echo "Успешно добавлена в таблицу Торгов ID ".$newTorg->id.", старый ID ".$torg->trgId.". \n";
                    return [true, $newTorg->id];

                } catch (\Throwable $th) {
        
                    $parser->message = $th->getMessage();
                    $parser->statusId = 3;
        
                    $parser->save();
                    
                    ErrorSend::parser($parser->id);
        
                    echo "Ошибка при добавлении в таблицу Торгов ID ".$torg->trgId.". \n";
                    return false;
                }
        
            } else {
        
                $parser->message = 'Запись пуста';
                $parser->statusId = 2;
        
                $parser->save();

                echo "Пустые данные в таблице Торгов ID ".$torg->trgId.". \n";
                return 2;
            }
        }
        return false;
    }
}