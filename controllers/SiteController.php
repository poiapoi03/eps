<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use Crazymeeks\Foundation\PaymentGateway\Dragonpay;
use Crazymeeks\Foundation\PaymentGateway\Dragonpay\Token;
use Crazymeeks\Foundation\PaymentGateway\Options\Processor;


use Coreproc\Dragonpay\DragonpayClient;
use Coreproc\Dragonpay\Checkout;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
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

    public function actionTest()
    {
        Yii::$app->mailer->compose()
        ->setFrom('gtateam2019@gmail.com')
        ->setTo('arguelles.rolan1@gmail.com')
        ->setSubject('Message subject')
        ->setTextBody('Plain text content')
        ->send();
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
     * @return string
     */
    public function actionIndex()
    {
        if(!Yii::$app->user->isGuest){

             return $this->render('index');
        }
		else{
             return $this->redirect(['user/login']);
        }
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionTestPay()
    {
        $parameters = [
            'txnid' => rand(1,99999), # Varchar(40) A unique id identifying this specific transaction from the merchant site
            'amount' => 1, # Numeric(12,2) The amount to get from the end-user (XXXX.XX)
            'ccy' => 'PHP', # Char(3) The currency of the amount
            'description' => 'Test', # Varchar(128) A brief description of what the payment is for
            'email' => 'some@merchant.ph', # Varchar(40) email address of customer
            'param1' => 'param1', # Varchar(80) [OPTIONAL] value that will be posted back to the merchant url when completed
            'param2' => 'param2', # Varchar(80) [OPTIONAL] value that will be posted back to the merchant url when completed

        ];


        $merchant_account = [
              'merchantid' => 'FORTBUILDERS',
              'password'   => 'Anv31af7q8y6JCj'
        ];
        // Initialize Dragonpay
        $dragonpay = new Dragonpay($merchant_account);
        // Set parameters, then redirect to dragonpay
        $dragonpay->setParameters($parameters)
                    // ->withProcid(Processor::GCASH)
                    ->away();
    }

    public function actionTestPayTwo()
    {
        $credentials = [
            'merchantId'        => 'FORTBUILDERS',
            'merchantPassword'  => 'Anv31af7q8y6JCj',
        ];
        
        $client = new DragonpayClient($credentials);
        
        $checkout = new Checkout($client);
        
        $params = [
            'transactionId' => rand(1000,9999),
            'amount'        => '1.00',
            'currency'      => 'PHP',
            'description'   => 'Playstation 4',
            'email'         => 'john@example.com',
        ];
        
        $url = $checkout->getUrl($params);
        
        $checkout->redirect($params);
    }
}
