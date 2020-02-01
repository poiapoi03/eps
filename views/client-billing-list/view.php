<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BillingList */
$this->title = 'Project Billing Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= \yii\helpers\Html::a('<i class="fa fa-arrow-left fa-fw"></i>Back', ['/client-billing-list','pid'=>$model->project->guid],['class'=>'btn btn-danger pull-right']); ?>
<div class="clearfix"></div><br>

<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            #'id',
            #'guid',
            // [                     
            //     'label' => 'Client',
            //     'value' => $model->client->company_name . '<br>' .$model->client->client_name,
            //     'format'=>'html'
            // ],
            [
                'label' => 'Billing #',
                'value' => $model->billing_no,
            ],
            [
                'label' => 'Date of Billing',
                'value' => $model->billing_date,
            ],
            'project.project_title:ntext',
            [                      
                'label' => 'Total amount due for this billing',
                'value' => $model->computeDueAmount($model->id),
                'format'=>['decimal',2]
            ],
        
        ],
    ]) ?>
<?php $hideButtons = $model->bill_status_id == 2 ? '': 'hidden'; ?>
<div class="billing-details-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
           // 'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns_details.php'),
            'toolbar'=> [
                ['content'=>//'',
                 
                    Html::a('<i class="fa fa-print"></i> Print Billing Statement', ['print-billing-statement','blid'=>$model->guid],
                    ['target'=>'_blank','title'=> 'Print Statement','class'=>'btn btn-primary btn-lg','data-pjax'=>0]) 
                    
                  
                    // .
                    // Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                    // ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Reset Grid']).
                    // '{toggleData}'.
                    // '{export}'
                ],
            ],          
            'striped' => true,
            'condensed' => true,
            'responsive' => true,          
            'panel' => [
                'type' => 'primary', 
                'heading' => '<i class="glyphicon glyphicon-list"></i> Billing Statement Details',
                'after'=>'<h3>Total Amount Due: ' . number_format($model->computeDueAmount($model->id),2) .'</h3>'.
                     Html::a('<i class="fa fa-print"></i> Pay Online', ['online-payment','guid'=>$model->guid],
                    ['data-confirm'=>'You will be redirected to our online payment provider, continue?','title'=> 'Go to online payment portal','class'=>'btn btn-success btn-lg '.$hideButtons,'data-pjax'=>0]) .
                    Html::img('/images/dp-logo.png',['height'=>'70px','class'=>$hideButtons])
                ,
                // 'after'=>BulkButtonWidget::widget([
                //             'buttons'=>Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp; Delete All',
                //                 ["bulk-delete"] ,
                //                 [
                //                     "class"=>"btn btn-danger btn-xs",
                //                     'role'=>'modal-remote-bulk',
                //                     'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                //                     'data-request-method'=>'post',
                //                     'data-confirm-title'=>'Are you sure?',
                //                     'data-confirm-message'=>'Are you sure want to delete this item'
                //                 ]),
                //         ]).                        
                        '<div class="clearfix">
                     
                        </div>',
            ]
        ])?>
    </div>
</div>
