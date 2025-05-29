<?php

declare(strict_types=1);

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\ShortLink;
use app\models\Visit;
use app\service\ShortLinkService;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'ajax-validation' => ['POST'],
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
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new ShortLink(['scenario' => ShortLink::SCENARIO_CREATE]);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $service = new ShortLinkService();
            $res = [
                'status' => 'wrong',
                'qr' => '',
                'link' => ''
            ];
            if ($service->saveLink($model)) {
                $res['status'] = 'ok';
                $res['link'] = 'Созданная короткая ссылка: ' . Html::a(Html::encode($model->getShortUrl()), $model->getShortUrl(), ['target' => '_blank']);
                $res['qr'] = 'Qr код: <img src="'.(new \chillerlan\QRCode\QRCode())->render($model->getShortUrl()).'" alt="QR Code" width="300" />';
            } else {
                $error = 'Не получилось сохранить ссылку, ошибки -  ' . implode(', ', $model->getErrorSummary(true));
                Yii::error($error);

            }
            return $res;
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionAjaxValidation()
    {
        $model = new ShortLink(['scenario' => ShortLink::SCENARIO_CREATE]);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }

    /**
     * Переход по короткой ссылке
     *
     * @return string
     */
    public function actionSl($alias)
    {
        if ($model = ShortLink::findOne(['short_url' => $alias])) {
            $db = Yii::$app->db;
            $transaction = $db->beginTransaction();
            try {
                $model->updateCounters(['view_count' => 1]);
                $visit = new Visit();
                $visit->setIpFromString(Yii::$app->request->userIP);
                $visit->link('slink', $model);
                $transaction->commit();
            } catch (\Throwable $e) {
                $transaction->rollBack();
                Yii::error('Не удалось выполнить транзакцию по переходе по ссылке');
                throw $e;
            }
            return $this->redirect($model->long_url);
        }
        throw new NotFoundHttpException();
    }


}
