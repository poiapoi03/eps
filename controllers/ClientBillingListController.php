<?php

namespace app\controllers;

use Yii;
use app\models\BillingList;
use app\models\BillingListSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use kartik\mpdf\Pdf;
use Crazymeeks\Foundation\PaymentGateway\Dragonpay;
use Crazymeeks\Foundation\PaymentGateway\Options\Processor;

/**
 * BillingListController implements the CRUD actions for BillingList model.
 */
class ClientBillingListController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionOnlinePayment($guid)
    {
        $model = \app\models\BillingList::findOne(['guid'=>$guid]);

        $parameters = [
            //'txnid' => rand(1,9999), # Varchar(40) A unique id identifying this specific transaction from the merchant site
            'txnid' => 'FB-BS-'.rand(10000,99999), # Varchar(40) A unique id identifying this specific transaction from the merchant site
            // 'amount' => $model->computeDueAmount($model->id), # Numeric(12,2) The amount to get from the end-user (XXXX.XX)
            'amount' => 1, # Numeric(12,2) The amount to get from the end-user (XXXX.XX)
            'ccy' => 'PHP', # Char(3) The currency of the amount
            'description' => 'PROGRESS BILLING No. ' . $model->billing_no, # Varchar(128) A brief description of what the payment is for
            'email' => $model->project->client->email, # Varchar(40) email address of customer
            'param1' =>$model->bs_ref_no, # Varchar(80) [OPTIONAL] value that will be posted back to the merchant url when completed
            'param2' =>$model->project->project_ref_id, # Varchar(80) [OPTIONAL] value that will be posted back to the merchant url when completed

        ];


        $merchant_account = [
              'merchantid' => 'FORTBUILDERS',
              'password'   => 'Anv31af7q8y6JCj'
        ];
        // Initialize Dragonpay
        $dragonpay = new Dragonpay($merchant_account);
        // Set parameters, then redirect to dragonpay
        
        // $dragonpay->setParameters($parameters)
        //             //  ->withProcid(Processor::SM_PAYMENT_COUNTERS)
        //             ->away();
        try {
            $dragonpay->setParameters($parameters)->away();
        } catch(PaymentException $e){
            echo $e->getMessage();exit;
        } catch(\Exception $e){
            echo $e->getMessage();
        }

    }

    public function actionReturlUrl()
    {
        $model = \app\models\BillingList::findOne(['bs_ref_no'=>$_GET['param1']]);

        return $this->redirect(['view', 'id' => $model->guid]);
    }

    public function actionSendEmail($blid)
    {
        $model = \app\models\BillingList::findOne(['guid'=>$blid]);

        Yii::$app->mailer->compose('_notification',['model'=>$model])
        ->setFrom('gtateam2019@gmail.com')
        ->setTo('arguelles.rolan1@gmail.com')
        ->setSubject('Billing Statement Notice - Billing Statement #'.$model->billing_no)
        ->send();
        $model->emailed = 1;
        $model->save(false);

        Yii::$app->session->setFlash('success', "Email Notification Sent for Billing Statement # ".$model->billing_no.".");

        return $this->redirect(['index', 'pid' => $model->project->guid]);
    }

    public function actionPrintBillingStatement($blid)
    {
           // $model = $this->findModel($id);
           Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
           $model = $this->findModel(['guid'=>$blid]);
               
           $pdf = new Pdf([
               'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
               'destination' => Pdf::DEST_BROWSER,
               'content' => $this->renderPartial('_statement',['model'=>$model]),
               'options' => [
                   // any mpdf options you wish to set
               ],
               'methods' => [
                   'SetTitle' => '',
                   'SetSubject' => 'Generating PDF files via yii2-mpdf extension has never been easy',
                   //'SetHeader' => ['Krajee Privacy Policy||Generated On: ' . date("r")],
                   'SetFooter' => ['|Page {PAGENO} of {nb}|'],
                   //'SetAuthor' => 'Kartik Visweswaran',
                   //'SetCreator' => 'Kartik Visweswaran',
                   //'SetKeywords' => 'Krajee, Yii2, Export, PDF, MPDF, Output, Privacy, Policy, yii2-mpdf',
               ]
           ]);
           return $pdf->render();
    }

    /**
     * Lists all BillingList models.
     * @return mixed
     */
    public function actionIndex($pid)
    {    
        $model = \app\models\ProjectList::findOne(['guid'=>$pid]);
        $searchModel = new BillingListSearch();
        $dataProvider = $searchModel->searchByClient(Yii::$app->request->queryParams, $model->id);

        return $this->render('index', [
            'model'=>$model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single BillingList model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $model = $this->findModel2($id);
        $searchModel = new \app\models\BillingDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $model->id);

        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "BillingList #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Creates a new BillingList model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($pid)
    {
        $project = \app\models\ProjectList::findOne(['guid'=>$pid]);
        $request = Yii::$app->request;
        $model = new BillingList();
        $model->project_list_id = $project->id;  

        $bill_count = \app\models\BillingList::find()->where(['project_list_id'=>$project->id, 'is_active'=>1])->count();

        $model->billing_no = $bill_count + 1;
        $model->billing_date = date('Y-m-d');

        $sysSettings = \app\models\SystemSettings::findOne(1);

        $model->prepared_by = $sysSettings->prepared_by . ' - ' .  $sysSettings->prepared_by_position;
        $model->noted_by = $sysSettings->noted_by . ' - ' .  $sysSettings->noted_by_position;
        $model->checked_by = $sysSettings->checked_by . ' - ' .  $sysSettings->checked_by_position;

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Create new Billing Statement",
                    'size'=>'large',
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new Billing Statement",
                    'size'=>'large',
                    'content'=>'<span class="text-success">Create BillingList success</span>',
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Create new Billing Statement",
                    'size'=>'large',
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing BillingList model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);       

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update BillingList #".$id,
                    'size'=>'large',
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "BillingList #".$id,
                    'size'=>'large',
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Update BillingList #".$id,
                    'size'=>'large',
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing BillingList model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $model =  $this->findModel($id);
        Yii::$app->db->createCommand('DELETE FROM billing_details WHERE billing_list_id = '. $model->id)->query();
        $model->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

     /**
     * Delete multiple existing BillingList model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete()
    {        
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
       
    }

    /**
     * Finds the BillingList model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BillingList the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BillingList::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModel2($id)
    {
        if (($model = BillingList::findOne(['guid'=>$id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
