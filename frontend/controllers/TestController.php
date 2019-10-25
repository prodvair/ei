<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Query\Bankrupt\LotsBankrupt;
use common\models\Query\Arrest\LotsArrest;
use common\components\Translit;
use common\models\Query\Bankrupt\Value;

use common\models\Query\Regions;

/**
 * Test controller
 */
class TestController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $items = [
            ["Республика Адыгея", "1"],
            ["Республика Башкортостан", "02"],
            ["Республика Бурятия", "3"],
            ["Республика Алтай", "4"],
            ["Республика Дагестан", "5"],
            ["Республика Ингушетия", "6"],
            ["Кабардино-Балкарская Республика", "7"],
            ["Республика Калмыкия", "8"],
            ["Республика Карачаево-Черкесия", "9"],
            ["Республика Карелия", "10"],
            ["Республика Коми", "11"],
            ["Республика Марий Эл", "12"],
            ["Республика Мордовия", "13"],
            ["Республика Саха (Якутия)", "14"],
            ["Республика Северная Осетия — Алания", "15"],
            ["Республика Татарстан", "16"],
            ["Республика Тыва", "17"],
            ["Удмуртская Республика", "18"],
            ["Республика Хакасия", "19"],
            ["Чувашская Республика", "21"],
            ["Алтайский край", "22"],
            ["Краснодарский край", "23"],
            ["Красноярский край", "24"],
            ["Приморский край", "25"],
            ["Ставропольский край", "26"],
            ["Хабаровский край", "27"],
            ["Амурская область", "28"],
            ["Архангельская область", "29"],
            ["Астраханская область", "30"],
            ["Белгородская область", "31"],
            ["Брянская область", "32"],
            ["Владимирская область", "33"],
            ["Волгоградская область", "34"],
            ["Вологодская область", "35"],
            ["Воронежская область", "36"],
            ["Ивановская область", "37"],
            ["Иркутская область", "38"],
            ["Калининградская область", "39"],
            ["Калужская область", "40"],
            ["Камчатский край", "41"],
            ["Кемеровская область", "42"],
            ["Кировская область", "43"],
            ["Костромская область", "44"],
            ["Курганская область", "45"],
            ["Курская область", "46"],
            ["Ленинградская область", "47"],
            ["Липецкая область", "48"],
            ["Магаданская область", "49"],
            ["Московская область", "50"],
            ["Мурманская область", "51"],
            ["Нижегородская область", "52"],
            ["Новгородская область", "53"],
            ["Новосибирская область", "54"],
            ["Омская область", "55"],
            ["Оренбургская область", "56"],
            ["Орловская область", "57"],
            ["Пензенская область", "58"],
            ["Пермский край", "59"],
            ["Псковская область", "60"],
            ["Ростовская область", "61"],
            ["Рязанская область", "62"],
            ["Самарская область", "63"],
            ["Саратовская область", "64"],
            ["Сахалинская область", "65"],
            ["Свердловская область", "66"],
            ["Смоленская область", "67"],
            ["Тамбовская область", "68"],
            ["Тверская область", "69"],
            ["Томская область", "70"],
            ["Тульская область", "71"],
            ["Тюменская область", "72"],
            ["Ульяновская область", "73"],
            ["Челябинская область", "74"],
            ["Забайкальский край", "75"],
            ["Ярославская область", "76"],
            ["Москва", "77"],
            ["Санкт-Петербург", "78"],
            ["Еврейская автономная область", "79"],
            ["Республика Крым", "82"],
            ["Ненецкий автономный округ", "83"],
            ["Ханты-Мансийский автономный округ Югра", "86"],
            ["Чукотский автономный округ", "87"],
            ["Ямало-Ненецкий автономный округ", "89"],
            ["Севастополь", "92"],
            ["Байконур", "94"],
            ["Чеченская республика", "95"]
        ];


        $result = [];
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        foreach ($items as $value) {
            
            $converter = array(
                'а' => 'a',    'б' => 'b',    'в' => 'v',    'г' => 'g',    'д' => 'd',
                'е' => 'e',    'ё' => 'e',    'ж' => 'zh',   'з' => 'z',    'и' => 'i',
                'й' => 'y',    'к' => 'k',    'л' => 'l',    'м' => 'm',    'н' => 'n',
                'о' => 'o',    'п' => 'p',    'р' => 'r',    'с' => 's',    'т' => 't',
                'у' => 'u',    'ф' => 'f',    'х' => 'h',    'ц' => 'c',    'ч' => 'ch',
                'ш' => 'sh',   'щ' => 'sch',  'ь' => '',     'ы' => 'y',    'ъ' => '',
                'э' => 'e',    'ю' => 'yu',   'я' => 'ya',   '(' => '',     ')' => '',
                ',' => '',     '.' => '',     '-' => '',     ';' => '/',
            );

            $translit = mb_strtolower($value[0]);
            $translit = strtr($translit, $converter);
            $translit = mb_ereg_replace('[^-0-9a-z]', '-', $translit);
            $translit = mb_ereg_replace('[-]+', '-', $translit);
            $translit = trim($translit, '-');

            $result[] = [
                'id' => $value[1],
                'name' => $value[0],
                'name_translit' => $translit,
            ];
            
            $regions = new Regions();

            $regions->id = $value[1];
            $regions->name = $value[0];
            $regions->name_translit = $translit;

            $regions->save();
        }

        return $result;
    }

}
