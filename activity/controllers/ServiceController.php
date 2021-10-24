<?php

namespace app\controllers;

use app\components\GetParamsFromRequest;
use app\forms\RequestSaveForm;
use app\services\ListRequestsService;
use app\services\RequestSaveService;
use JsonRpc2\Exception;
use Yii;
use yii\filters\Cors;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;

class ServiceController extends Controller
{
    /** @var bool  */
    public $enableCsrfValidation = false;

    public $layout = false;

    /** @var string[] разрешенные сайты для REST API */
    const CORS_ACCESS = [
        'http://landing.local',
    ];

    /** @var RequestSaveService  */
    private RequestSaveService $requestSaveService;
    /** @var GetParamsFromRequest  */
    private GetParamsFromRequest $getParamsFromRequest;
    /** @var ListRequestsService  */
    private ListRequestsService $listRequestsService;

    /**
     * @return array|array[]
     */
    public function behaviors()
    {
         $corsFilter = [
            'corsFilter' => [
                'class' => Cors::class,
                'cors' => [
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Request-Method' => ['OPTIONS', 'POST'],
                    'Access-Control-Allow-Origin' => !YII_DEBUG ? self::CORS_ACCESS : [Yii::$app->request->origin],
                    'Origin' => !YII_DEBUG ? self::CORS_ACCESS : [Yii::$app->request->origin],
                    'access-control-max-age' => YII_DEBUG ? -1 : 60 * 10,
                ],
            ],
        ];

         return array_merge($corsFilter, parent::behaviors());
    }

    /**
     * @return \string[][]
     */
    public function actions()
    {
        return [
            'options' => [
                'class' => 'yii\rest\OptionsAction',
            ],
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @param $id
     * @param $module
     * @param RequestSaveService $requestSaveService
     * @param GetParamsFromRequest $getParamsFromRequest
     * @param ListRequestsService $listRequestsService
     * @param array $config
     */
    public function __construct(
        $id,
        $module,
        RequestSaveService $requestSaveService,
        GetParamsFromRequest $getParamsFromRequest,
        ListRequestsService $listRequestsService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->requestSaveService = $requestSaveService;
        $this->getParamsFromRequest = $getParamsFromRequest;
        $this->listRequestsService = $listRequestsService;
    }

    /**
     * @param string $url
     * @param string $date
     * @return Exception|string[]
     * @throws BadRequestHttpException
     */
    public function actionRequestSave(string $url, string $date)
    {
        $requestSave = new RequestSaveForm(['url' => $url, 'date' => $date]);
        if (!$requestSave->validate()) {
            throw new BadRequestHttpException("Not correct attributes");
        }

        return $this->requestSaveService->save($requestSave);
    }

    /**
     * @return array|object
     * @throws \yii\base\InvalidConfigException
     */
    public function actionListRequests()
    {
        return $this->listRequestsService->create();
    }

    /**
     * @return \string[][]
     */
    protected function verbs()
    {
        return [
            'requestSave' => ['POST', 'OPTIONS'],
            'listRequests' => ['POST', 'OPTIONS'],
        ];
    }
}
