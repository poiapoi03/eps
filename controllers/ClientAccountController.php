<?php

namespace app\controllers;
use app\models\ProjectListSearch;
use app\models\ProjectList;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use Yii;

class ClientAccountController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $searchModel = new ProjectListSearch();
        $dataProvider = $searchModel->searchByCLient(Yii::$app->request->queryParams, Yii::$app->user->identity->client->id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {   
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "ProjectList #".$model->project_ref_id,
                    'content'=>$this->renderAjax('project_view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('project_view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    protected function findModel($id)
    {
        if (($model = ProjectList::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
