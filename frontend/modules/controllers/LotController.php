<?php

namespace frontend\modules\controllers;

use common\models\db\Order;
use common\models\db\Region;
use common\models\db\Report;
use frontend\modules\forms\ReportForm;
use frontend\modules\models\Category;
use frontend\modules\forms\OrderForm;
use frontend\modules\components\ReportService;
use Yii;
use common\models\db\SearchQueries;
use common\models\db\Lot;
use common\models\db\WishList;
use frontend\modules\models\LotSearch;
use frontend\modules\models\MapSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * LotController implements the CRUD actions for Lot model.
 */
class LotController extends Controller
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    /**
     * Lists all Lot models.
     * @param string $type
     * @param string $category
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex($type = 'all', $category = 'lot-list')
    {
        $searchModel = new LotSearch();
        $queryParams = Yii::$app->request->queryParams;
        $url = '';

        if ($queryParams[ 'LotSearch' ][ 'type' ] !== null && $queryParams[ 'LotSearch' ][ 'mainCategory' ] !== null) {
            switch ($queryParams[ 'LotSearch' ][ 'type' ]) {
                case '1':
                    $t = 'bankrupt';
                    break;
                case '2':
                    $t = 'arrest';
                    break;
                case '3':
                    $t = 'zalog';
                    break;
                case '4':
                    $t = 'municipal';
                    break;
                default:
                    $t = 'all';
                    break;
            }

            $url .= "/$t";

            if ($queryParams[ 'LotSearch' ][ 'mainCategory' ] == 0) {
                $url .= "/lot-list";
            } else {
                $cat = Category::find()->where(['id' => $queryParams[ 'LotSearch' ][ 'mainCategory' ]])->one();
            }

            if ($cat) {
                $url .= "/$cat->slug";
            }

            unset($queryParams[ 'LotSearch' ][ 'type' ]);
            unset($queryParams[ 'LotSearch' ][ 'mainCategory' ]);
            return $this->redirect([$url, 'LotSearch' => $queryParams[ 'LotSearch' ]]);
        }

        if ($queryParams[ 'LotSearch' ][ 'type' ] !== null) {
            switch ($queryParams[ 'LotSearch' ][ 'type' ]) {
                case '1':
                    $t = 'bankrupt';
                    break;
                case '2':
                    $t = 'arrest';
                    break;
                case '3':
                    $t = 'zalog';
                    break;
                case '4':
                    $t = 'municipal';
                    break;
                default:
                    $t = 'all';
                    break;
            }

            if ($t) {
                $url = "/$t/$category";
                unset($queryParams[ 'LotSearch' ][ 'type' ]);
                return $this->redirect([$url, 'LotSearch' => $queryParams[ 'LotSearch' ]]);
            }
        }

        if ($queryParams[ 'LotSearch' ][ 'mainCategory' ] !== null) {

            if ($queryParams[ 'LotSearch' ][ 'mainCategory' ] == 0) {
                $url = "/$type/lot-list";
                unset($queryParams[ 'LotSearch' ][ 'mainCategory' ]);
                return $this->redirect([$url, 'LotSearch' => $queryParams[ 'LotSearch' ]]);
            }

            $cat = Category::find()->where(['id' => $queryParams[ 'LotSearch' ][ 'mainCategory' ]])->one();
            if ($cat) {
                $url = "/$type/$cat->slug";
                unset($queryParams[ 'LotSearch' ][ 'mainCategory' ]);
                return $this->redirect([$url, 'LotSearch' => $queryParams[ 'LotSearch' ]]);
            }
        }

        switch ($type) {
            case 'bankrupt':
                $titleType = 'Банкротное имущество';
                $searchModel->type = 1;
                break;
            case 'arrest':
                $titleType = 'Арестованное имущество';
                $searchModel->type = 2;
                break;
            case 'zalog':
                $titleType = 'Имущество организаций';
                $searchModel->type = 3;
                break;
            case 'municipal':
                $titleType = 'Муниципальное имущество';
                $searchModel->type = 4;
                break;
            default:
                $titleType = 'Все виды иммущества';
                $searchModel->type = 0;
                break;
        }

        if ($category == 'lot-list') {
            $titleCategory = 'Все лоты';
            $url = "/$type/$category";
        } else if (!empty($items = Category::find()->where(['slug' => $category, 'depth' => 1])->one())) {
            $searchModel->mainCategory[] = $items->id;
            $titleCategory = $items->name;
            $url = "/$type/$category";
        } else {
            Yii::$app->response->statusCode = 404;
            throw new \yii\web\NotFoundHttpException;
        }

        $dataProvider = $searchModel->search($queryParams);


        Yii::$app->params[ 'breadcrumbs' ][] = [
            'label'    => ' ' . $titleType,
            'template' => '<li class="breadcrumb-item active" aria-current="page">{link}</li>',
            'url'      => ["/$type"]
        ];
        if ($category != null) {
            Yii::$app->params[ 'breadcrumbs' ][] = [
                'label'    => ' ' . $titleCategory,
                'template' => '<li class="breadcrumb-item active" aria-current="page">{link}</li>',
                'url'      => ["/$type/$category"]
            ];
        }

        $lots = $dataProvider->getModels();

        if (Yii::$app->request->isAjax) {
            return $this->renderPartial('lotBlockAjax', [
                'type' => 'long',
                'lots' => $lots,
                'url'  => $url,
            ]);
        }

        $regionList = ArrayHelper::map(Region::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name');

        return $this->render('index', [
            'model'         => $searchModel,
            'lots'          => $lots,
            'queryCategory' => 0,
            'type'          => 'bankrupt',
            'regionList'    => $regionList,
            'url'           => $url,
            'offsetStep'    => Yii::$app->params[ 'defaultPageLimit' ]
        ]);
    }

    /**
     * Displays a single Lot model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $type = 'all', $category = 'lot-list')
    {

        $model = $this->findModel($id, $type, $category);

        switch ($type) {
            case 'bankrupt':
                $titleType = 'Банкротное имущество';
                break;
            case 'arrest':
                $titleType = 'Арестованное имущество';
                break;
            case 'zalog':
                $titleType = 'Имущество организаций';
                break;
            case 'municipal':
                $titleType = 'Муниципальное имущество';
                break;
            default:
                $titleType = 'Все виды иммущества';
                break;
        }

        $subCat = [];

        if ($category == 'lot-list') {
            $url = "/$type/$category";
        } else if (!empty($cat = Category::find()->where(['slug' => $category])->one())) {
            $titleCategory = $cat->name;
//            $subCategories = Category::findOne(['id' => $cat->id]);
//            $leaves = $subCategories->leaves()->all();

//            if ($leaves != null) {
//                foreach ($leaves as $value) {
//                    $result .= '<option value="' . $value->id . '">' . $value->name . '</option>';
//                }
//            }

            $url = "/$type/$category";
        } else {
            Yii::$app->response->statusCode = 404;
            throw new \yii\web\NotFoundHttpException;
        }

        Yii::$app->params[ 'breadcrumbs' ][] = [
            'label'    => ' ' . $titleType,
            'template' => '<li class="breadcrumb-item active" aria-current="page">{link}</li>',
            'url'      => ["/$type"]
        ];
        if ($category != 'lot-list') {
            Yii::$app->params[ 'breadcrumbs' ][] = [
                'label'    => ' ' . $titleCategory,
                'template' => '<li class="breadcrumb-item active" aria-current="page">{link}</li>',
                'url'      => ["/$type/$category"]
            ];

//            if (count($model->categories) > 0) {
//                Yii::$app->params[ 'breadcrumbs' ][] = [
//                    'label'    => ' ' . $model->categories[ 0 ]->name,
//                    'template' => '<li class="breadcrumb-item active" aria-current="page">{link}</li>',
//                    'url'      => ["/$type/$category/{$model->categories[0]->slug}"]
//                ];
//            }
        }
        Yii::$app->params[ 'breadcrumbs' ][] = [
            'label'    => ' ' . ((Yii::$app->params[ 'h1' ]) ? Yii::$app->params[ 'h1' ] : mb_substr($model->title, 0, 40) . '...'),
            'template' => '<li class="breadcrumb-item" aria-current="page">{link}</li>',
            'url'      => "javascript:void(0)"
        ];

        $model->trigger(Lot::EVENT_VIEWED);

        return $this->render('view', [
            'lot'  => $model,
            'type' => 'bankrupt',
            'url'  => $url
        ]);
    }

    public function actionLoadSubCategories()
    {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();

            $subCategories = Category::findOne(['id' => $post[ 'id' ]]);
            $leaves = $subCategories->leaves()->all();

            $result = '<option value="0">Все подкатегории</option>';
            if ($leaves != null) {
                foreach ($leaves as $value) {
                    $result .= '<option value="' . $value->id . '">' . $value->name . '</option>';
                }
            }

            return $result;
        }
    }

    /**
     * Finds the Lot model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Lot|null
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = Lot::findOne($id);

        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSaveSearch()
    {
        $searchSave = new SearchQueries();

        $searchSave->user_id = Yii::$app->user->id;
        $searchSave->url = Yii::$app->request->queryParams[ 'url' ];
        // $searchSave->send_email = (Yii::$app->request->queryParams['send_email'] === 'true')? true: false;
        $searchSave->getFirstSave();

        return $searchSave->save();
    }

    public function actionWishListEdit()
    {
        if (!Yii::$app->user->isGuest) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $wishListCheck = WishList::find()->where(['lot_id' => Yii::$app->request->queryParams[ 'lotId' ], 'user_id' => \Yii::$app->user->id])->one();

            if ($wishListCheck->lot_id) {
                return ['method' => 'delete', 'status' => $wishListCheck->delete()];
            } else {
                $wishList = new WishList();

                $wishList->lot_id = Yii::$app->request->queryParams[ 'lotId' ];
                $wishList->user_id = \Yii::$app->user->id;

                return ['method' => 'save', 'status' => $wishList->save()];
            }
        } else {
            return $this->goHome();
        }
    }

    public function actionMap()
    {
        $searchModel = new MapSearch();

        $searchModel->load(Yii::$app->request->get());

        Yii::$app->params[ 'title' ] = 'Карта';

        return $this->render('map', [
            'model'         => $searchModel,
            'queryCategory' => 0,
            'type'          => 'bankrupt',
        ]);
    }

    public function actionMapAjax()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $post = Yii::$app->request->post();

        $searchModel = new MapSearch();

        $dataProvider = $searchModel->search($post);
        $places = $dataProvider->getModels();

        return $places;
    }

    public function actionMapLotAjax()
    {
        $post = Yii::$app->request->post();

        $lots = Lot::find()
            ->where(['in', 'id', $post[ 'ids' ]])
            ->limit($post[ 'limit' ])
            ->offset($post[ 'offset' ])
            ->all();

        return $this->renderAjax("mapLotAjax", ['lots' => $lots]);
    }

    public function actionOrderSave()
    {

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (!Yii::$app->user->isGuest) {

            $form = new OrderForm();
            $model = new Order();
            $post = Yii::$app->request->post()[ 'OrderForm' ];

            $form->loadFields($model, $post);

            return $model->save();
        }

        return false;
    }

    public function actionInvoice()
    {

        $rs = new ReportService();
        $form = new ReportForm();

        if (Yii::$app->request->isPost) {
            $form->load(Yii::$app->request->post());

            if ($form->validate()) {

                $returnUrl = Url::toRoute([
                    '/lot/purchase/success',
                    'fromUrl' => $form->returnUrl,
                ], []);

                try {
                    $res = $rs->invoiceCreate($form->userId, $form->cost, $form->reportId, $returnUrl);
                } catch (\Exception $e) {
                    return $this->redirect($form->returnUrl); //TODO fix
                }

                if ($res) {
                    return $this->redirect($rs->getPaymentUrl());
                }
            }

            return $this->redirect($form->returnUrl); //TODO fix
        }


    }
}
